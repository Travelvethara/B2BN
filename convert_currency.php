<?php
$from_currency  = "INR";
$to_currency = "USD";
$amount = 12;
$url = "https://free.currencyconverterapi.com/api/v5/convert?q=USD_INR&compact=ultra"; 
$cur=curl_init();
curl_setopt($cur,CURLOPT_URL,$url);
curl_setopt($cur, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($cur,CURLOPT_HTTPHEADER,array('Accept:application/xml'));
curl_setopt($cur, CURLOPT_HTTPHEADER, array('Content-Type: text/xml,charset=UTF-8'));
curl_setopt($cur, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($cur, CURLOPT_RETURNTRANSFER,1);
$currency_curl_value = curl_exec($cur);
$cureency_result = json_decode($currency_curl_value, true);
echo '<pre>';
print_r($cureency_result);
echo '</pre>';
$min_price_room_price = $cureency_result['INR_USD'] * 10;

?> 