<?php
global $conn;
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: indexUser.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $LastName = $_POST['LastName'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $profilePicture = null;
    if (!empty($_FILES['profilePicture']['name'])) {
        $profilePicture = time() . "_" . $_FILES['profilePicture']['name'];
        move_uploaded_file($_FILES['profilePicture']['tmp_name'], "uploads/" . $profilePicture);
    }

    if ($password) {
        $query = $conn->prepare("UPDATE users SET firstName = ?, LastName = ?, email = ?, password = ?, profilePicture = ? WHERE id = ?");
        $query->bind_param("sssssi", $firstName, $LastName, $email, $password, $profilePicture, $user_id);
    } else {
        $query = $conn->prepare("UPDATE users SET firstName = ?, LastName = ?, email = ?, profilePicture = ? WHERE id = ?");
        $query->bind_param("sssii", $firstName, $LastName, $email, $profilePicture, $user_id);
    }

    $query->execute();
    header("Location: profileUser.php");
    exit();
}
?>