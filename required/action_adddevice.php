<?php
    $imageURI = key($_POST);
    echo var_dump($_POST);
    list($type, $imageURI) = explode(';', $imageURI);
    list(, $imageURI)      = explode(',', $imageURI);
    $imageURI = str_replace(' ', '+', $imageURI);

    $uri = base64_decode($imageURI);
    session_start();

    file_put_contents(dirname(__DIR__).'/upload/'.$_SESSION['user_id'].".png",$uri);

?>