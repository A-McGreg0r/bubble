<?php
    //SETUP DIRECTORIES
    $libDir = "./required/";
    $templatesDir = "./html/";
    require $libDir."db_tools.php";


    //SALTING AND PEPPERING
    $pepper = hex2bin('012345679ABCDEF012345679ABCDEF012345679ABCDEF012345679ABCDEF');




?>
