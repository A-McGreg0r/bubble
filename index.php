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

    $pageHTML = file_get_contents($templatesDir.'mainTemplate.html');

    $content = '';
    //GENERATE REMAINING PAGE
    if($isLoggedIn){
        $content = generate_loggedInContent();
    }else{
        $content = generate_loginPage();
    }

    $pageHTML = str_replace('$MAIN_BODY', $content, $pageHTML);

    //ECHO HTML TO PAGE
    echo $pageHTML;
    exit();

    //////////////////////////////////////////////////////////////////// FUNCTIONS ///////////////////////////////////////////////////////////////////////

    function generate_loginPage(){
        global $templatesDir;
        //GET URL ACTION
        $action = '';
        if(isset($_GET['action'])) $action = $_GET['action'];
        $html = '';

        // SWITCH DEPENDING ON URL ACTION
        switch($action){
            case 'registerComplete':
                // echo file_get_contents($templatesDir."registerComplete.html");
            break;
            case 'registerFailed':

            break;
            default:
                include "./uiAssets/loginContent.php";
                $html .= generateLoginPage();
            break;
        }


        return $html;
    }

    function generate_loggedInContent(){
        //GET URL ACTION
        $action = '';
        if(isset($_GET['action'])) $action = $_GET['action'];
        $html = '';
        //TODO CHECK DOES USER HAVE A HUB? IF NOT ADD HUB

        //ALL PAGES NEED NAVIGATION
        include './uiAssets/userNav.php';
        $html .= generateUserNav();

        //SWITCH DEPENDING ON URL ACTION
        switch($action){
            case 'logout':
                include './required/logoutAction.php';
                $html .= generateLogout($_SESSION);
            break;
            case 'adddevice':
                // include "qr-reader.php";
            break;
            default:
                include "appCore.php";
                $html .= generateAppCore();
        }
        return $html;
    }
?>


