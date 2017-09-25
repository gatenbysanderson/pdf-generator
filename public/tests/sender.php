<?php

$file = new CURLFile(__DIR__ . '/example.txt');

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, '192.168.33.99/receiver.php');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $file);
