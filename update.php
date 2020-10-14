<?php

header("Access-Control-Allow-Origin: *");

require 'config.php';
$lat = $_GET["lat"];
$lng = $_GET["lng"];

$postData = http_build_query([
    'topic' => $topic,
    'data' => json_encode(["lat" => $lat, "lng" => $lng]),
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $mercureURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

$headers = array();
$headers[] = "Authorization: Bearer " . $mercureJWT;
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
