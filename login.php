<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['attempts'] = 0;
}

if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

$maxAttempts = 5;
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $usernamePattern = "/^[a-zA-Z0-9_]{3,15}$/";
    $passwordPattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/";

    $validUsername = "Chael";
    $validPassword = "nonoy123";

    if (empty($username)) {
        $message = "Username is required.";
    } elseif (empty($password)) {
        $message = "Password is required.";
    } elseif ($username === $validUsername && $password === $validPassword) {
        if (preg_match($usernamePattern, $username) && preg_match($passwordPattern, $password)) {
            $message = "Login successful! Redirecting...";
            $_SESSION['attempts'] = 0;
            header("Refresh:2; url=index.php");
            exit;
        } else {
            $message = "Credentials format invalid.";
        }
    } else {
        if ($_SESSION['attempts'] >= $maxAttempts) {
            $message = "Login locked! Too many failed attempts.";
        } elseif (!preg_match($usernamePattern, $username)) {
            $message = "Invalid username format.";
            $_SESSION['attempts']++;
        } elseif (!preg_match($passwordPattern, $password)) {
            $message = "Invalid password format.";
            $_SESSION['attempts']++;
        } else {
            $_SESSION['attempts']++;
            $remaining = $maxAttempts - $_SESSION['attempts'];
            $message = "Invalid credentials. Attempts remaining: $remaining";
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>
  <div class="login-container">
    <h1>Van Gogh Collection</h1>
    <form class="login-form" method="POST" action="">
      <div class="input-box">
        <input type="text" id="username" name="username" placeholder="Username"  />
      </div>
      <div class="input-box">
        <input type="password" id="password" name="password" placeholder="Password"  />
      </div>
      <div class="options">
        <label><input type="checkbox" name="remember" /> Remember me</label>
        <a href="#" class="link-primary">Forgot password</a>
      </div>
      <button 
        type="submit" 
        class="login-btn <?= ($_SESSION['attempts'] >= $maxAttempts) ? 'locked' : ''; ?>" 
        <?= ($_SESSION['attempts'] >= $maxAttempts) ? 'disabled' : ''; ?>>
        Login
      </button>
      <p id="loginMessage" style="color: <?= strpos($message, 'successful') !== false ? 'green' : 'red'; ?>">
        <?= $message ?: "Attempts remaining: " . ($maxAttempts - $_SESSION['attempts']); ?>
      </p>
      <p class="register">Don’t have an account? <a href="register.php">Register</a></p>
    </form>
  </div>
</body>
</html>
