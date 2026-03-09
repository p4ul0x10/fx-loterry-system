<?php
	
function get_convert_value_coin($tx, $value, $value_dep, $coin_name, $id_dep, $id_charnum, $email, $nome){
	
	include "../conn.php";
	$date = date_create();
	$timestamp = date_timestamp_get($date) * 1000;

	$curl = curl_init();

	curl_setopt_array($curl, [
	  CURLOPT_URL => 'https://api.binance.com/api/v3/ticker/price?symbol='.$coin_name.'USDT',
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

	$response_value = curl_exec($curl);
	$array_coin = str_split($response_value);
	$max_str = strlen($response_value);
	
	$init_value = 29;
	$array_value = array();
	$count_value = 0;

	for ($i=$init_value; $i <= $max_str; $i++) { 
		
		if($array_coin[$i] != '"' && $array_coin[$i] != '}'){
	
			$array_value[$count_value] = $response_value[$i];
			$count_value++;
	
		}
	
	}

	$convert_value_parse = implode("", $array_value);
	$convert_value = number_format($value * $convert_value_parse, 0, ".", "");
	
	$comp_value = $value_dep - $convert_value; 
	$comp_value_revert = ($comp_value) + 1; //for comp < 0
	//echo $convert_value." ".$value_dep;

	$added = "false";
	if($comp_value_revert >= 0.00 && $comp_value >= 0 && $comp_value <= 1){ //cmp df limit max <= 1 -> usdt 
		//echo "true comp";

		if(strlen($id_charnum) <= 8){ //package confirm

			$add_confirm = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_charnum'");
	
			if($radd = mysqli_affected_rows($con) >= 1){
			
				$update_confirm = mysqli_query($con, "UPDATE rel_deposits SET tx = '$tx' WHERE id_charnum = '$id_charnum'");
				//tx found on api added now

				$update_status = mysqli_query($con, "UPDATE rel_deposits SET status = '1' WHERE id_charnum = '$id_charnum'");
				$update_status = mysqli_query($con, "UPDATE deposits SET status = '1' WHERE id = '$id_dep'");
				$added = "true";				
	
			}

		}else{ //ticket confirm

			$update_confirm = mysqli_query($con, "UPDATE loterry_tkt_buyed SET status = '1', tx = '$confirm' WHERE rel_package = '$id_charnum'");
			$added = "true";
	
		}

	}else{

		$added = "val loss";
	
	}

	if($added == "true"){
		
		if(strlen($id_charnum) <= 8){
			$subject = "deposit accepted";
		}else{
			$subject = "deposit ticket accepted";
		}

		//include "../email/emails_send.php";

		echo "<p class='text-primary'>Deposit accepted</p>";

	}else if($added == "val loss"){
	
		echo "<p class='text-danger'>Invalid value, contact support.</p>";
	
	}

	curl_close($curl);
}

/*$val = "0.011";
$coin = 'ETH';
get_convert_value_coin($val, $coin);*/

?>