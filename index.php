<?php
session_start();  // Start the session

// Include database connection
$pdo = require __DIR__ . '/connect.php';
if (!isset($pdo)) {
    die('Database connection not established.');
}

// Initialize variables
$success_message = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
$error_message = null;
$errors = [];

// Check if the "remember_me" cookie exists for auto-login
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    // Validate the token against the database
    $stmt = $pdo->prepare("SELECT id, email, firstName, rememberMe FROM users WHERE rememberMe IS NOT NULL");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($token, $user['rememberMe'])) {
        // Token is valid, log the user in
        $_SESSION['UserID'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['firstName'] = $user['firstName'];
        header('Location: homepage.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    }

    if (empty($errors)) {
        // Query to fetch user by email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user role in the session
                $_SESSION['isAdmin'] = ($user['role'] === 'admin');

                // Set session variables for the logged-in user
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['firstName'] = $user['firstName'];

                // Redirect to homepage
                header('Location: homepage.php');
                exit();
            } else {
                $error_message = "Invalid email or password.";
            }
        } else {
            $error_message = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container" id="login">
    <h1 class="form-title">Login</h1>

    <!-- Display success message -->
    <?php if ($success_message): ?>
        <div class="success-main">
            <p><?php echo $success_message; ?></p>
        </div>
    <?php endif; ?>

    <!-- Display error messages -->
    <?php if (!empty($errors) || $error_message): ?>
        <div class="error-main">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
            <?php if ($error_message): ?>
                <p><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="">
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <i class="fas fa-eye" id="eye"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="links" style="text-align: left">
            <a href="forgotPassword.php">Forgot password</a><br><br>
        </div>
        <input type="submit" class="btn" value="Log in" name="login">
    </form>

    <div class="links">
        <p>Don't have an account yet?</p>
        <a href="register.php">Register</a>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
