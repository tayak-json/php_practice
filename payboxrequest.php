<?php

$pg_merchant_id = '542568';
$secret_key = 'MvSm3ditU69XBr3Y';

$request = $requestForSignature = [
    'pg_order_id' => '237864375',
    'pg_merchant_id' => $pg_merchant_id,
    'pg_amount' => '25',
    'pg_description' => 'test',
    'pg_salt' => 'random',
];

ksort($requestForSignature);
array_unshift($requestForSignature, 'init_payment.php');
array_push($requestForSignature, $secret_key);
$request['pg_sig'] = md5(implode(';', $requestForSignature));
//var_dump($requestForSignature);
//var_dump($request);
$requestToPb = curl_init('https://api.freedompay.money/init_payment.php');
curl_setopt($requestToPb, CURLOPT_POST, true);
curl_setopt($requestToPb, CURLOPT_POSTFIELDS, http_build_query($request, '', '&'));
curl_setopt($requestToPb, CURLOPT_RETURNTRANSFER, true);
curl_setopt($requestToPb, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($requestToPb, CURLOPT_HEADER, false);
$result = curl_exec($requestToPb);
curl_close($requestToPb);
var_dump($result);