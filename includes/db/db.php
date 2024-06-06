<?php

  // $servername = "localhost";
  // $dbusername = "root";
  // $dbpassword = "";
  // $db         = "iverify";

  $servername = "localhost";
  $dbusername = "gamingb3_iverify";
  $dbpassword = "1FjqEdr173";
  $db         = "gamingb3_iverify";


  $conn = mysqli_connect($servername, $dbusername, $dbpassword, $db);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
