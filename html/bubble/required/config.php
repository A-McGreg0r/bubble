<?php
    //SETUP DIRECTORIES
    $libDir = "./required/";
    $templatesDir = "./html/";

    //SALTING AND PEPPERING
    $pepper = hex2bin('012345679ABCDEF012345679ABCDEF012345679ABCDEF012345679ABCDEF');

    //REQUIRE VARIOUS DB CONNECTION COMPONENTS
    require 'connect_db.php';
    require 'db_tools.php';


?>
