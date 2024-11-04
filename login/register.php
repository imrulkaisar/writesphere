<?php

// include the database connection
require "../includes/pdo_db.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

  // retrieve and sanitize form data
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $password = trim($_POST['password']);

  // basic validation 

  if (empty($username) || empty($email) || empty($password)) {

    echo "All fields are required!";

    exit();
  }

  $hashed_password = password_hash($password, PASSWORD_BCRYPT);


  try {
    // Prepare an SQL statement to insert the user into the database
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);

    // bind the parameters to the statements
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashed_password);

    // Execute the statement
    $stmt->execute();

    header("Location: index.php?success=true&message=registered");

    exit;
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
