<?php
    //////////////////////////////// BUBBLE APP WEB GENERATOR /////////////////////////////////////
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //SETUP REQUIREMENTS
    require './required/config.php';


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
        //GET URL ACTION
        $action = '';
        if(isset($_GET['action'])) $action = $_GET['action'];

        //SWITCH DEPENDING ON URL ACTION
        switch($action){
            case 'registerComplete':
                return file_get_contents($templatesDir."registerComplete.html");
            case 'registerFailed':

            break;
            default:
                return eval(file_get_contents($templatesDir."loginContent.php"));
        }

    }

    function generate_loggedInContent(){
        //GET URL ACTION
        $action = '';
        if(isset($_GET['action'])) $action = $_GET['action'];
        $html = '';

        //TODO CHECK DOES USER HAVE A HUB? IF NOT ADD HUB

        //ALL PAGES NEED NAVIGATION
        $html .= eval(file_get_contents("./uiAssets/userNav.php"));

        //SWITCH DEPENDING ON URL ACTION
        switch($action){
            case 'logout':
                include $libDir.'logoutAction.php';
            break;
            case 'adddevice':
                return eval(file_get_contents("qr-reader.php"));
            break;
            default:
                return eval(file_get_contents("appCore.php"));
        }
    }
?>


