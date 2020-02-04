<?php
    $imageURI = key($_POST);

    $imageURI = str_replace(' ','+',$imageURI);
    $uri = str_replace("data:image/png;base64,","",$imageURL);
    $uri = base64_decode($uri);
    session_start();

    file_put_contents(dirname(__DIR__).'/upload/'.$_SESSION['user_id'].".png",$uri);

?>