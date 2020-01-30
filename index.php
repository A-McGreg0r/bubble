<?php
    //////////////////////////////// BUBBLE APP WEB GENERATOR /////////////////////////////////////
    //SETUP REQUIREMENTS
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require "config.php";

    //REQUIRES SESSIONS
    session_start();

    //SETUP VARIABLES
    $isLoggedIn = isset($_SESSION['user_id']);


    //BEGIN GENERATING MAIN PAGE
    $html = '';
    //GENERATE HEADER AND HEAD
    $html .= file_get_contents($templatesDir."header.html");
    $html .= file_get_contents($templatesDir."head.html");
    //MAIN PAGE CONTENTS
    $html .= file_get_contents($templatesDir."bodyStart.html");


    if($isLoggedIn){
        $html .= generate_loggedInContent();
    }else{
        $html .= generate_loginPage();
    }

    //END MAIN PAGE CONTENTS
    $html .= file_get_contents($templatesDir."bodyEnd.html");






    //ECHO HTML TO PAGE
    echo $html;
    exit();

    //////////////////////////////////////////////////////////////////// FUNCTIONS ///////////////////////////////////////////////////////////////////////

    function generate_loginPage(){
        global $templatesDir;
        include $templatesDir."loginContent.php";
    }



    function generate_loggedInContent(){
        include "appCore.php";
    }
?>


