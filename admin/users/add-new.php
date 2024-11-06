<?php
// file includes
require '../../config.php'; // config file
require BASE_PATH . '/includes/pdo_db.php';
get_admin_header(); // include header

// Check if the user is allowed to edit
if ($logged_in_user_role !== 'admin') {
  header("Location: index.php?success=false&message=not_authorized");
  exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize user inputs
  $username = trim($_POST['username']);
  $username = htmlspecialchars($username);

  $email = trim($_POST['email']);
  $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);

  $role = trim($_POST['role']);
  $role = htmlspecialchars($role);

  $password = trim($_POST['password']);

  // Password validation: check length and enforce security measures
  if (strlen($password) < 4) {
    $error = "Password must be at least 4 characters long.";
  } elseif (empty($username) || empty($email) || empty($role) || empty($password)) {
    $error = "All fields are required.";
  } elseif (!$valid_email) {
    $error = "Invalid email address.";
  } else {
    // Hash the password only if the password is validated correctly
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
      // Check if username or email already exists
      $check_sql = "SELECT COUNT(*) FROM users WHERE username = :username OR email = :email";
      $check_stmt = $conn->prepare($check_sql);
      $check_stmt->bindParam(":username", $username);
      $check_stmt->bindParam(":email", $valid_email);
      $check_stmt->execute();

      $count = $check_stmt->fetchColumn();

      if ($count > 0) {
        $error = "This username or email is already used by another user. Please try a different one.";
      } else {
        // Insert new user
        $sql = "INSERT INTO users (username, email, role, password) VALUES (:username, :email, :role, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $valid_email);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":password", $hashed_password);

        // Execute the SQL insert
        if ($stmt->execute()) {
          header("Location: index.php?success=true&message=added");
          exit;
        } else {
          $error = "Something went wrong! Please try again.";
        }
      }
    } catch (PDOException $e) {
      $error = $e->getMessage();
    }
  }
}
?>

<div class="main-content">
  <header>
    <div class="header-content">
      <h1>Add a new user</h1>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      </div>
    </div>
  </header>

  <div class="form-container">
    <h2>Add new user</h2>
    <?php if (!empty($error)): ?>
      <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role" required>
          <option value="admin">Admin</option>
          <option value="author">Author</option>
          <option value="subscriber">Subscriber</option>
        </select>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" minlength="4" required>
      </div>

      <button type="submit" class="form-button">Add User</button>
    </form>
  </div>
</div>

<?php get_admin_footer(); ?>