<?php
session_start();

$usernameError = $emailError = $passwordError = $confirmError = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirmPassword = trim($_POST["confirm-password"]);

    $usernamePattern = "/^[a-zA-Z0-9_]{3,15}$/";
    $emailPattern = "/^[\w\.-]+@[\w\.-]+\.\w{2,}$/";
    $passwordPattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

    if (empty($username)) {
        $usernameError = "Please enter your username.";
    } elseif (!preg_match($usernamePattern, $username)) {
        $usernameError = "Invalid username. Use 3–15 letters, numbers, or underscores.";
    }

    if (empty($email)) {
        $emailError = "Please enter your email address.";
    } elseif (!preg_match($emailPattern, $email)) {
        $emailError = "Invalid email format.";
    }

    if (empty($password)) {
        $passwordError = "Please enter your password.";
    } elseif (!preg_match($passwordPattern, $password)) {
        $passwordError = "Password must be at least 8 characters.";
    }

    if (empty($confirmPassword)) {
        $confirmError = "Please confirm your password.";
    } elseif ($password !== $confirmPassword) {
        $confirmError = "Passwords do not match.";
    }

}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="css/login.css" />
</head>
<body>
  <div class="register-container">
    <h1>Register</h1>
    <form class="register-form" method="POST" action="">
      <div class="input-box">
        <input type="text" id="username" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" />
        <?php if ($usernameError): ?><p class="error-message"><?= $usernameError ?></p><?php endif; ?>
      </div>
      <div class="input-box">
        <input type="email" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        <?php if ($emailError): ?><p class="error-message"><?= $emailError ?></p><?php endif; ?>
      </div>
      <div class="input-box">
        <input type="password" id="password" name="password" placeholder="Password" />
        <?php if ($passwordError): ?><p class="error-message"><?= $passwordError ?></p><?php endif; ?>
      </div>
      <div class="input-box">
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" />
        <?php if ($confirmError): ?><p class="error-message"><?= $confirmError ?></p><?php endif; ?>
      </div>
      <button type="submit" class="register-btn">Register</button>
      <p class="login-link">Already have an account? <a href="login.php">Login Here</a></p>
      <?php if ($message): ?>
        <p class="success-message"><?= $message ?></p>
      <?php endif; ?>
    </form>
  </div>
</body>
</html>
