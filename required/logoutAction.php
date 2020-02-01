<?php
function generateLogout($Current_SESSION){
    if (isset($Current_SESSION)){
        session_destroy();
    }
    return 'Sucessfully logged out! <a href="/bubble/">Return to login</a>';
}
?>