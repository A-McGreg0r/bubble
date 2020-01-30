<?php
    //////////////////////////////// BUBBLE APP WEB GENERATOR /////////////////////////////////////
    //SETUP REQUIREMENTS
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



    }



    function generate_loggedInContent(){
        global $templatesDir;
        include $templatesDir."loginContent.php";
    }
?>


