<?php
// writesphere/admin/users/index.php
include '../header.php';

// Database connection
require '../../includes/pdo_db.php';

try {
  // Fetch all users from the database
  $sql = "SELECT id, username, email, role, created_at FROM users";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  die();
}
?>

<div class="main-content">
  <header>
    <div class="header-content">
      <h1>User Management</h1>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      </div>
    </div>
  </header>

  <div class="user-table">
    <h2>All Users</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Registration Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
            <td>
              <a href="edit.php?id=<?php echo $user['id']; ?>" class="edit-link">Edit</a> |
              <a href="delete.php?id=<?php echo $user['id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
include '../footer.php';
?>