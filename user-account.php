<?php
global $pdo;
session_start();
require_once 'connect.php';

$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['register'])){
    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $password=$_POST['password'];
    $confirmPassword=$_POST['confirmPassword'];

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email']='Invalid email format';
    }
    if(empty($firstName)){
        $errors['firstName']='First name is required';
    }
    if(empty($lastName)){
        $errors['lastName']='Last name is required';
    }
    if(strlen($password)<8){
        $errors['password']='Password must be at least 8 characters';
    }
    if($password !== $confirmPassword){
        $errors['confirmPassword']='Passwords do not match';
    }
    if (!$pdo) {
        die('Database connection not established.');
    }
    $stmt=$pdo->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->execute(['email'=>$email]);
    if($stmt->fetch()){
        $errors['user_exist']='This email is already registered!';
    }
    if(!empty($errors)){
        $_SESSION['errors']=$errors;
        header('Location: register.php');
        exit();
    }

    $hashedPassword=password_hash($password,PASSWORD_BCRYPT);
    $stmt=$pdo->prepare('INSERT INTO users (firstName,lastName,email,password) VALUES (:firstName,:lastName,:email,:password)');

    $stmt->execute([
        'firstName'=>$firstName,
        'lastName'=>$lastName,
        'email'=>$email,
        'password'=>$hashedPassword
    ]);
    header('Location: index.php');
    exit();
}
if($_SERVER['REQUEST_METHOD'] === 'POST'&& isset($_POST['login'])){
    $email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
    $password=$_POST['password'];

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email']='Invalid email format';
    }
    if(empty($password)){
        $errors['password']='Password is required';
    }
    if(!empty($errors)){
        $_SESSION['errors']=$errors;
        header('Location: index.php');
        exit();
    }
    $stmt=$pdo->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->execute(['email'=>$email]);
    $user=$stmt->fetch();

    if($user && password_verify($password,$user['password'])){
        $_SESSION['user']=[
            'id'=>$user['id'],
            'firstName'=>$user['firstName'],
            'lastName'=>$user['lastName'],
            'email'=>$user['email']
        ];
        header('Location: homepage.php');
        exit();
    }else{
        $errors['login']='Invalid email or password';
        $_SESSION['errors']=$errors;
        header('Location: index.php');
        exit();
    }
}


