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

    //GRAB FILE CONTENTS FROM PREGENERATED HTML TEMPLATE
    $pageHTML = file_get_contents($templatesDir.'mainTemplate.html');

    $content = '';

    //GENERATE REMAINING PAGE
    if($isLoggedIn){
        $content = generate_loggedInContent();
    }else{
        $content = generate_loginPage();
    }

    //REPLACE TAGS INSIDE TEMPLATE WITH GENERATED CONTENT
    $pageHTML = str_replace('$MAIN_BODY', $content, $pageHTML);

    //ECHO HTML TO PAGE
    echo $pageHTML;
    exit();

    //////////////////////////////////////////////////////////////////// FUNCTIONS ///////////////////////////////////////////////////////////////////////

    /**
     * GENERATOR FUNCTION FOR NON-LOGGED IN USERS, E.G. LOGIN, SIGNUP, FORGOT PASSWORD
     */
    function generate_loginPage(){
        global $templatesDir;
        //GET URL ACTION
        $action = '';
        if(isset($_GET['action'])) $action = $_GET['action'];
        
        $html = '';

        //SWITCH DEPENDING ON URL ACTION
        /**
         * SWITCH BASED ON ACTION.
         * INCLUDE REQUIRED FILE, THEN CALL FUNCTION DEFINED INSIDE PHP FILE
         * THIS ALLOWS US TO GENERATE THE CONTENT THROUGH PHP, THEN INSERT THAT CONTENT INTO THE PREGENERATED HTML-TEMPLATE
         */       
        switch($action){
            default:
                include "./uiAssets/content_login.php";
                $html .= generateLoginPage();
            break;
        }

        return $html;
    }

    /**
     * GENERATOR FUNCTION FOR GENERATING LOGGED IN CONTENT
     */
    function generate_loggedInContent(){
        //GET URL ACTION
        $action = '';
        if(isset($_GET['action'])) $action = $_GET['action'];
        
        $html = '';  

        //ADD NAVIGATION TO THE TOP OF THE PAGE
        include './uiAssets/content_userNav.php';
        $html .= generateUserNav();

        
        //CHECK IF THE USER HAS NOT SETUP A HUB YET. IF THEY HAVE NOT SETUP A HUB, NAVIGATE TO THE ADD DEVICE PAGE.
        //THIS IS FORCED, AS THE MAIN TAB PAGES WOULD HAVE NO INFO ON THEM ANYWAY
        if($action != "logout" && !userHasHub()){
            include './uiAssets/content_addDevice.php';
            $html .= generateQRReader(TRUE);
            exit();
        }

        //SWITCH DEPENDING ON URL ACTION
        /**
         * SWITCH BASED ON ACTION.
         * INCLUDE REQUIRED FILE, THEN CALL FUNCTION DEFINED INSIDE PHP FILE
         * THIS ALLOWS US TO GENERATE THE CONTENT THROUGH PHP, THEN INSERT THAT CONTENT INTO THE PREGENERATED HTML-TEMPLATE
         */
        switch($action){
            case 'logout':
                include './required/action_logout.php';
                $html .= generateLogout();
                break;
            case 'account':
                include './uiAssets/content_account.php';
                $html .= generateAccount();
                break;
            default:
                include "uiAssets/content_tabs.php";
                $html .= generateTabs();
                break;
        }
        return $html;
    }
?>


