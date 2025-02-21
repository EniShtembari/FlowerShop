<?php
session_start();
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container" id="register">
    <h1 class="form-title">Register</h1>

    <?php
    if (isset($errors['user_exist'])) {
        echo '<div class="error-main"><p>' . $errors['user_exist'] . '</p></div>';
    }
    ?>

    <form method="POST" action="userAccount.php">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="firstName" placeholder="First Name" required>
        </div>
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="lastName" placeholder="Last Name" required>
        </div>
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="input-group">
            <i class="fas fa-eye" id="eye"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
        </div>
        <div class="input-group">
            <i class="fas fa-eye" id="eye"></i>
            <input type="password" name="confirmPassword" id="password" placeholder="Confirm Password" required>
        </div>
        <input type="submit" class="btn" value="Register" name="register">
    </form>
</div>
<script src="js/script.js"></script>
</body>
</html>
