<?php
session_start();
$pdo = require 'connect.php';
$errors = [];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['id'];

// Fetch user data from the database
$stmt = $pdo->prepare('SELECT firstName, lastName, email, profilePicture FROM users WHERE id = :id');
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
    <link rel="stylesheet" href="profileSettings.css">
</head>
<body>
<div class="header">
    <div class="logo">MyPlatform</div>
    <nav>
        <a href="homepage.php">Home</a>
        <a href="#">Help</a>
    </nav>
    <div class="account-actions">
        <a href="logout.php">Log Out</a>
    </div>
</div>
<main>
    <h1>Profile Settings</h1>
    <div class="profile-container">
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
            <div class="profile-picture">
                <img id="preview" src="<?php echo !empty($user['profilePicture']) ? htmlspecialchars($user['profilePicture']) : 'default-profile.png'; ?>" alt="Profile Picture">
                <input type="file" name="profile_picture" accept="image/*" onchange="loadFile(event)">
            </div>
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" id="firstName" required value="<?php echo htmlspecialchars($user['firstName']); ?>">

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="lastName" required value="<?php echo htmlspecialchars($user['lastName']); ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($user['email']); ?>">

            <label for="password">New Password (Optional):</label>
            <input type="password" name="password" id="password">

            <button type="submit" name="update_profile">Save Changes</button>
        </form>
    </div>
</main>
<script>
    const loadFile = (event) => {
        const output = document.getElementById('preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = () => {
            URL.revokeObjectURL(output.src);
        }
    };
</script>
</body>
</html>
