<?php

// Define a base path for filesystem includes
define('BASE_PATH', __DIR__);

// Function to include the header file
function get_admin_header()
{
  include BASE_PATH . '/admin/header.php';
}

// Function to include the header file
function get_admin_footer()
{
  include BASE_PATH . '/admin/footer.php';
}

// Function to establish the database connection
// function database_connection()
// {
//   include BASE_PATH . '/includes/pdo_db.php';
// }
