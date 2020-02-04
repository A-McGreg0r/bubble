<?php
    use Zxing\QrReader;

    $imageURI = $_POST['photo'];
    echo var_dump($_POST);
    $imageURI = str_replace(' ', '+', $imageURI);
	$imageURI = str_replace('data:image/png;base64,', '', $imageURI);

    $decoded = "";
    for ($i=0; $i < ceil(strlen($imageURI)/256); $i++)
        $decoded = $decoded . base64_decode(substr($imageURI,$i*256,256));    
    session_start();

    file_put_contents(dirname(__DIR__).'/upload/'.$_SESSION['user_id'].".png",$decoded);


    $image = dirname(__DIR__).'/upload/'.$_SESSION['user_id'].".png";

    $qrcode = new QrReader($image);
    $this->assertSame("Hello world!", $qrcode->text());

?>