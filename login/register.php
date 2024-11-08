<?php

// include the database connection
require "../includes/pdo_db.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

  // retrieve and sanitize form data
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  $password = trim($_POST['password']);

  // show error message if the email is not in correct format
  if (!$email) {
    header("Location: index.php?success=false&message=invalid_email");
    exit;
  }

  // basic validation 

  if (empty($username) || empty($email) || empty($password)) {

    echo "All fields are required!";

    exit();
  }

  try {
    $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $count = $stmt->fetchColumn();

    if ($count > 0) {
      header("Location: index.php?success=false&message=user_exist");
      exit;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
