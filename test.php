<?php

require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply.bloomflowers@gmail.com';
    $mail->Password = 'nbtk lstr ogqa bpoo'; // Use App Password here
    $mail->SMTPSecure =PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );


    $mail->setFrom('noreply.bloomflowers@gmail.com', 'Bloom Flowers');
    $mail->addAddress("shtembarieni@gmail.com");

    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';
    $mail->Body = "Email";
    $result = $mail->send();
    var_dump($result);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


