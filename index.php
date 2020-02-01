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
    
    //ECHO STARTING HTML TO PAGE
    echo $html;
    $html = '';

    //GENERATE REMAINING PAGE
    if($isLoggedIn){
        generate_loggedInContent();
    }else{
        generate_loginPage();
    }

    //END MAIN PAGE CONTENTS
    $html .= file_get_contents($templatesDir."bodyEnd.html");
    $html .= file_get_contents($templatesDir."footer.html");

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
                echo file_get_contents($templatesDir."registerComplete.html");
            case 'registerFailed':

            break;
            default:
                include $templatesDir."loginContent.php";
        }

    }

    function generate_loggedInContent(){
        //GET URL ACTION
        $action = '';
        if(isset($_GET['action'])) $action = $_GET['action'];

        //TODO CHECK DOES USER HAVE A HUB? IF NOT ADD HUB

        //ALL PAGES NEED NAVIGATION
        include './uiAssets/userNav.php';

        //SWITCH DEPENDING ON URL ACTION
        switch($action){
            case 'logout':
                include $libDir.'logoutAction.php';
            break;
            case 'adddevice':
                include "qr-reader.php";
            break;
            default:
                include "appCore.php";
        }
    }
?>


