<?php

use Minishlink\WebPush\WebPush;

$endpoint = 'https://android.googleapis.com/gcm/send/abcdef...'; // Chrome

$auth = [
    'GCM' => 'MY_GCM_API_KEY', // deprecated and optional, it's here only for compatibility reasons
    'VAPID' => [
        'subject' => 'https://bubble.rorydobson.com', // can be a mailto: or your website address
        'publicKey' => 'BP7vLpKSxbsOv4085FziNHN8nZEQYYPvgLqgOOghiFYVdsiRXAbqZnzCuLrCKWP6S3gsM_4TzkFO5Fk5yv7D330', // (recommended) uncompressed public key P-256 encoded in Base64-URL
        'privateKey' => '3gsDjggr_P-sSnyQoel8xaNozZOPLO1nUzuwe4KbwjE', // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
        'pemFile' => 'private_key.pem', // if you have a PEM file and can link to it on your filesystem
        'pem' => '-----BEGIN EC PARAMETERS-----
        BggqhkjOPQMBBw==
        -----END EC PARAMETERS-----
        -----BEGIN EC PRIVATE KEY-----
        MHcCAQEEIN4LA44IK/z/rEp8kKHpfMWjaM2TjyztZ1M7sHuCm8IxoAoGCCqGSM49
        AwEHoUQDQgAE/u8ukpLFuw6/jTzkXOI0c3ydkRBhg++AuqA46CGIVhV2yJFcBupm
        fMK4usIpY/pLeCwz/hPOQU7kWTnK/sPffQ==
        -----END EC PRIVATE KEY-----', // if you have a PEM file and want to hardcode its content
    ],
];

$webPush = new WebPush($auth);
$webPush->sendNotification(...);

?>