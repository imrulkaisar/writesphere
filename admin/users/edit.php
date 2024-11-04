<?php
// file excludes
require '../../config.php'; // config file
require BASE_PATH . '/includes/pdo_db.php';
get_admin_header(); // include header

$user_id = isset($_GET['id']) ? $_GET['id'] : NULL;

$error = '';

try {

  $sql = 'SELECT id, username, email, role FROM users WHERE id = :id';
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
  $stmt->execute();

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    header("Location: index.php");
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $username = htmlspecialchars($username);

    $email = trim($_POST['email']);
    $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $role = trim($_POST['role']);
    $role = htmlspecialchars($role);

    if (empty($username) || empty($email) || empty($role)) {

      $error = "All the fields are required.";
    } elseif (!$valid_email) {
      $error = "Invalid email.";
    } else {

      $update_sql = 'UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id';
      $update_stmt = $conn->prepare($update_sql);
      $update_stmt->bindParam(":username", $username);
      $update_stmt->bindParam(":email", $valid_email);
      $update_stmt->bindParam(":role", $role);
      $update_stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

      if ($update_stmt->execute()) {
        header('Location: index.php?success=true&message=updated');
        exit();
      } else {
        $error = "Failed to update user.";
      }
    }
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  exit;
}
?>

<div class="main-content">
  <header>
    <div class="header-content">
      <h1>Edit User</h1>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']);
                        ?></span>
      </div>
    </div>
  </header>

  <div class="form-container">
    <h2>Edit User Details</h2>
    <?php if (isset($error)): ?>
      <p class="error-message"><?php echo htmlspecialchars($error);
                                ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
      </div>

      <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role" required>
          <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
          <option value="author" <?php echo $user['role'] == 'author' ? 'selected' : ''; ?>>Author</option>
          <option value="subscriber" <?php echo $user['role'] == 'subscriber' ? 'selected' : ''; ?>>Subscriber</option>
        </select>
      </div>

      <button type="submit" class="form-button">Update User</button>
    </form>
  </div>
</div>

<?php get_admin_footer(); ?>