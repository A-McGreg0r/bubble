<?php
function generateLogout(){
    session_start();
    include_once 'config.php';
    session_destroy();
    session_write_close();
    load("");
}
?>