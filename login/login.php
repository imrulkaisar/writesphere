<?php

// include database connection
require "../includes/pdo_db.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

  $username = trim($_POST['username']);
  $username = htmlspecialchars($username);
  $password = trim($_POST['password']);


  try {
    //prepare an sql statement to select user form the database
    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // verify if user exists and if the password matches
    if ($user && password_verify($password, $user['password'])) {

      // start the session and store the user info
      session_start();
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];

      // redirect to the dashboard
      if ($user['role'] != 'subscriber') {
        header("Location: ../admin/dashboard.php");
        exit;
      } else {
        header("Location: ../");
        exit;
      }
    } else {
      header("Location: index.php?success=false&message=invalid_credential");
      exit;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
