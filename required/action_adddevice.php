<?php
    $imageURI = $_POST[0];
    echo $_POST[0];

    echo $imageURI;

    $imageURI = str_replace(' ','+',$imageURI);
    $uri = substr($imageURI,strpos($imageURI,",")+1);
    $uri = base64_decode($uri);
    echo $uri;
    session_start();

    file_put_contents(dirname(__DIR__).'/upload/'.$_SESSION['user_id'].".png",$uri);

?>