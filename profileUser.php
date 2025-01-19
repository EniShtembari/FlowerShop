<?php
global $conn;
session_start();
require 'connect.php'; // Përfshij lidhjen me bazën e të dhënave

// Kontrollo nëse përdoruesi është loguar
if (!isset($_SESSION['user_id'])) {
    header("Location: indexUser.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Nëse forma është dërguar, përditëso të dhënat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Përpunimi i fotos së profilit
    $profilePicture = null;
    if (!empty($_FILES['profilePicture']['name'])) {
        $profilePicture = time() . "_" . $_FILES['profilePicture']['name'];
        move_uploaded_file($_FILES['profilePicture']['tmp_name'], "uploads/" . $profilePicture);
    }

    // Përgatit query-n për përditësim
    $query = $conn->prepare(
        $password
            ? "UPDATE users SET firstName = ?, lastName = ?, email = ?, password = ?, profilePicture = ? WHERE id = ?"
            : "UPDATE users SET firstName = ?, lastName = ?, email = ?, profilePicture = ? WHERE id = ?"
    );

    if ($password) {
        $query->bind_param("sssssi", $firstName, $lastName, $email, $password, $profilePicture, $user_id);
    } else {
        $query->bind_param("ssssi", $firstName, $lastName, $email, $profilePicture, $user_id);
    }

    $query->execute();

    // Rifresko faqen për të marrë të dhënat e përditësuara
    header("Location: profileUser.php");
    exit();
}

// Merr të dhënat e përdoruesit nga database
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$user = $query->get_result()->fetch_assoc();

if (!$user) {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="styleUser.css">
</head>
<body>
<div class="profile">
    <h2>Your Profile</h2>
    <form method="POST" action="profileUser.php" enctype="multipart/form-data">

        <?php if (!empty($user['profilePicture'])): ?>
            <img id="profilePreview" src="uploads/<?= htmlspecialchars($user['profilePicture']) ?>" alt="Profile Picture">
        <?php else: ?>
            <img id="profilePreview" src="images/default_profile_picture.jpg" alt="Default Profile Picture">
        <?php endif; ?>


        <label>First Name:</label>
        <input type="text" name="firstName" value="<?= htmlspecialchars($user['firstName']) ?>" required>

        <label>Last Name:</label>
        <input type="text" name="LastName" value="<?= htmlspecialchars($user['LastName']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label>Password:</label>
        <input type="password" name="password" placeholder="Enter new password (optional)">

        <label>Profile Picture:</label>
        <input type="file" name="profilePicture" accept="image/*" onchange="previewImage(event)">

        <button type="submit">Update Profile</button>
    </form>
</div>

<script>
    // JavaScript për të shfaqur parapamjen e fotos së profilit
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('profilePreview');
            preview.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
</body>
</html>
