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
    <div class="flex">
      <h2>All Users</h2>
      <a href="add-new.php" class="button">Add new user</a>
    </div>
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
              <?php
              if ($_SESSION['role'] === 'admin' && $user['id'] !== $_SESSION['user_id']) {
                echo "<a href='edit.php?id=" . $user['id'] . "'>Edit</a>";
                echo " | <a href='delete.php?id=" . $user['id'] . "'>Delete</a>";
              } elseif ($_SESSION['user_id'] === $user['id']) {
                // Regular users can edit only their own profile
                echo "<a href='edit.php?id=" . $user['id'] . "'>Edit</a>";
              }
              ?>
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