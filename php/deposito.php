<?php session_start();

	$host = $_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	
	include "conn.php";

	$nome = $_POST['nome'];
	$email = $_SESSION['email'];
 	$cpf = "cpf teste";
 	$valor = $_POST['valor'];    
 	$data = date("m,j,Y g:i a"); //date("d/m/Y");
 	$subject = $_POST['subject'];

 	$plan = $_POST['plan'];
 	$coin = $_POST['coin'];

 	if(isset($_POST['convert'])){
 		$convert_coin = $_POST['convert'];	
 	}
 	
 	$prot = $_POST['prot'];
 	
 	$plan_b = true;
 	$coin_b = true;
 	$insert_data = true;

	/*echo "<p class='text-primary'>nome: ".$nome." email: ".$email." cpf".$cpf = "cpf teste"." valor".$valor." data".$data;
	echo $subject." plan: ".$plan;
	echo "true";
	exit();
	*/

 	if(strlen($nome) <= 16){
		$namestrl = true;
	}else{
		$namestrl = false;
	}

	if(!is_numeric($valor)){
		$novalue = true;
	}else{
		$novalue = false;
	}
	
	if(!isset($plan) || $plan == ""){ $plan = "buy-package"; }

 	if($plan != "buy-package" && $plan != "founds" && $plan != "tkt"){

 		echo $plan."Invalid plan !";
 		$plan_b = false;
 		exit();

 	}

 	if($plan == "buy-package"){ 

 		if($valor < 0.2){
 			$coin_b = false;
 			$plan_b = false;
 			echo "Min for tickets $ 0.2";
 			exit();
 		}

 		if($valor > 50000){
 			echo "Max for ".$plan." Plan $ 250";
 			exit();
 		}

 	}else if($plan == "founds"){
 		
 		if($valor < 5){
 			$coin_b = false;
 			$plan_b = false;
 			echo "Min for ".$plan." Plan $ 5";
 			exit();
 		}

 		$plan = "Founds";
 	}

 	if($coin == "pix-nubank"){ $coin = "pix"; }

 	if($coin != "btc" && $coin != "tron" && $coin != "usdt" && $coin != "ltc" && $coin != "bnb" && $coin != "eth" && $coin != "pix" && $plan != "tkt"){
 	
 		echo "Invalid coin !";
 		$coin_b = false;
 		exit();
 	
 	}

 	if($plan_b != true || $coin_b != true){

 		echo "Error, try again.";
 		$coin_b = false;
 		exit();
 	
 	}

 	if($coin == "btc"){

		$count = 4;
		$qr_wallet = array("0" => "images/qr-code/bitcoin.png", "1" => "images/qr-code/btc-bep20.png",  "2" => "images/qr-code/btc-segwit.png");

	}else if($coin == "eth"){
		
		$count = 4;
		$qr_wallet = array("0" => "images/qr-code/eth-erc20.png", "1" => "images/qr-code/eth-bep20.png", "2" => "images/qr-code/eth-erc20.png", "3" => "images/qr-code/eth-bep20.png");

	}else if($coin == "tron"){

		$count = 4;
		$qr_wallet = array("0" => "images/qr-code/trx-trc20.png", "1" => "images/qr-code/trx-bep20.png");

	}else if($coin == "ltc"){

		$count = 4;
		$qr_wallet = array("0" => "images/qr-code/ltc.png", "1" => "images/qr-code/ltc-bep20.png");

	}else if($coin == "bnb"){

		$count = 4;
		$qr_wallet = array("0" => "images/qr-code/bnb-bep20.png", "1" => "images/qr-code/bnb-bep20.png");

	}else if($coin == "usdt"){

		$count = 4;
		$qr_wallet = array("0" => "images/qr-code/tether-erc20.png", "1" => "images/qr-code/tether-bep20.png", "2" => "images/qr-code/tether-erc20.png", "3" => "images/qr-code/tether-bep20.png");
	
	}else if($coin == "pix"){
		
		$count = 4;
		$qr_wallet = array("0" => "images/qr-code/pix.png", "1" => "images/qr-code/pix.png");
	
	}else{

		if($plan != "tkt"){
			echo "coin not detected";
			exit();
		}

	}

	if($coin == "btc"){

		$list_prot = array(0 => "btc", 1 => "btc-bep20", 2 => "Segwit");
		$list_wallet = array(0 => "16pb3x9bmtiHPAi9fGa1xiwL5YeVA39k72", 1 => "0x505f451b6ac608d857b28aee3df91616e7bbc845", 2 => "bc1q2hd5jwv6luy3rnqe00727dnx0ufuxg62xu72fg");

	}else if($coin == "eth"){

		$list_prot = array(0 => "eth-erc20", 1 => "eth-bep20", 2 => "arbitrum", 3 => "base");
		$list_wallet = array(0 => "0x505f451b6ac608d857b28aee3df91616e7bbc845", 1 =>  "0x505f451b6ac608d857b28aee3df91616e7bbc845", 2 => "0x505f451b6ac608d857b28aee3df91616e7bbc845", 3 => "0x505f451b6ac608d857b28aee3df91616e7bbc845");

	}else if($coin == "tron"){

		$list_prot = array(0 => "trx-trc20", 1 => "trx-bep20");
		$list_wallet = array(0 => "0x505f451b6ac608d857b28aee3df91616e7bbc845", 1 => "TSxGRXKUhxHxegQuuBSC1k7r1pDcqbJGAQ");

	}else if($coin == "ltc"){

		$list_prot = array(0 => "ltc", 1 => "ltc-bep20");
		$list_wallet = array(0 => "LLY2NBhgBCYUYucugWzDPWqczxi11MNzqu", 1 => "0x505f451b6ac608d857b28aee3df91616e7bbc845");

	}else if($coin == "bnb"){

		$list_prot = array(0 => "bnb-bep20", 1 => "opbnb");
		$list_wallet = array(0 => "0x505f451b6ac608d857b28aee3df91616e7bbc845", 1 => "0x505f451b6ac608d857b28aee3df91616e7bbc845");

	}else if($coin == "usdt"){

		$list_prot = array(0 => "tether-erc20", 1 => "tether-bep20", 2 => "arbitrum", 3 => "avaxc");
		$list_wallet = array(0 => "0x505f451b6ac608d857b28aee3df91616e7bbc845", 1 => "TSxGRXKUhxHxegQuuBSC1k7r1pDcqbJGAQ", 2 => "0x505f451b6ac608d857b28aee3df91616e7bbc845", 3 => "0x505f451b6ac608d857b28aee3df91616e7bbc845");

	}else if($coin == "pix"){

		$list_prot = array(0 => "pix-nubank");
		$list_wallet = array(0 => "0x505f451b6ac608d857b28aee3df91616e7bbc845");

	}else{

		if($plan != "tkt"){
			echo "Error prot not defined";
		}

	}
	//

	//
	$valid_prot = "null";
	
	for ($i=0; $i <= $count; $i++) { 
	
		if($prot == $list_prot[$i]){
		
			$valid_prot = "true";
			$url_qr = $qr_wallet[$i];
		 	$wallet = $list_wallet[$i];
			
			break;

		}
	}

	if($valid_prot == "null" && $plan != "tkt"){
		exit();
	}
	//

	//
 	if($insert_data == true && $plan_b == true && $coin_b == true && $novalue == false && $namestrl == true) {
 
	 	if($plan == "Starter" && $valor < 5) {
	 		echo "<p class='text-danger'>Min value for deposit $ <b class='text-warning'>1</b></p>";
	 		exit();
	 	}

	 	if($plan == "Advanced" && $valor < 25) {
	 		echo "<p class='text-danger'>Min value for deposit $ <b class='text-warning'>1</b></p>";
	 		exit();
	 	}

	 	if($plan == "Premium" && $valor < 1000) {
	 		echo "<p class='text-danger'>Min value for deposit $ <b class='text-warning'>1</b></p>";
	 		exit();
	 	}

	 	if($plan == "founds" && $valor < 5) {
	 		echo "<p class='text-danger'>Min value for deposit $ <b class='text-warning'>$5</b></p>";
	 		exit();
	 	}
	 	
	 	$getuser = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
	 	if($ru = mysqli_affected_rows($con) > 0){
	 	
	 		while ($user = mysqli_fetch_array($getuser)) {
	 			$id_user = $user['id'];
	 			$total_acc = $user['total_acc'];
	 		}
	 	
	 	}else{
	 	
	 		echo "<p class='text-danger'>Error in loading deposit...</p>";
	 		exit();
	 	
	 	}

	 	$confirm_dep = "false";

	 	if($plan != "tkt"){
	 		
	 		if($plan != "Founds" || $plan != "founds"){
	 			$plan = "Package";
	 		}
			
			$total_rest_buy = $total_acc - $valor;

	 		if($total_rest_buy < 0){
	 			exit();
	 		}

	 		$deposito = mysqli_query($con, "INSERT INTO deposits (quantidade,id_user,data,nome,address,status,type_dep,proto) VALUES ('$valor','$id_user','$data','$nome','$cpf','1','$plan','$prot')");
	 		$get_last_dep = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id_user' ORDER BY id DESC LIMIT 1");
	 		$array_id_last_dep = mysqli_fetch_array($get_last_dep);
	 		$last_dep_id = $array_id_last_dep['id'];
	 		$insert_payments_add = mysqli_query($con, "INSERT INTO net_protos (id_dep,net,wallet,qr_code) VALUES ('$last_dep_id','$prot','$wallet','$url_qr')");

	 		if($r = mysqli_affected_rows($con) >= 1 && $plan != "tkt"){

		 		$count = 0;
		 		$randar = array();
		 		$rand_num = "";
		
		 		$array_alfa = array(0 => "a", 1 => "b", 2 => "c", 3 => "d", 4 => "e", 5 => "f", 6 => "g", 7 => "h", 8 => "i", 9 => "j", 10 => "k", 11 => "l", 12 => "n", 13 => "m", 14 => "o", 15 => "p", 16 => "q", 17 => "r", 18 => "s", 19 => "t", 20 => "u", 21 => "v", 22 => "w", 23 => "x", 24 => "y", 25 => "z");

		 		$valid_num = false;

		 		while($valid_num == false){

		 			while($count < 8){
		 				
		 				$rand_ini = rand(1, 2);
		 				if($rand_ini % 2 == 0){
		 			
		 					$rand_num = rand(0, 9);
		 					$randar[$count] = $rand_num;
		 			
		 				}else{

		 					$rand_alfa = rand(0, 25);
		 					$rand_num_alfa = $array_alfa[$rand_alfa];
		 					$randar[$count] = $rand_num_alfa; 
		 			
		 				}
		 			
		 				$count++;
		 			}
		 			
		 			$rand_str = $randar[0]."".$randar[1]."".$randar[2]."".$randar[3]."".$randar[4]."".$randar[5]."".$randar[6]."".$randar[7];
		 			$comp_dep = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$rand_str'");

		 			if($comp_dep = mysqli_affected_rows($con) < 1){ //valid num -> not found in db
		 			
		 				$valid_num = true;

		 			}else{
		 			
		 				$count = 0;
		 			}

		 			$get_dep_added = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id_user' ORDER BY id DESC LIMIT 1");

			 		if($r_dep_added = mysqli_affected_rows($con) >= 1 && $valid_num == true){

			 			while($array_last_dep = mysqli_fetch_array($get_dep_added)){
			 				$id_dep = $array_last_dep['id'];
			 			}

			 			if($plan == "Founds"){
			 				$seconds = 86400;
			 				$status = "0";
			 			}else{
			 				$seconds = 0;
			 				$status = "1";
			 				$tkts = $valor / 0.2;
			 			}
			 			
			 			$hms = $seconds;

			 			$insert_rel_dep = mysqli_query($con, "INSERT INTO rel_deposits (id_dep,id_charnum,status,coin,value,data,plan,hms) VALUES ('$id_dep','$rand_str','$status','$coin','$valor','$data','$plan','$hms')");
			 		
			 			if($plan == "Package"){
			 				mysqli_query($con, "UPDATE usuarios SET total_acc = total_acc - '$valor' WHERE id = '$id_user'");
			 				mysqli_query($con, "INSERT INTO rel_lt_dep (id_dep,id_user,total_tickets,total_rest_tkt,data) VALUES ('$rand_str','$id_user','$tkts','$tkts','$data')");
			 			}

			 			$confirm_dep = "true";

			 		}else{
		 	
		 				echo "<p class='text-danger'>Erro ao processar deposito ...</p>";
		 	
		 			}

		 		}

		 	}
	 		//end  

	 		//start dep confirmed
	 		if($confirm_dep == "true"){

		 		$title_not = base64_encode("Deposit ".$plan." created");
	 		    $href = '#';

	 		    if($coin != "usdt"){
	 				$text_not = base64_encode("Deposit, ".$rand_str." amount $ ".$valor." in ".$coin." created successfully, check your deposit list for +info.");
	 			}else{
	 				$text_not = base64_encode("Deposit, ".$rand_str." amount $ ".$valor." ".$coin." created successfully, check your deposit list for +info.");
	 			}
			
				$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");

		 		if($r_rel = mysqli_affected_rows($con) >= 1 && $valid_num == true){

		 			$insert_data_pay = mysqli_query($con, "INSERT INTO data_dep_pay (data,valor,id_charnum) VALUES ('$data','$valor','$rand_str')");
		 			
		 			$tkts = $valor / 0.2;
		 			
		 			echo "<p class='dv color-theme'>Deposit confirmed, ".$tkts." Buyed <i class='fa fa-check'></i></p><br>
		 			<small class='plan-deposit color-theme'>Check our deposits section, for more info.</small>";
		 			
		 			$subject = "deposit";
			    	include "email/emails_send.php";
			    
				}

			}
			//end

		    /*$mail = new PHPMailer(true);
		    try
		    {
		        // Configurações do servidor
		        $mail->isSMTP();        //Devine o uso de SMTP no envio
		        $mail->SMTPAuth = true; //Habilita a autenticação SMTP
		        $mail->Username   = "undercrazyal@gmail.com";
		        $mail->Password   = "njoe trod demo bpmt";
		        // Criptografia do envio SSL também é aceito
		        $mail->SMTPSecure = 'TLS';
		        // Informações específicadas pelo Google
		        $mail->Host = 'smtp.gmail.com';
		        $mail->Port = 587;
		        // Define o remetente
		        $mail->setFrom('undercrazyal@gmail.com', 'FXROBOT');
		        // Define o destinatário
		        $mail->addAddress($email, 'Destinatário');
		        //$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );
		        // Conteúdo da mensagem

		        $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
		        $mail->CharSet = 'UTF-8'; 
		        $mail->Subject = 'Deposito criado';
		        $mail->Body    = 'Olá <b>'.$nome.'</b>,<br>Pedido de deposito criado no valor de '.$valor.' aguardando pagamento.<br> <a href="http://fxrobot.free.nf/" title="FXROBOT"><img src="http://fxrobot.free.nf/images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="35px"></a>';
		        
		        // Enviar
		        $mail->send();
		        //echo 'A mensagem foi enviada!';
		    }
		    catch (Exception $e)
		    {
		        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		    }*/
			
	 	}

	 	if($plan == "tkt"){

	 		$id_dep = $_POST['id_dep'];
			$get_protos =mysqli_query($con, "SELECT * FROM net_protos WHERE id > 0");

			$n = 0;
			$nstr = 0;
			$nn = 0;
			$f = 0;

			$str_id_dep = str_split($id_dep);
			
			while($ar_protos = mysqli_fetch_array($get_protos)){

				if(strlen($ar_protos['id_dep']) < 8){
					$get_prot = "proto";
				}else{
					$get_prot = base64_decode($ar_protos['id_dep']);
				}

				$ar_prot = $get_prot;
				
				$str_proto = str_split($ar_prot);
				$len_proto = strlen($ar_prot);
				
				while($nstr < $len_proto) {

					if($str_proto[$nstr] == $str_id_dep[$nstr]){

						$prot = $ar_protos['net'];
						$f++;
					
					}	

					$nstr++;

				}

				if($f >= 7){

					break;
					$nn = 1000;

				}else{

					$f = 0;
				
				}

				$nstr = 0;
				$f = 0;
				$nn++;

				$n++;
					
			}

			if($f < 8){
				exit();
			}

			//start  
			$check_dep = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum ='$id_dep'");	

		 	if($r = mysqli_affected_rows($con) >= 1 && $plan == "tkt"){

		 		//start found rows -> rel_id_charnum on loterry tickets buyed table
		 		$query_tkt = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id_user' ORDER BY id DESC LIMIT 1");

		 		if($r_tkt = mysqli_affected_rows($con) >= 1){
		 			
		 			while($array_tkt_ids = mysqli_fetch_array($query_tkt)){
			 			
			 			$ar_str = str_split($array_tkt_ids['rel_package']);
			 			$str_p = strpos($array_tkt_ids['rel_package'],"-");
						 			
						$c = 0;
						$id = array();

						while($c < $str_p){

							$id[$c] = $ar_str[$c];
				    		$c++;

						}

						$id_im = implode("",$id);
					 
						if($id_dep == $id_im){ //add new increment for package

							$get_last_id = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id_user' AND rel_package LIKE '%$id_dep%' ORDER BY id DESC LIMIT 1");

							$ar_last_id = mysqli_fetch_array($get_last_id);
							$last_id = $ar_last_id['rel_package'];

							$ar_str = str_split($last_id);
				 			$str_p = substr($last_id, 9);
						 		
			 				$id_val = $str_p + 1;
			 				$id_user_val = $id_dep."-".$id_val;

			 			}else{ //add new id package rel
			 				
			 				$one = 1;
			 				$id_user_val = $id_dep."-".$one;
			 			
			 			}
			 			
		 			}

		 		}else{ //first package rel per user

		 			$one = 1;
		 			$id_user_val = $id_dep."-".$one;
		 		
		 		}
		 		//end
		 		
		 		//start
		 		$session_lt = mysqli_query($con,"SELECT * FROM info WHERE id = 1");
		 		$array_lt = mysqli_fetch_array($session_lt);
		 		$ltsession = $array_lt['lt_session'];
		 		
				$lthms = 0;
		 		$status = 1;
		 
		 		$get_rest_tkt = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_dep ='$id_dep' AND id_user = '$id_user'");
		 		
		 		$array_rest_tkt = mysqli_fetch_array($get_rest_tkt);
		 		$total_rest_tkt = $array_rest_tkt['total_rest_tkt'];

				$check_dec_rest = $total_rest_tkt - $valor;

				$rest_val_tkt_val_usdt = 0.20 * $total_rest_tkt;
				$val_tkt_val_usdt = 0.20 * $valor;
				
				$rest_val_tkt_val_usdt = $rest_val_tkt_val_usdt - $val_tkt_val_usdt;

				if($check_dec_rest >= 0.00 && $rest_val_tkt_val_usdt >= 0.00){

					$dec_rest_tkt = mysqli_query($con, "UPDATE rel_lt_dep SET total_rest_tkt = total_rest_tkt - '$valor' WHERE id_dep = '$id_dep' AND id_user = '$id_user'");
					
					mysqli_query($con, "INSERT INTO loterry_tkt_buyed (rel_package,id_user,value,data,current_session,status,lthms) VALUES ('$id_user_val','$id_user','$valor','$data','$ltsession','$status','$lthms')");
				
				}else{

					exit();

				}	 		

				$select_buy_tkt = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE rel_package='$id_user_val' ORDER BY id DESC LIMIT 1");
			
				$array_id_last_dep = mysqli_fetch_array($select_buy_tkt);
		 		$last_dep_id = base64_encode($id_user_val); //$id_dep."-".$array_id_last_dep['id'];

				mysqli_query($con, "INSERT INTO net_protos (id_dep,net) VALUES ('$last_dep_id','$prot')");	
		 		//end 

		 		//start check for new user -> on total active for reward
				$tickets_buyed = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id > 0");

				$users_num = 0;
				$last_id = 0;
				
				while($array_tkt_buyed = mysqli_fetch_array($tickets_buyed)){
					
					if($last_id != $array_tkt_buyed['id_user']){
						$last_id = $array_tkt_buyed['id_user'];
						$users_num++;
					}

				}

				mysqli_query($con, "UPDATE info SET user_per_session=$users_num WHERE id ='1'");
		 		//end check for new user -> on total active for reward
		 		
		 		//start
		 		$rake_status = 0;
		 		$ar_rel_dep = mysqli_fetch_array($check_dep);
		 		$porcent_dep = $ar_rel_dep['value'];
		 		
		 		if($ar_rel_dep['plan'] == "Starter"){
		 			$inc = 3;
		 		}else if($ar_rel_dep['plan'] == "Advanced"){
		 			$inc = 6;
		 		}else if($ar_rel_dep['plan'] == "Premium"){
		 			$inc = 10;
		 		}

		 		$confirm_dep = "true";
		 		$porcent_dep = $inc * $ar_rel_dep['value'] / 100;

				$insert_rake = mysqli_query($con, "INSERT INTO dep_rakeback (id_user,rel_dep,value,data,status) VALUES ('$id_user','$id_user_val','$porcent_dep','$data','$status')");
		 		//end		
		 		
		 		//start 
	 			if($confirm_dep == "true"){

			 		$title_not = base64_encode("Deposit ".$plan." created");
		 		    $href = '#';
		 		    if($coin != "usdt"){
		 				$text_not = base64_encode("Deposit, ".$id_user_val." amount $ ".$valor." in ".$coin." created successfully, check your deposit list for +info.");
		 			}else{
		 				$text_not = base64_encode("Deposit, ".$id_user_val." amount $ ".$valor." ".$coin." created successfully, check your deposit list for +info.");
		 			}
				
					$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");

			 		if($r_rel = mysqli_affected_rows($con) >= 1 && $valid_num == true){

			 			$insert_data_pay = mysqli_query($con, "INSERT INTO data_dep_pay (data,valor,id_charnum) VALUES ('$data','$valor','$rand_str')");
			 			
			 			echo "------------------------<br>";
			 			echo "WALLET: ".$wallet."<br>";
			 			echo "<img src='".$url_qr."' width='150px' height='150px' alt='qr code'><br>deposit valid, waiting payment <i class='fa fa-check'></i></p><br><small class='plan-deposit'>Check our deposits section, for more info.</small>";
			 			
			 			$subject = "deposit";
				    	include "email/emails_send.php";
				    
					}
				}
				//end
		 		
		 		//start tkt order success
		 		$data_f = "<p class='text-success mt-4'>Tickets request created...</p>";
		 		$valor = $_POST['valor']; 

		 		$get_lt_data = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_user = '$id_user' AND total_rest_tkt > '0'");

                  $rows_lt_data = mysqli_num_rows($get_lt_data);
                  if($rows_lt_data > 0){

                    $list_packages = "";
                    
                    while($array_rel_lt = mysqli_fetch_array($get_lt_data)){

                    	if($array_rel_lt['id_dep'] == $id_dep){
                    		$dep_class = "nav-item choose-package bg-theme text-light";
                    	}else{
                    		$dep_class = "nav-item choose-package color-theme";
                    	}

	                   	$list_packages = $list_packages.'<li id="#'.$array_rel_lt['id_dep'].'" class="'.$dep_class.'" onclick="package_li(id);">
	                 #'.$array_rel_lt['id_dep'].'<a id="#trt'.$array_rel_lt['total_rest_tkt'].'" class="nav-link text-muted" title="#'.$array_rel_lt['id_dep'].'" href="#tkt"><small style="top: 0px;"> '.$array_rel_lt['total_rest_tkt'].' tickets rest of the '.$array_rel_lt['total_tickets'].'</small></a></li>';  
                		
                	} 

		 		}
		 		//end

		 		$ar_return = array(0 => $data_f, 1 => 'Tickets request created...', 2 => $list_packages);
				$json = json_encode($ar_return);

				echo $json;

		 	}else{
		 	
		 		echo "<p class='text-danger'>Error while process your request, try again...</p>";
		 	
		 	}
	 	}	
	 
	 	//$acc_add = mysqli_query($con, "UPDATE usuarios SET total_acc=total_acc+$valor WHERE email='$email'"); 

 	}else{
 		
 		echo "null";
 	}
?>