<!-- index.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login and Registration - WriteSphere</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <!-- Sign In Form -->
    <div class="form-container sign-in-container">
      <form action="login.php" method="POST">
        <h2>Sign In</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <a href="#">Forgot your password?</a>
        <button type="submit">Sign In</button>
      </form>
    </div>

    <!-- Sign Up Form -->
    <div class="form-container sign-up-container">
      <form action="register.php" method="POST">
        <h2>Create Account</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
      </form>
    </div>

    <!-- Overlay Section -->
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2>Welcome Back!</h2>
          <p>To keep connected with us, please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h2>Hello, Friend!</h2>
          <p>Enter your personal details and start your journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>