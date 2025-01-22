<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

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
    if (empty($firstName)) {
        $errors['firstName'] = 'First name is required';
    }
    if (empty($lastName)) {
        $errors['lastName'] = 'Last name is required';
    }
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    if (empty($confirmPassword)) {
        $errors['confirmPassword'] = 'Confirm password is required';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = 'Passwords do not match';
    }

    // kontrollo nese emaili eshte ekzistent ne tabele
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

    $verificationCode = random_int(100000, 999999);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $codeExpiration = date('Y-m-d H:i:s', time() + 90);

    try {
        $stmt = $pdo->prepare('INSERT INTO users (firstName, lastName, email, password, role, profilePicture) 
                                VALUES (:firstName, :lastName, :email, :password, :role, :profilePicture)');
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => 'user',
            'profilePicture' => null
        ]);

        $userId = $pdo->lastInsertId();

        $stmt = $pdo->prepare('INSERT INTO verification_codes (id, verificationCode, verificationCodeExpiration, status) 
                                VALUES (:id, :verificationCode, :verificationCodeExpiration, :status)');
        $stmt->execute([
            'id' => $userId,
            'verificationCode' => $verificationCode,
            'verificationCodeExpiration' => $codeExpiration,
            'status' => 'unverified',
        ]);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply.bloomflowers@gmail.com';
        $mail->Password = 'nbtk lstr ogqa bpoo';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom('noreply.bloomflowers@gmail.com', 'Bloom Flowers');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body = "Hi $firstName,<br><br>Your verification code is: <b>$verificationCode</b><br><br>Enter this code to verify your email.<br><br>Thanks!";

        $mail->send();

        $_SESSION['email'] = $email;
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
?>
