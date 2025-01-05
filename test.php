<?php

require './phpmailer/phpmailer/src/Exception.php';
require './phpmailer/phpmailer/src/PHPMailer.php';
require './phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
// Enable debugging output
$mail->SMTPDebug = 3; // 3 for detailed debug output
$mail->Debugoutput = 'html'; // Log format

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreply.bloomflowers@gmail.com';
    $mail->Password = 'nbtk lstr ogqa bpoo'; // Use App Password here
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
    $mail->Port = 587; // Port 587 for STARTTLS

    $mail->setFrom('noreply.bloomflowers@gmail.com', 'Bloom Flowers');
    $mail->addAddress("pirofcb3@gmail.com");

    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';
    $mail->Body = "Email";
    $mail->send();
    echo 'Message sent successfully.';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
