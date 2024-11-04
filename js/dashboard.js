// // dashboard.js

// document.addEventListener("DOMContentLoaded", () => {
//   // Toggle sidebar visibility (optional feature)
//   const toggleButton = document.querySelector(".toggle-sidebar");
//   const sidebar = document.querySelector(".sidebar");
//   if (toggleButton) {
//     toggleButton.addEventListener("click", () => {
//       sidebar.classList.toggle("collapsed");
//     });
//   }

//   // Example: Display welcome alert on dashboard load
//   const userInfo = document.querySelector(".user-info span");
//   if (userInfo) {
//     const username = userInfo.textContent.trim();
//     alert(`Welcome to your dashboard, ${username}!`);
//   }

//   // Load common parts for the layout
//   loadCommonParts();
// });

// function loadCommonParts() {
//   // Load the header
//   fetch("../admin/header.php")
//     .then((response) => response.text())
//     .then((data) => {
//       document.querySelector("header").innerHTML = data;
//     });

//   // Load the sidebar
//   fetch("../admin/sidebar.php")
//     .then((response) => response.text())
//     .then((data) => {
//       document.querySelector(".sidebar").innerHTML = data;
//     });

//   // Load the footer
//   fetch("../admin/footer.php")
//     .then((response) => response.text())
//     .then((data) => {
//       document.querySelector("footer").innerHTML = data;
//     });
// }
