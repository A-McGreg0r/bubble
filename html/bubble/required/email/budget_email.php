<?php
include_once dirname(__DIR__).'/../required/config.php';
function generateAccount(){
    global $db;
    $stmt = $db->prepare("SELECT * FROM user_info");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows >= 1) {
        extract($result->fetch_assoc());

        while($row = $result->fetch_array($result, $result->fetch_assoc())){
            $first_name = $row['first_name'];
            $email = $row['email'];
            $budget = $row['budget'];

            ini_set('display_errors',1);
            error_reporting(E_ALL);
            $from = "bubblehome.care@gmail.com";
            $to = $email;
            $subject = "Nearing Budget";
            $message = "Dear "+$first_name+" You are nearing your current budget of" + $budget;
            $headers = "From: " + $from;
            mail($to, $subject, $message, $headers);
            echo"email sent to " + $email;
        }
    }
}
?>