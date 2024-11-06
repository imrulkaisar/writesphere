<?php
// file includes 
require '../../config.php';
require BASE_PATH . "/includes/pdo_db.php";
get_admin_header();

// check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
  header("Location: index.php?success=false&message=not_authorized");
  exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = trim($_POST['name']);
  $name = htmlspecialchars($name);

  $slug = trim($_POST['slug']);
  $slug = htmlspecialchars($slug);

  $description = trim($_POST['description']);
  $description = htmlspecialchars($description);

  // Basic validation 
  if (empty($name) || empty($slug)) {
    $error = "Name and slug are required.";
  } else {
    try {
      $check_sql = "SELECT COUNT(*) FROM categories WHERE slug = :slug";
      $check_stmt = $conn->prepare($check_sql);
      $check_stmt->bindParam(":slug", $slug);
      $check_stmt->execute();

      $count = $check_stmt->fetchColumn();

      if ($count > 0) {
        $error = "This slug is already used by another category. Please try a different one.";
      } else {
        $sql = "INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":slug", $slug);
        $stmt->bindParam(":description", $description);

        if ($stmt->execute()) {
          header("Location: index.php?success=true&message=category_added");
          exit();
        } else {
          $error = "Field to add category.";
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
      <h1>Add New Category</h1>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      </div>
    </div>
  </header>

  <div class="form-container">
    <h2>Create a New Category</h2>
    <?php if (!empty($error)): ?>
      <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
      </div>

      <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description"></textarea>
      </div>

      <button type="submit" class="form-button">Add Category</button>
    </form>
  </div>
</div>

<?php get_admin_footer(); ?>