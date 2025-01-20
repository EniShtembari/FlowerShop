<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flowershop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the logged-in user is admin
$admin_query = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['role'] !== 'admin') {
    header("Location: myAccount.php");
    exit();
}

// Get user ID from URL
$edit_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user information
    $update_query = "UPDATE users SET firstName = ?, lastName = ?, email = ?, role = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $firstName, $lastName, $email, $role, $edit_id);

    if ($update_stmt->execute()) {
        $_SESSION['message'] = "User updated successfully";
        header("Location: myAccount.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating user";
    }
}

// Fetch user data
$user_query = "SELECT id, firstName, lastName, email, role FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $edit_id);
$stmt->execute();
$result = $stmt->get_result();
$edit_user = $result->fetch_assoc();

// If user doesn't exist, redirect back
if (!$edit_user) {
    $_SESSION['error'] = "User not found";
    header("Location: myAccount.php");
    exit();
}

include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit-user.css">
    <title>Edit User</title>
</head>
<body>
<main>
    <div class="edit-form">
        <h1>Edit User</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php
                echo htmlspecialchars($_SESSION['error']);
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName"
                       value="<?= htmlspecialchars($edit_user['firstName']) ?>" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName"
                       value="<?= htmlspecialchars($edit_user['lastName']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($edit_user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user" <?= $edit_user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $edit_user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="myAccount.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</main>
<script src="timeout.js"></script>
<?php include 'footer.php';?>
</body>
</html>
<?php

$conn->close();
?>
