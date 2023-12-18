<?php
$api_url = 'http://openapi.nsdi.go.kr/nsdi/eios/nsdiMap.do';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if ($response === false) {
    die('Error occurred: ' . curl_error($ch));
}

curl_close($ch);

// API 응답을 확인해봅니다.
var_dump($response);
?>