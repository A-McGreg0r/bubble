<?php
function logout($Current_SESSION){
    if (isset($Current_SESSION)){
        echo "<a class=\"nav-link\" href=\"index.php\">Log Out</a>";
        session_destroy();
    }
}
?>