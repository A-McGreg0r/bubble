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
    //CLOSE SESSION
    session_write_close();

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
                include "./uiAssets/content_registrationComplete.php";
                $html .= generateRegistrationComplete();
            break;
            case 'registerFailed':

            break;
            default:
                include "./uiAssets/content_login.php";
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
        
        if($action != "logout" && $action != 'adddevice' && !userHasHub()){
            load('./index.php?action=adddevice');
            exit();
        }

        //ALL PAGES NEED NAVIGATION
        include './uiAssets/content_userNav.php';
        $html .= generateUserNav();

        //SWITCH DEPENDING ON URL ACTION
        switch($action){
            case 'logout':
                include './required/action_logout.php';
                $html .= generateLogout();
            break;
            case 'adddevice':
                include './uiAssets/content_adddevice.php';
                $html .= generateQRReader();
            break;
            case 'addroom':
                include './uiAssets/content_addroom.php';
                $html .= generateAddRoom();
                break;
            case 'account':
                include './uiAssets/content_account.php';
                $html .= generateAccount();
                break;
            default:
                include "appCore.php";
                $html .= generateAppCore();
        }
        return $html;
    }
?>


