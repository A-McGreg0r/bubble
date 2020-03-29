<?php

use Minishlink\WebPush\WebPush;

$endpoint = 'https://android.googleapis.com/gcm/send/abcdef...'; // Chrome

$auth = [
    //'GCM' => 'MY_GCM_API_KEY', // deprecated and optional, it's here only for compatibility reasons
    'VAPID' => [
        'subject' => 'https://bubble.rorydobson.com', // can be a mailto: or your website address
        'publicKey' => file_get_contents(__DIR__ . '/../webpush/public_key.txt'), // (recommended) uncompressed public key P-256 encoded in Base64-URL
        'privateKey' => file_get_contents(__DIR__ . '/../webpush/private_key.txt'), // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
        'pemFile' => '/../webpush/private_key.pem', // if you have a PEM file and can link to it on your filesystem
        'pem' => file_get_contents(__DIR__ . '/../webpush/private_key.pem'), // if you have a PEM file and want to hardcode its content
    ],
];

$webPush = new WebPush($auth);
$webPush->sendNotification(...);

?>