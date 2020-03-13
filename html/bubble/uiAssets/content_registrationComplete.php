<?php
include_once dirname(__DIR__).'/required/config.php';

function generateRegistrationComplete(){
    $html = <<<html
        <div class="container">
            <div class="row text-center">
                <div class="text-center">
                    <p class="text-center">Thank you for registering for bubble!</p>
                    <p class="text-center">Please return to the <a href="index.php">Login Page</a> to login</p>
                </div>
            </div>
        </div>   
html;
    return $html;
}


?>