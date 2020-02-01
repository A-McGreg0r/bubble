<?php
////////////////////////////////////// DEVICE CONTROL SCRIPT/////////////////////////////////////////////
include_once 'config.php';
if(isset($_GET['type'])){
    $type = $_GET['type'];

    switch($type){
        case 'room':
            //ROOM HAS BEEN CALLED, TOGGLE ALL DEVICES LINKED TO THIS ROOM

        break;

        case 'device':
            //DEVICE HAS BEEN CALLED, TOGGLE INDIVIDUAL DEVICE

            
        break;
    }
} else {
    echo "Unknown type!";
}


?>