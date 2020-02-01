<?php
function generateLogout($Current_SESSION){
    if (isset($Current_SESSION)){
        echo "<a class=\"nav-link\" href=\"index.php\">Log Out</a>";
        session_destroy();
    }
    return 'Sucessfully logged out! <a href="/">Return to login</a>';
}
?>