<?php
function generateLogout($Current_SESSION){
    include_once 'config.php';
    if (isset($Current_SESSION)){
        session_destroy();
    }
    load("/bubble/");
}
?>