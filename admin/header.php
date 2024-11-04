<?php
// header.php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login/login.php');
  exit();
}

define('BASE_URL', '/writesphere');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - WriteSphere</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/dashboard.css">
</head>

<body>
  <div class="dashboard-container">
    <!-- Sidebar Navigation -->
    <nav class="sidebar">
      <div class="sidebar-header">
        <h2>WriteSphere</h2>
      </div>
      <ul class="nav-list">
        <li><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="#"><i class="fas fa-pencil-alt"></i> Create Post</a></li>
        <li><a href="#"><i class="fas fa-file-alt"></i> My Posts</a></li>
        <li><a href="#"><i class="fas fa-comments"></i> Comments</a></li>
        <li><a href="#"><i class="fas fa-tags"></i> Categories</a></li>
        <li><a href="<?php echo BASE_URL; ?>/admin/users/"><i class="fas fa-users"></i> Users</a></li>
        <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
        <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </nav>