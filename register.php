<?php

global $conn;
include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);
        $checkEmail="SELECT * FROM users WHERE email='$email'";
        $result=$conn->query($checkEmail);
        if($result->num_rows>0){
            echo "Email adress aleady exists!";
        }
        else{
            $insertQuery="INSERT INTO users (firstName,lastName,email,password)
                            VALUES ('$firstName','$lastName','$email','$password')";
                if($conn->query($insertQuery)==TRUE){
                    header("location:index.php");
                }
                else{
                    echo "Error: ".$conn->error;
                }
        }
}
if(isset($_POST['logIn'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

    $sql="SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['email']=$row['email'];
        header("location:homepage.php");
        exit();
    }
    else{
        echo "Nor found, incorrect email or password!";
    }
}