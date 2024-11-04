// script.js

// Get elements for switching forms
const signUpButton = document.getElementById("signUp");
const signInButton = document.getElementById("signIn");
const container = document.querySelector(".container");

// Event listener for Sign Up button
signUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

// Event listener for Sign In button
signInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});
