<?php

    $imageURI = $_POST[1];
    foreach ($_POST as $key => $value) {
        echo $key . " - " . $value;
    }
    echo $imageURI;

    $imageURI = str_replace(' ','+',$imageURI);
    $uri = substr($imageURI,strpos($imageURI,",")+1);
    $uri = base64_decode($uri);
    echo $uri;
    session_start();

    file_put_contents(dirname(__DIR__).'/upload/'.$_SESSION['user_id'].".png",$uri);

?>