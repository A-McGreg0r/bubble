<?php
include_once dirname(__DIR__).'/required/config.php';

function generateAccessPage(){
    $html = '';
    session_start();

    //GET SESSION INFORMATION
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $hub_id = $_SESSION['hub_id'];

        session_write_close();

    }

    session_write_close();
    return $html;
}