<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login/login.php');
  exit();
}

// Include configuration and database connection
require '../../config.php';
require BASE_PATH . '/includes/pdo_db.php';

// Get logged-in user's ID and role
$logged_in_user_id = $_SESSION['user_id'];
$logged_in_user_role = $_SESSION['role'];

// Validate the user ID to delete from GET parameters
$user_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$user_id) {
  header("Location: index.php?success=false&message=invalid_user");
  exit;
}

// Ensure only admins can delete users
if ($logged_in_user_role !== 'admin') {
  header("Location: index.php?success=false&message=not_authorized");
  exit;
}

// Prevent admins from deleting their own profile
if ($user_id === $logged_in_user_id) {
  header("Location: index.php?success=false&message=cannot_delete_own_profile");
  exit;
}

try {
  // Prepare and execute the deletion query
  $sql = "DELETE FROM users WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    header("Location: index.php?success=true&message=user_deleted");
    exit;
  }
} catch (PDOException $e) {
  header("Location: index.php?success=false&message=database_error&text=" . urlencode($e->getMessage()));
  exit;
}
