<?php
// Database credentials for local environment
$server = 'localhost';
$username = 'root';
$password = 'mysql';
$dbname = 'writesphere';

$dsn = "mysql:host=$server;dbname=$dbname;charset=utf8mb4";


try {

  // create a new PDO instance
  $conn = new PDO($dsn, $username, $password);

  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // echo "Database Connected successfully!";
} catch (PDOException $e) {

  // Catch any errors during the connection
  die("Error establish database connection: " .  $e->getMessage());
}
