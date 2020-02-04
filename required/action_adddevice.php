<?php
    //LOAD QR CODE READING LIBRARY
    require dirname(__DIR__) . "/vendor/autoload.php";
    use Zxing\QrReader;

    //GET PHOTO FROM POST BASE64 DATA
    $imageURI = $_POST['photo'];
    $imageURI = str_replace(' ', '+', $imageURI);
	$imageURI = str_replace('data:image/png;base64,', '', $imageURI);

    //DECODE BASE 64, BASE64_DECODE HAS TROUBLE DEALING WITH BASE64>5000 CHARACTERS, SO DO IT IN CLUMPS
    $decoded = "";
    for ($i=0; $i < ceil(strlen($imageURI)/256); $i++)
        $decoded = $decoded . base64_decode(substr($imageURI,$i*256,256));    
    //BEGIN SESSION
    session_start();
    $user_id = $_SESSION['user_id'];
    //END SESSION
    session_write_close();
    //PUT CONTENTS INTO FILE, THIS IS REQUIRED FOR QRCODE READER
    file_put_contents(dirname(__DIR__).'/upload/'.$user_id.".png",$decoded);
    //LOAD FILE AGAIN
    $image = dirname(__DIR__).'/upload/'.$user_id.".png";


    //SCAN IMAGE FOR QR CODE
    $qrcode = new QrReader($image);

    //GET TEXT FROM QR CODE IF IT EXISTS
    $qrText = $qrcode->text();
    if(!empty($qrText)){

    }


?>