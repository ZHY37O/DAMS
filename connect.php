<?php
$servername = "";
$username = "root";
$password = ''; // todo: fetch from environment

$port = 4056;
$dbname = 'dams';
  try {
      //$conn = mysqli_connect("$servername:$port", $username, $password, $dbname);
      
      $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password, array (PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false));
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
