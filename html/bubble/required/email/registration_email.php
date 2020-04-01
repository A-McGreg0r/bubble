<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

session_start();
$email = $_SESSION['email'];
$name = $_SESSION['name'];

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'bubblehome.care@gmail.com';
$mail->Password = 'TeamBubble6!';
$mail->setFrom('bubblehome.care@gmail.com', 'Bubble');
$mail->addAddress($email, $name);
$mail->Subject = 'Welcome to Bubble';
$mail->isHTML(true);
$mail->AddEmbeddedImage('img/favicon.png', 'logo');

$logo = "<img src='cid:logo' style='width:100px'>";
$email_welcome = "<h3 style='font-weight:400'>Dear $name,<h3>";
$email_body = "<h4 style='font-weight:400'>Welcome to Bubble!</h4>";
$email_signoff = "<h4 style='font-weight:400'>Kind regards,<br>The Bubble Team</h4>";
$email_signature = "Jamie Rice - Organisational Manager <br> Bruce Wilson - Technical Manager <br> Rory Dobson - Liaison Officer <br> Andrew MacGregor - Web Developer <br> Michael Linton - Software Engineer <br> Mark Kostryckyj - Software Developer";
$email_content = "<div style='font-family:arial'>$email_welcome $email_body $email_signoff</div> <hr><div style='text-align:center'> $logo <br> $email_signature</div>";

$mail->Body = (string) $email_content;
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo "Email sent to $email\n";
}
?>