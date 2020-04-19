<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
include_once dirname(__DIR__).'/config.php';


function sendBaseEmail($userEmail, $userName, $emailSubject, $emailBody){

    //SETUP BASIC PHP MAILER ENGINE
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'bubblehome.care@gmail.com';
    $mail->Password = 'TeamBubble6!';
    $mail->setFrom('bubblehome.care@gmail.com', 'Bubble');
    $mail->addAddress($userEmail, $userName);
    $mail->Subject = $emailSubject;
    $mail->isHTML(true);
    $mail->AddEmbeddedImage('../../img/favicon.png', 'logo');
    
    //Set up welcome email
    $logo = "<img src='cid:logo' style='width:100px'>";
    $email_welcome = "<h3 style='font-weight:400'>Dear $userName,<h3>";
    $email_body = $emailBody;
    $email_signoff = "<h4 style='font-weight:400'>Kind regards,<br>The Bubble Team</h4>";
    $email_signature = "Jamie Rice - Organisational Manager <br> Bruce Wilson - Technical Manager <br> Rory Dobson - Liaison Officer <br> Andrew MacGregor - Web Developer <br> Michael Linton - Software Engineer <br> Mark Kostryckyj - Software Developer";
    $email_content = "<div style='font-family:arial'>$email_welcome $email_body $email_signoff</div> <hr><div style='text-align:center'> $logo <br> $email_signature</div>";
    
    $mail->Body = (string) $email_content;

    if (!$mail->send()) {
        //ERROR THROW
    } 

}

function sendBaseEmailFromUserID($userID, $emailSubject, $emailBody){
    global $db;

    $stmt = $db->prepare("SELECT email, first_name FROM user_info WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    if(!$stmt->execute()){
        //ERROR
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $userEmail = $row['email'];
    $userFirstName = $row['first_name'];
    $stmt->close();
    sendBaseEmail($userEmail, $userFirstName, $emailSubject, $emailBody);

}


?>