<?php
session_start();
$pdo = require 'connect.php';
$errors = [];


if (!isset($_SESSION['id'])) {
    $_SESSION['errors'] = ['not_logged_in' => 'You must be logged in to view this page.'];
    header('Location: index.php');
    exit();
}

$id = $_SESSION['id'];

// Fetch user data from the database
$stmt = $pdo->prepare('SELECT firstName, lastName, email, profilePicture, password FROM users WHERE id = :id');
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If no user data is found, log out and redirect
if (!$user) {
    $_SESSION['errors'] = ['user_not_found' => 'User not found.'];
    header('Location: logout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="css/myAccount.css">
</head>
<body>
<div class="profile-container">
    <h1>Profile Settings</h1>

    <!-- Display Errors -->
    <?php if (!empty($_SESSION['errors'])): ?>
        <div class="error-messages">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <!-- Display Success Messages -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="success-message">
            <p class="success"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="updateProfile.php" method="POST" enctype="multipart/form-data">
        <!-- First Name -->
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" id="firstName"
                   value="<?php echo htmlspecialchars($user['firstName']); ?>" required>
        </div>

        <!-- Last Name -->
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" id="lastName"
                   value="<?php echo htmlspecialchars($user['lastName']); ?>" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">New Password (Optional)</label>
            <input type="password" name="password" id="password">
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword">
        </div>

        <!-- Profile Picture -->
        <div class="form-group">
            <label for="profilePicture">Profile Picture</label>
            <?php if (!empty($user['profilePicture'])): ?>
                <img src="<?php echo htmlspecialchars($user['profilePicture']); ?>"
                     alt="Profile Picture" class="profile-picture-preview">
            <?php endif; ?>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
        </div>

        <!-- Submit Button -->
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>
</body>
</html>
