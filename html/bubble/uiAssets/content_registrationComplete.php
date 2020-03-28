<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRegistrationComplete(){

    $email = '';
    if(isset($_GET['email'])) $email = $_GET['email'];
    $name = '';
    if(isset($_GET['name'])) $name = $_GET['name'];

    $html = <<<html
        <div class="container">
            <div class="text-center">
                <div class="text-center confirmation">
                    <img class="confirmation-logo" src="img/favicon.png">
                    <p class="text-center">Thank you for registering for bubble!<br/>Please return to the <a onclick="registrationEmail($email, $name)" href="index.php">Login Page</a> to login</p>
                </div>
            </div>
        </div>   
html;
    return $html;
}


?>