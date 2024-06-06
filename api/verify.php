<?php

require_once '../includes/db/db.php';                      // Includes database
require_once '../includes/classes/EncryptionHandler.php';  // Handles Cryptography

$response = Array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $encryptedUUID = $_POST['encrypted_uuid'];
    $device_id     = $_POST['device_id'];

    try {

        $publicKeyPath  = '../keys/public_key.pem';
        $privateKeyPath = '../keys/private_key.pem';
        
        $encryptionHandler  = new EncryptionHandler();
        $encryptionHandler->loadKeys($publicKeyPath, $privateKeyPath);

        $productUUID        = $encryptionHandler->decryptData(hex2bin($encryptedUUID));

        //Check if the product is already verified
        $sql    = "SELECT * FROM `products` WHERE `uuid` = '$productUUID'";
        $result = $conn->query($sql);
        if ( $result->num_rows > 0 ){

            $row            = $result->fetch_assoc();

            $generic_id             = $row['generic_id'];
            $batch_id               = $row['batch_id'];
            $expiry                 = $row['expiry'];
            $verification_status    = $row['verification_status'];
            $verification_identity  = $row['verification_identity'];

            $response["generic_id"]             = $generic_id;
            $response["batch_id"]               = $batch_id;
            $response["expiry"]                 = $expiry;
            $response["verification_status"]    = $verification_status;
            $response["verification_identity"]  = $verification_identity;

            // Grab the details
            $sql    = "SELECT * FROM `products_information` WHERE `generic_id` = '$generic_id'";
            $result = $conn->query($sql);
            if ( $result->num_rows > 0 ){

                $row            = $result->fetch_assoc();

                $name           = $row["name"];
                $category       = $row["category"];
                $manufacturer   = $row["manufacturer"];
                $description    = $row["description"];

                $response["name"]           = $name;
                $response["category"]       = $category;
                $response["manufacturer"]   = $manufacturer;
                $response["description"]    = $description;
        
            }

            // If it is the first time
            if ( empty($verification_status) ){

                $response["message"] = "Congratulations on activating the product!.";
                
                //  Set the time zone and get the current date and time
                date_default_timezone_set('Asia/Dhaka');
                $currentDateTime        = new DateTime();
                $formattedDate          = $currentDateTime->format('l, F j, Y g:i A');
                $verification_status    = $formattedDate . ' (GMT+6)';
                $response["details"]    = $verification_status;

                // Update info
                $sql    = "UPDATE `products` SET `verification_status` = '$verification_status' , `verification_identity` = '$device_id' WHERE `uuid` = '$productUUID'";
                $result = $conn->query($sql);
                if (!$result) {
                    $response["message"] = "Critical error 500!";
                    $response["details"] = "Failed to update verification_status due to " . $conn->error;
                }

            } else {
                $response["message"] = "This product has already been verified.";
                $response["details"] = $verification_status;
            }

        } else {
            $response["message"] = "Critical error 404!";
            $response["details"] = "UUID does not seem to exists!";
        }

    } catch (RuntimeException $e) {
        $response["message"] = "Critical error 500!";
        $response["details"] = "Runtime error due to " . $e->getMessage();
    }

    $response = json_encode($response);
    echo base64_encode($response);
}

?>
