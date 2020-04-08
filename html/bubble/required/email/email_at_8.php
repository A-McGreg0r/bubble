<?php
include_once dirname(__DIR__).'/../required/config.php';
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

global $db;
$stmt = $db->prepare("SELECT * FROM user_info");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows >= 1) {

    $all = $result->fetch_all(MYSQLI_ASSOC);
    foreach($all as $row){

        $stmt2 = $db->prepare("SELECT * FROM hub_users WHERE user_id = ?");
        $stmt2->bind_param("i",$row['user_id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows >= 1) {

            $energy_used = 0;
            $energy_cost = $row['energy_cost'];

            $all2 = $result2->fetch_all(MYSQLI_ASSOC);
            foreach($all2 as $row2){

                $stmt3 = $db->prepare("SELECT * FROM hourly_data WHERE hub_id = ?");
                $stmt3->bind_param("i",$row2['hub_id']);
                $stmt3->execute();
                $result3 = $stmt3->get_result();
                if ($result3->num_rows >= 1) {

                    $all3 = $result3->fetch_all(MYSQLI_ASSOC);
                    foreach($all3 as $row3){
                        $energy_used = $energy_used + $row3['energy_usage'];
                    }
                }
            }

            $total_spent = $energy_used / 1000 * $energy_cost;
            $total_spent_round = number_format($total_spent,2);

            $allow_emails = $row['allow_emails'];
            if($allow_emails == "Yes"){
                $first_name = $row['first_name'];
                $email = $row['email'];
                $budget = $row['budget'] / 31; // for daily stats
                $budget_round = number_format($budget,2);

                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->SMTPDebug = 2;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->Username = 'bubblehome.care@gmail.com';
                $mail->Password = 'TeamBubble6!';
                $mail->setFrom('bubblehome.care@gmail.com', 'Bubble');
                $mail->addAddress($email, $first_name);
                $mail->Subject = 'Daily report';
                $mail->isHTML(true);
                $mail->AddEmbeddedImage('img/favicon.png', 'logo');

                $logo = "<img src='cid:logo' style='width:100px'>";
                $email_welcome = "<h3 style='font-weight:400'>Dear $first_name,<h3>";
                $email_body = '';
                if ($budget < $total_spent){
                    $email_body = "<h4 style='font-weight:400'>You have gone above your set budget of &#163;$budget_round per day!<br>You have currently spent &#163;$total_spent_round.<br><br>To reduce the amount you spend, please consider turning off all electronic devices when not in use, or have heaters or air conditioning units on at a lower setting.<br>Better luck tomorrow!</h4>";
                } else {
                    $email_body = "<h4 style='font-weight:400'>Congratulations, you have gone kept within your set budget of &#163;$budget_round per day!<br>You have currently spent &#163;$total_spent_round.<br><br>Good luck for tomorrow, keep it up!</h4>";
                }
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
            }
        }
    }
}

$stmt->close();

?>