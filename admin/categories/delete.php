<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login/login.php');
  exit();
}

// File includes
require "../../config.php";
require BASE_PATH . "/includes/pdo_db.php";

// Check if the current user is an admin
$logged_in_user_role = $_SESSION['role'];

if ($logged_in_user_role != 'admin') {
  header("Location: index.php?success=false&message=not_authorized");
  exit();
}

// Check if the category ID is available
$cat_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$cat_id) {
  header("Location: index.php?success=false&message=invalid_cat");
  exit();
}

try {
  // Begin the transaction
  $conn->beginTransaction();

  // Check if the category exists
  $check_sql = "SELECT COUNT(*) FROM categories WHERE id = :id";
  $check_stmt = $conn->prepare($check_sql);
  $check_stmt->bindParam(":id", $cat_id, PDO::PARAM_INT);
  $check_stmt->execute(); // Missing execute() fixed here

  $count = $check_stmt->fetchColumn();

  if ($count == 0) {
    // If the category doesn't exist, redirect
    header("Location: index.php?success=false&message=not_exist");
    exit();
  } else {
    // If the category exists, delete it
    $sql = "DELETE FROM categories WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $cat_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      // Commit the transaction after successful deletion
      $conn->commit();
      header("Location: index.php?success=true&message=cat_deleted");
      exit();
    } else {
      // Rollback in case of any failure during deletion
      $conn->rollBack();
      header("Location: index.php?success=false&message=delete_failed");
      exit();
    }
  }
} catch (PDOException $e) {
  // Rollback transaction in case of exception
  $conn->rollBack();
  header("Location: index.php?success=false&message=" . urlencode($e->getMessage()));
  exit();
}
