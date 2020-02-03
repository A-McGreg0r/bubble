<?php
    $imageURI = $_POST[1];
    $imageURI = str_replace(' ','+',$imageURI);
    $imageURI = base64_decode($imageURI);
    file_put_contents("./upload/".$_SESSION['user_id'],$imageURI);

?>