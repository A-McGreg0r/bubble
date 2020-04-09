<?php
include_once dirname(__DIR__).'/required/config.php';
ob_start();
include dirname(__DIR__).'/required/email/registration_email.php';
$data = ob_get_clean();
ob_end_flush();

function generateRegistrationComplete(){

    $email = $_SESSION['email'];
    $name = $_SESSION['name'];

    $html = <<<html
        <div class="container">
            <div class="text-center">
                <div class="text-center confirmation">
                    <img class="confirmation-logo" src="img/favicon.png">
                    <p class="text-center">Hi $name!<br>Thank you for registering for bubble!<br/>Please return to the <a href="index.php">Login Page</a> to login</p>
                </div>
            </div>
        </div>   
html;
    return $html;
}


?>