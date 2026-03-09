<?php
	
	//
	include "../conn.php";
	$date=date_create();
	$timestamp = date_timestamp_get($date) * 1000;

	$coin = "BTC";
	$wallet = "3NbG3mMKwxUqFU8h3T5qZhPbZmR35CRDg9";
	$amount = "0.0001";
	$gen_hash_mac = hash_hmac('sha256', 'timestamp='.$timestamp.'&recvWindow=60000&coin='.$coin.'&address='.$wallet.'&amount='.$amount, 'aTmQcyzEq5xbzj1nQSfpQNf9S2HhjiLE0en64hX3Cm2XKoxo39bIuvCYu1kRdcdj');

	$curl = curl_init();

	curl_setopt_array($curl, [
	  CURLOPT_URL => 'https://api.binance.com/sapi/v1/capital/withdraw/apply?timestamp='.$timestamp.'&recvWindow=60000&coin='.$coin.'&address='.$wallet.'&amount='.$amount.'&signature='.$gen_hash_mac,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  //CURLOPT_POSTFIELDS => json_encode(['call' => 'PesquisarLancamentos', 'app_key' => 'XXXXXXXXX','app_secret' => 'XXXXXXXXXX']),
	  CURLOPT_HTTPHEADER => [
	  	'X-MBX-APIKEY: xqUruwzJ01olz5Uno1tCkankGFVaUWzYuKeVKh0qqSIPVSQQWeNwitCfkAbgRxNw',
	    'Content-type: application/json'
	  ],
	]);

	$response_value = curl_exec($curl);
	echo $response_value;
	//
?>