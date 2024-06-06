<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
        $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

        if ( strcasecmp($username,"Ansary") == 0  && strcasecmp($password, "1234") == 0 )
        {
            echo "Success";
        }
        else
        {
            echo "Invalid username or password!";
        }
    }

?>
