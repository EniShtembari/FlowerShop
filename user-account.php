<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

global $pdo;
session_start();
require_once 'connect.php';

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
    if (empty($firstName)) {
        $errors['firstName'] = 'First name is required';
    }
    if (empty($lastName)) {
        $errors['lastName'] = 'Last name is required';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Passwords do not match';
    }

    if (!$pdo) {
        die('Database connection not established.');
    }

    // Check if email already exists
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

    // Generate token and hash password
    $token = bin2hex(random_bytes(16));
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Save user to database with "unverified" status
    $stmt = $pdo->prepare('INSERT INTO users (firstName, lastName, email, password, status, token) VALUES (:firstName, :lastName, :email, :password, :status, :token)');
    $stmt->execute([
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'password' => $hashedPassword,
        'status' => 'unverified',
        'token' => $token
    ]);

    // Send verification email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Update with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // Your email
        $mail->Password = 'your_password'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@example.com', 'Your Website'); // Update sender info
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email';
        $mail->Body = "Hi $firstName,<br><br>Thank you for registering. Please verify your email by clicking the link below:<br>
        <a href='http://yourwebsite.com/verify.php?token=$token'>Verify Email</a><br><br>Best regards,<br>Your Website Team";

        $mail->send();
        $_SESSION['success'] = 'Registration successful! Please check your email to verify your account.';
        header('Location: register.php');
        exit();
    } catch (Exception $e) {
        $errors['email_send'] = 'Could not send verification email. Error: ' . $mail->ErrorInfo;
        $_SESSION['errors'] = $errors;
        header('Location: register.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit();
    }

    // Check credentials
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['status'] !== 'verified') {
            $errors['unverified'] = 'Please verify your email before logging in.';
            $_SESSION['errors'] = $errors;
            header('Location: index.php');
            exit();
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'firstName' => $user['firstName'],
            'lastName' => $user['lastName'],
            'email' => $user['email']
        ];
        header('Location: homepage.php');
        exit();
    } else {
        $errors['login'] = 'Invalid email or password';
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit();
    }
}
