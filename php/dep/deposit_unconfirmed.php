<?php 

	$date = date_create();
	$timestamp = date_timestamp_get($date) * 1000;

	$gen_hash_mac = hash_hmac('sha256', 'timestamp='.$timestamp.'&recvWindow=60000', 'aTmQcyzEq5xbzj1nQSfpQNf9S2HhjiLE0en64hX3Cm2XKoxo39bIuvCYu1kRdcdj');
	//echo $date_f."-".$gen_hash_mac;
	$curl = curl_init();

	curl_setopt_array($curl, [
	  CURLOPT_URL => 'https://api.binance.com/sapi/v1/capital/deposit/hisrec?timestamp='.$timestamp.'&recvWindow=60000&signature='.$gen_hash_mac.'',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  //CURLOPT_POSTFIELDS => json_encode(['call' => 'PesquisarLancamentos', 'app_key' => 'XXXXXXXXX','app_secret' => 'XXXXXXXXXX']),
	  CURLOPT_HTTPHEADER => [
	  	'X-MBX-APIKEY: xqUruwzJ01olz5Uno1tCkankGFVaUWzYuKeVKh0qqSIPVSQQWeNwitCfkAbgRxNw',
	    'Content-type: application/json'
	  ],
	]);

	$response = curl_exec($curl);
	if(curl_exec($curl) === false)
	{
	    echo 'Curl error: ' . curl_error($curl);
	}
	else
	{
	    echo 'Operation completed without any errors';
	}
	curl_close($curl);
	echo "==".$response['amount'];
?>