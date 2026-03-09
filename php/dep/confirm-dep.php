<?php 
function sponsor_bonus($id_dep){

	include "../conn.php";
	
  	$email_user = $_SESSION['email'];
  	$email = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email_user'");

  	if($r_user=mysqli_affected_rows($con) >= 1){
  		
  		while ($sponsor_user =mysqli_fetch_array($email)) {
  			$id=$sponsor_user['id'];
  		}
  
    }
    	
  	//check last deposit valid
  	$select_dep = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_dep'");

  	if($r_dep=mysqli_affected_rows($con) >= 1){
  	
  		while ($dep=mysqli_fetch_array($select_dep)) {

  			$id_dep=$dep['id'];
  			$id_u = $id;
  			$quantidade = $dep['value'];
  			$data = $dep['data'];

  			//add % bonus
	    	$add_porcent1 = number_format(($quantidade / 100) * 3, 2, ".", "");
	    	$add_porcent2 = number_format(($quantidade / 100) * 2, 2, ".", "");
	    	$add_porcent3 = number_format(($quantidade / 100) * 1, 2, ".", "");

	    	$user_p = mysqli_query($con, "SELECT * FROM usuarios WHERE id='$id_u'");
      
	      //make callback api pagseguro and att status 1 for deposits paid

	    	//nivel 1 ref
	    	if($r_user_p=mysqli_affected_rows($con) >= 1){
	    		
	    		$data = date("m,j,Y g:i a");

	    		while ($sponsor_user = mysqli_fetch_array($user_p)) {
	
	    			$name_sponsor = $sponsor_user['sponsor'];
	    			$get_sponsor = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$name_sponsor'");
	    			$array_sponsor = mysqli_fetch_array($get_sponsor);
	    			$email = $array_sponsor['email'];

	    			//add percent 1
    				$att_porcent1 = mysqli_query($con, "UPDATE usuarios SET total_bonus=total_bonus+$add_porcent1 WHERE f_nome='$name_sponsor'");
    				
    				//add notification -> leader
	    			$title_not = base64_encode('Referral earn level 3'); 
 						$text_not = base64_encode("You earn amount $ ".$add_porcent1." by referral indication level 3 from ".$sponsor_user['f_nome'].", check your referral list for +info.");
						$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");

	    		}
	   		
		    	$eemail = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$name_sponsor'");
					if($row_user = mysqli_affected_rows($con) >= 1){

			    	//nivel 2 ref
			    	while ($rr_user= mysqli_fetch_array($eemail)) {
		
			    		$nname_sponsor = $rr_user['sponsor'];
			    		$get_sponsor = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$nname_sponsor'");
		    			$array_sponsor = mysqli_fetch_array($get_sponsor);
		    			$email = $array_sponsor['email'];

			    		//add percent 2
	    				$att_percent2 = mysqli_query($con, "UPDATE usuarios SET total_bonus=total_bonus+$add_porcent2 WHERE f_nome='$nname_sponsor'");
	    				
	    				//add notification -> leader
	    				$title_not = base64_encode('Referral earn level 2'); 
	 						$text_not = base64_encode("You earn amount $ ".$add_porcent2." by referral indication level 2 from ".$rr_user['f_nome'].", check your referral list for +info.");
							$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");
			    	}
		    	}
		    	
		    	$eeemail = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$nname_sponsor'");
				if($row_user = mysqli_affected_rows($con) >= 1){

			    	//nivel 3 ref
			    	while ($rrr_user = mysqli_fetch_array($eeemail)) {
		
			    		$nnname_sponsor = $rrr_user['sponsor'];
			    		$get_sponsor = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$nnname_sponsor'");
		    			$array_sponsor = mysqli_fetch_array($get_sponsor);
		    			$email = $array_sponsor['email'];

			    		//add percent 3 
	    				$att_percent3 = mysqli_query($con, "UPDATE usuarios SET total_bonus=total_bonus+$add_porcent3 WHERE f_nome ='$nnname_sponsor'");

	    				//add notification -> leader
	    				$title_not = base64_encode('Referral earn level 1'); 
	 						$text_not = base64_encode("You earn amount $ ".$add_porcent1." by referral indication level 1 from ".$rrr_user['f_nome'].", check your referral list for +info.");
							$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");
			    	}
				}   	
	    	}

  		}
      	
      	$check_dep_ref = mysqli_query($con, "SELECT * FROM referidos WHERE id_dep ='$id_dep'");
      
      	if ($r_check_dep = mysqli_num_rows($check_dep_ref) >= 1) {
      		
      	}else{

	    		//insert row on referidos table where status aproved
	    		$insert_ref_dep = mysqli_query($con, "INSERT INTO referidos (id_user,id_dep,quantidade,data) VALUES ('$id_u','$id_dep','$quantidade','$data') ");
      	}
  	}
	
}
?>
<?php 
	
	include "../conn.php";
	include "../functions.php";
	include "request_value_coin.php";

	session_start();

	$email = $_SESSION['email'];
	$confirm = $_POST['tx'];
	$id_charnum = $_POST['id_dep'];
	$amount_f = $_POST['amount_f'];

	$check1 = false;
	$check2 = false;
	$count1 = 0;
	$count2 = 0;
	$tx_alive = "true";

	$check_isset_tx = mysqli_query($con, "SELECT * FROM rel_deposits WHERE tx = '$confirm'");
	if($r_isset = mysqli_affected_rows($con) >= 1){

		//code invalid
		$tx_alive = "false";
		echo "tx invalid or already exists";
		exit();

	}else{
		//echo "<p>not found tx -->  countinue";
	}
	//

	$date=date_create();
	$timestamp = date_timestamp_get($date) * 1000;
	$startTime = $timestamp;

	$gen_hash_mac = hash_hmac('sha256', 'timestamp='.$timestamp.'&recvWindow=60000&txId='.$confirm, 'aTmQcyzEq5xbzj1nQSfpQNf9S2HhjiLE0en64hX3Cm2XKoxo39bIuvCYu1kRdcdj');

	$curl = curl_init();

	curl_setopt_array($curl, [
	  CURLOPT_URL => 'https://api.binance.com/sapi/v1/capital/deposit/hisrec?timestamp='.$timestamp.'&recvWindow=60000&txId='.$confirm.'&signature='.$gen_hash_mac.'',
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
	
	if($response === false){
	    echo 'Curl error: ' . curl_error($curl);
	    exit();
	}

	///echo $response; exit();
	curl_close($curl);

	//start if exist user->deposit on db
	$request_true = "false";
	
	$id_cmp = strlen($id_charnum);

	if($id_cmp > 8){

		$ar = str_split($id_charnum);
		$str_p = strpos($id_charnum,"-");
	
		$c = 0;
		$id = array();

		while($c < $id_cmp){

			$id[$c] = $ar[$c];
	
    		$c++;
		}

		$id_im = implode("",$id);

		$orig_id_charnum = $id_charnum;
		$id_charnum = $id_im;
	
	}

	$check_idnum_dep = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_charnum'");
	
	if($r_check = mysqli_affected_rows($con) >= 1){

		$array_dep = mysqli_fetch_array($check_idnum_dep);
		$id_dep = $array_dep['id_dep'];
		$dep_mode = $array_dep['coin'];
		$user = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		$array_user = mysqli_fetch_array($user);
		$id_user = $array_user['id'];
		$nome = $array_user['f_nome'];

		$check_dep_exist = mysqli_query($con, "SELECT * FROM deposits WHERE id = '$id_dep' AND id_user = '$id_user'");
		if($r_check_dep_exist = mysqli_affected_rows($con) >= 1){

			$request_true = "true";
			$ar_type_dep = mysqli_fetch_array($check_dep_exist);
			$type_dep = $ar_type_dep["type_dep"];

		}else{

			echo "user or deposit, invalid";
			$request_true = "false";
			exit();

		}
		//echo "true id dep";

	}else{
		
		$request_true = "false";
		echo "deposit invalid";
		exit();

	}
	//end if exist user->deposit on db

	$count_str = 0;	
	$ini_tx_count = 0;
	$max_count_str = strlen($response);
	$block = "false";
	$block_tx = "false";
	$end_get_hash = "false";
	$array_tx = array();
	$block_true = "false";
	$idx_init_get_val = 0;
	
	if($dep_mode  != "pix"){

		//check tx == true
		while($count_str < $max_count_str && $block == "false" && $tx_alive == "true" && $request_true == "true"){
			
			$str = $response[$count_str];
			
			if($str == "{"){
			
				$block = "true";
				$ini_tx_count = $count_str;
			
				while($ini_tx_count < $max_count_str && $block_tx == "false"){
					
					$c1 = $response[$ini_tx_count];
					$c2 = $response[$ini_tx_count+1];
					$c3 = $response[$ini_tx_count+2];
					$c4 = $response[$ini_tx_count+3];

					if($c1 == "t" && $c2 == "x" && $c3 == "I" && $c4 == "d"){

						$block_tx = "true";
		
						$ini_get_hash_id_count = $ini_tx_count+7;
						$max_limit_count_hash = $ini_get_hash_id_count + 66;

						while ($ini_get_hash_id_count < $max_limit_count_hash && $end_get_hash == "false") {
							
							if(is_string($response[$ini_get_hash_id_count]) && $response[$ini_get_hash_id_count] != '"'){
								
								$array_tx[$tx_count] = $response[$ini_get_hash_id_count];
								$tx_founded = implode('', $array_tx);
									
								if($tx_founded == $confirm){	
									
									$block_true = "true";
									$end_get_hash = "true";
									$block_tx = "true";
									$block = "true";

									$idx_init_get_val = $ini_tx_count;
									$count_str = $max_count_str+1;
									$ini_tx_count = $max_count_str+1;
									$ini_get_hash_id_count = $max_count_str+1;
							
								}

							}else{
		
								$tx_count= 0;
		
							}
							
							$ini_get_hash_id_count++;
							$tx_count++;

							$check_limit = $max_limit_count_hash - $ini_get_hash_id_count;
							if($check_limit <= 1){

								$tx_count = 0;
								$end_get_hash = "false";
								$block_tx = "false";
							
							}
				
						}
				
					}

					$ini_tx_count++;
				
				}
			
			}
			
			$count_str++;
		
		}
		//end check tx == true

		if($block_true == "false"){
			echo "tx invalid";
		}
		
		//start get_value transaction
		$added = "false";
		$data = date("m,j,Y g:i a");

		if($block_true == "true" && $tx_alive == "true" && $request_true == "true"){

			$block = "false";
			$block_get_value = "false";
			$block_check_value = "false";
			$count_str = $idx_init_get_val;
			$ini_value_count = 0;
			$ini_get_value_count = 0;
			$count_value = 0;
			$array_value = array();

			while($count_str >= 0 && $block == "false") {
				
				if($response[$count_str] == '"'){
					
					$ini_value_count = $count_str;
					while ($ini_value_count >= 0 && $block_get_value == "false") {
						
						$c1 = $response[$ini_value_count-3];
						$c2 = $response[$ini_value_count-2];
						$c3 = $response[$ini_value_count-1];
						$c4 = $response[$ini_value_count];

						if($c1 == "c" && $c2 == "o" && $c3 == "i" && $c4 == "n"){
							//echo "coin";
							$ini_get_value_count = $ini_value_count-7;

							while($ini_get_value_count >= 0 && $block_check_value == "false"){

								if($response[$ini_get_value_count] != '"'){

									$array_value[$count_value] = $response[$ini_get_value_count];

								}else{

									$block = "true";
									$block_get_value = "true";
									$block_check_value = "true";
									$count_str = -1;
									$ini_value_count = -1;
									$ini_get_value_count = -1;	

								}

								$count_value++;
								$ini_get_value_count--;

							}

						}

					$ini_value_count--;

					}

				}

				$count_str--;

			}

			//echo "<br><br>---".$block_true."<br>--";
			$str_value = strrev(implode('', $array_value));
		
			$get_value_dep = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_charnum'");
			
			$array_dep = mysqli_fetch_array($get_value_dep);
			
			$coin_dep = $array_dep['coin'];
			$value = $array_dep['value'];
			
			if($coin_dep == "usdt"){
				
				$comp_value = $value - $str_value;
				
				if($comp_value <= 1){
					//echo "true comp";
					$add_confirm = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_charnum'");
					if($radd = mysqli_affected_rows($con) >= 1){
					
						if($id_cmp <= 8){ //founds and package confirm
							
							$update_confirm = mysqli_query($con, "UPDATE rel_deposits SET tx = '$confirm' WHERE id_charnum = '$id_charnum'");

							$id_dep = $array_dep['id_dep'];
							$new_amount = number_format($str_value, 2, ".", "");
						
							$update_status = mysqli_query($con, "UPDATE rel_deposits SET status = '1', value = '$new_amount' WHERE id_charnum = '$id_charnum'");
							$update_status = mysqli_query($con, "UPDATE deposits SET quantidade ='$new_amount', status = '1' WHERE id = '$id_dep'");
							
							if($type_dep == "Founds"){
								mysqli_query($con, "UPDATE usuarios SET total_acc = total_acc + '$value' WHERE id = '$id_user'");
							}
							
							//start
							$check_rel_lt_dep = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_dep ='$id_charnum'");
		 		
					 		if($rows_rel_lt_dep = mysqli_affected_rows($con) >= 1){
					 			$lt_open_tkt = true;
					 		}else{
					 			$lt_open_tkt = false;
					 		}

					 		$t_tkt = $new_amount / 0.20;

					 		if($lt_open_tkt == false){
					 			mysqli_query($con, "INSERT INTO rel_lt_dep (id_dep,id_user,total_tickets,total_rest_tkt,data,status) VALUES ('$id_charnum','$id_user','$t_tkt','$t_tkt',$data,'1')");
					 		}
					 		//end

						}else{ //tkt confirm
							
							$update_confirm = mysqli_query($con, "UPDATE loterry_tkt_buyed SET status = '1', tx = '$confirm' WHERE rel_package = '$orig_id_charnum'");

							$get_value_dep = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE rel_package = '$orig_id_charnum'");
			
							$array_dep = mysqli_fetch_array($get_value_dep);
							
							$value = 0.20 * $array_dep['value'];

						}
						
						//tx found on api added now

						if($id_cmp <= 8){

							$subject = "deposit accepted";
							$tx = $confirm;
							$coin_name = strtoupper($coin_dep);

							//include "../email/emails_send.php";

							//add notification -> leader
			    			$title_not = base64_encode('Deposit confirmed'); 
							$text_not = base64_encode("You completed a new deposit successfully.");
							$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");

							//$add_earn_day = mysqli_query($con, "UPDATE usuarios SET total_acc=total_acc+'$value' WHERE id='$id_user'");
							sponsor_bonus($id_charnum); //id_dep

						}else{

							$subject = "deposit ticket accepted";
							$tx = $confirm;
							$coin_name = strtoupper($coin_dep);

							//include "../email/emails_send.php";

							//add notification -> leader
			    			$title_not = base64_encode('Deposit confirmed'); 
							$text_not = base64_encode("You completed a new tickets deposit successfully.");
							$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");

							//$add_earn_day = mysqli_query($con, "UPDATE usuarios SET total_acc=total_acc+'$value' WHERE id='$id_user'");
							//sponsor_bonus($id_charnum); //id dep

						}

						
						$added = "true";				
					}
				
				}else{

					$added = "val loss";
				}

			}else{

				//echo "other coin";
				$coin_name = strtoupper($coin_dep);
				$id_dep = $array_dep['id_dep'];

				if($id_cmp > 8){ //ticket confirm

					$get_value_dep = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE rel_package = '$orig_id_charnum'");
			
					$array_dep = mysqli_fetch_array($get_value_dep);
					
					$value = $array_dep['value'] / 0.20;
					$id_charnum = $orig_id_charnum;

					get_convert_value_coin($confirm, $amount_f, $value, $coin_name, $id_dep, $id_charnum, $email, $nome);
				
				}else{ //founds and packages confirm

					//start
					$check_rel_lt_dep = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_dep ='$id_charnum'");
 		
			 		if($rows_rel_lt_dep = mysqli_affected_rows($con) >= 1){
			 			$lt_open_tkt = true;
			 		}else{
			 			$lt_open_tkt = false;
			 		}

			 		$usd_v = $value;
			 		$t_tkt = $usd_v / 0.20;

			 		if($lt_open_tkt == false){
			 			mysqli_query($con, "INSERT INTO rel_lt_dep (id_dep,id_user,total_tickets,total_rest_tkt,data,status) VALUES ('$id_charnum','$id_user','$t_tkt','$t_tkt',$data,'1')");
			 		}
			 		//end

					get_convert_value_coin($confirm, $amount_f, $value, $coin_name, $id_dep, $id_charnum, $email, $nome);
					sponsor_bonus($id_charnum); //id dep
				}

				//add notification -> leader
				$title_not = base64_encode('Deposit confirmed'); 
				$text_not = base64_encode("You completed a new deposit successfully, waiting for rewards.<br>Id: ".$id_charnum.".");
				$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");

				//$add_earn_day = mysqli_query($con, "UPDATE usuarios SET total_acc=total_acc+'$value' WHERE id='$id_user'");
				
			}
		
		}

		if($added == "true"){
			echo "<p class='text-primary'>Deposit accepted</p>";
		}else if($added == "val loss"){
			echo "<p class='text-danger'>Invalid value, contact support.</p>";
		}
		//end get_value transation
  
	}
















	//https://blockexplorer.one/litecoin/mainnet/tx/hash id
	//get amount to check = Amount Transacted (text)
	//id wallet <a href="/litecoin/mainnet/address/LcNS6c8RddAMjewDrUAAi8BzecKoosnkN3">LcNS6c8RddAMjewDrUAAi8BzecKoosnkN3 <img src="/images-v2/copy.svg" onclick="copyToClipboard('LcNS6c8RddAMjewDrUAAi8BzecKoosnkN3'); return false"></a>
	//

	//https://www.blockchain.com/pt/explorer/transactions/btc/hash id / btc / segwith
	//https://tronscan.org/#/transaction/hash id /  trx-erc20
	//https://etherscan.io/tx/hash id usdt-erc20 / eth-erc20
	//https://www.bscscan.com/tx/hashid bnb-bep20 / usdt-bep20 / eth-bep20 /ltc-bep20 / bet-bep20
	//get amount to check = <i class=&quot;far fa-clock me-0.5&quot;></i> $1,435.63
	//from https://www.bscscan.com/address/0xa21ebd358f83aec3690a855e9e9420311fc18c01
	//
?>