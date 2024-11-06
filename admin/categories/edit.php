<?php

// file includes
require "../../config.php";
require BASE_PATH . "/includes/pdo_db.php";
get_admin_header();

// check if the user is an admin
if ($_SESSION['role'] != 'admin') {
  header("Location: index.php?success=false&message=not_authorized");
  exit();
}

$error = "";

$cat_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$cat_id) {
  header("Location: index.php?success=false&message=invalid_category");
  exit();
} else {

  try {

    $sql = "SELECT name, slug, description FROM categories WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $cat_id, PDO::PARAM_INT);
    $stmt->execute();

    $cat = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    $error = $e->getMessage();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $name = htmlspecialchars($name);

    $slug = trim($_POST['slug']);
    $slug = htmlspecialchars($slug);

    $description = trim($_POST['description']);
    $description = htmlspecialchars($description);

    // check if the slug is already exist

    // basic validation
    if (empty($name) || empty($slug)) {
      $error = "Name and slug are required.";
    } else {

      try {
        $check_sql = "SELECT COUNT(*) FROM categories WHERE slug = :slug";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(":slug", $slug);
        $check_stmt->execute();

        $count = $check_stmt->fetchColumn();

        if ($count > 0 && $slug != $cat['slug']) {
          $error = "This slug is already used by another category. Please try a different one.";
        } else {

          $update_sql = "UPDATE categories SET name = :name, slug = :slug, description = :description WHERE id = :id";
          $update_stmt = $conn->prepare($update_sql);
          $update_stmt->bindParam(":name", $name);
          $update_stmt->bindParam(":slug", $slug);
          $update_stmt->bindParam(":description", $description);
          $update_stmt->bindParam(":id", $cat_id, PDO::PARAM_INT);

          if ($update_stmt->execute()) {
            header("Location: index.php?success=true&message=cat_updated");
            exit;
          } else {
            $error = "Category update field";
          }
        }
      } catch (PDOException $e) {
        $error = $e->getMessage();
      }
    }
  }
}



?>

<div class="main-content">
  <header>
    <div class="header-content">
      <h1>Edit category</h1>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      </div>
    </div>
  </header>

  <div class="form-container">
    <h2>Edit category</h2>
    <?php if (!empty($error)): ?>
      <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required>
      </div>

      <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" value="<?php echo htmlspecialchars($cat['slug']); ?>" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($cat['description']); ?></textarea>
      </div>

      <button type="submit" class="form-button">Update Category</button>
    </form>
  </div>
</div>

<?php get_admin_footer(); ?>