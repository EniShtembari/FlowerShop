<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require_once 'connect.php';

session_start();
$pdo = require 'connect.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if (empty($firstName) || empty($lastName)) {
        $errors['name'] = 'Name is required';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Passwords do not match';
    }

    // Check if email exists
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        $errors['user_exist'] = 'This email is already registered!';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: register.php');
        exit();
    }

    // Generate 6-digit verification code
    $verificationCode = random_int(100000, 999999);

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Save user to database
    $stmt = $pdo->prepare('INSERT INTO users (firstName, lastName, email, password, verificationCode, status) VALUES (:firstName, :lastName, :email, :password, :verificationCode, :status)');
    $stmt->execute([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'password' => $hashedPassword,
        'verificationCode' => $verificationCode,
        'status' => 'unverified',
    ]);

    // Send verification email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply.bloomflowers@gmail.com';
        $mail->Password = 'nhzg guoz wtsf thsn'; // Use App Password here
        $mail->SMTPSecure ='tsl';
        $mail->Port = 587;

        $mail->setFrom('noreply.bloomflowers@gmail.com', 'Bloom Flowers');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body = "Hi $firstName,<br><br>Your verification code is: <b>$verificationCode</b><br><br>Enter this code to verify your email.<br><br>Thanks!";

        $mail->send();
        $_SESSION['success'] = 'Registration successful! Check your email for the verification code.';
        header('Location: verify.php');
        exit();
    } catch (Exception $e) {
        $errors['email_send'] = 'Could not send verification email. Error: ' . $mail->ErrorInfo;
        $_SESSION['errors'] = $errors;
        header('Location: register.php');
        exit();
    }
}
