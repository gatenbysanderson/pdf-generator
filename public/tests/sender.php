<?php

$files = [
    'example' => new CURLFile(__DIR__ . '/example.html'),
];

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'http://192.168.33.99/tests/receiver.php');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $files);

curl_exec($curl);
