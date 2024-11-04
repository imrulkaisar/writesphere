<?php
// dashboard.php
include 'header.php';
?>

<!-- Main Content -->
<div class="main-content">
  <header>
    <div class="header-content">
      <h1>Dashboard</h1>
      <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      </div>
    </div>
  </header>

  <div class="dashboard-widgets">
    <div class="widget">
      <i class="fas fa-file-alt widget-icon"></i>
      <div class="widget-info">
        <h3>25</h3>
        <p>Total Posts</p>
      </div>
    </div>

    <div class="widget">
      <i class="fas fa-comments widget-icon"></i>
      <div class="widget-info">
        <h3>48</h3>
        <p>Comments</p>
      </div>
    </div>

    <div class="widget">
      <i class="fas fa-users widget-icon"></i>
      <div class="widget-info">
        <h3>12</h3>
        <p>Users</p>
      </div>
    </div>

    <div class="widget">
      <i class="fas fa-tags widget-icon"></i>
      <div class="widget-info">
        <h3>8</h3>
        <p>Categories</p>
      </div>
    </div>
  </div>

  <div class="recent-activity">
    <h2>Recent Activity</h2>
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Activity</th>
          <th>User</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2024-11-03</td>
          <td>New post created: "PHP Basics for Beginners"</td>
          <td>John Doe</td>
        </tr>
        <tr>
          <td>2024-11-02</td>
          <td>Comment approved on "Introduction to JavaScript"</td>
          <td>Jane Smith</td>
        </tr>
        <tr>
          <td>2024-11-01</td>
          <td>Category added: "Web Development"</td>
          <td>Admin</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php
include 'footer.php';
?>