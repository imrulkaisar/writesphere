<?php
// file includes
require '../../config.php';
require BASE_PATH . '/includes/pdo_db.php';
get_admin_header();

// get login user role
$logged_in_user_role = $_SESSION['role'];

$error = "";

try {

  $sql = "SELECT id, name, slug, description FROM categories";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $error = $e->getMessage();
  exit;
}

?>

<div class="main-content">
  <header>
    <div class="header-content">
      <h1>Categories</h1>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      </div>
    </div>
  </header>

  <div class="category-container">
    <div class="flex">
      <h2>Category List</h2>
      <?php if ($logged_in_user_role === 'admin'): ?>
        <a href="add-new.php" class="button add-category-button">Add New Category</a>
      <?php endif; ?>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Slug</th>
          <th>Description</th>
          <?php if ($logged_in_user_role === 'admin'): ?>
            <th>Actions</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $category): ?>
          <tr>
            <td><?php echo htmlspecialchars($category['id']); ?></td>
            <td><?php echo htmlspecialchars($category['name']); ?></td>
            <td><?php echo htmlspecialchars($category['slug']); ?></td>
            <td><?php echo htmlspecialchars($category['description']); ?></td>
            <?php if ($logged_in_user_role === 'admin'): ?>
              <td>
                <a href="edit.php?id=<?php echo $category['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $category['id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php get_admin_footer(); ?>