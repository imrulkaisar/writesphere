<?php

$server = 'localhost';
$username = 'root';
$password = 'mysql';
$dbname = 'writesphere';


$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error establish database connection: " .  $conn->connect_error);
}


echo "Connect successfully!";
