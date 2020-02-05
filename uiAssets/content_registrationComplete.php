<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRegistrationComplete(){
    $html = <<<html
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <p>Thank you for registering for bubble!</p>
                    <p>Please return to the <a href="index.php?action=login>Login Page</a> to login</p>
                </div>
            </div>
        </div>   
html;
    return $html;
}


?>