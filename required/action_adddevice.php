<?php
    $imageURI = $_POST[0];
    $imageURI = str_replace(' ','+',$imageURI);
    $uri = substr($imageURI,strpos($imageURI,",")+1);
    $uri = base64_decode($uri);

    file_put_contents("./upload/".$_SESSION['user_id'],$uri);

?>