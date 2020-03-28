<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRegistrationComplete(){

    session_start();
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];

    $html = <<<html
        <div class="container">
            <div class="text-center">
                <div class="text-center confirmation">
                    <img class="confirmation-logo" src="img/favicon.png">
                    <p class="text-center">Thank you for registering for bubble!<br/>Please return to the <a href="index.php">Login Page</a> to login</p>
                    <p onclick="registrationEmail($email, $name)">Click here for verification email</p>
                </div>
            </div>
        </div>   
html;
    return $html;
}


?>