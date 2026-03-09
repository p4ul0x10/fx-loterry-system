<?php  

$host =$_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}
//ini_set( 'display_errors', 0);
 session_start();
 include "conn.php";

 $email = $_SESSION['email'];
 $valor = $_POST['valor'];
 $nome = $_POST['nome_user'];
 $id_dep = addslashes($_POST['id_dep']);
 $wallet = addslashes($_POST['wallet']);
 $subject = addslashes($_POST['subject']);
 $coin_with = addslashes($_POST['coin']);
 $proto = addslashes($_POST['prot']);
 $type_out = addslashes($_POST['type_out']);
 //$amount_f = addslashes($_POST['amount_f']);
 $data = date("m,j,Y g:i a"); //date("d/m/Y");

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

$usr_query = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

if($r_usr=mysqli_affected_rows($con) >= 1) {

	while ($id=mysqli_fetch_array($usr_query)) {
		$uid=$id['id'];
	}

	$info_with = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");

	if($row_info_with = mysqli_affected_rows($con) >= 1){

		$array_info = mysqli_fetch_array($info_with);
		$with_mode = $array_info['with_mode'];

		$check_saldo = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");
	 	$array_total=mysqli_fetch_array($check_saldo);

 		$total_v = $array_total['total_disp'];
 		if($type_out == "loterry"){
 	
 			$get_loterry_amount_rest = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_dep = '$id_dep' AND id_user ='$uid'");
 			$array_amount_rest = mysqli_fetch_array($get_loterry_amount_rest);
 			
 			if($valor > $array_amount_rest['total_rest_tkt']){
 				$request_with = "invalid";
 			}else{
 				$request_with = "valid";
 			}
 		
 		}

 		if($valor < 1){

 			echo "<p class='text-danger'>Minimum withdrawal allowed is <b>$ 1</b>.</p>";
 			exit();
 		
 		}else if($valor > $total_v){

 			echo "<p class='text-danger'>Oops, withdrawal amount is greater than the current balance.</p>";

 		}else{
 		
		 	if($r=mysqli_affected_rows($con) >= 1 && $novalue == false && $namestrl == true && $request_with == "valid") {

				$get_rel_dep_val = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_dep'");
				
				$array_dep = mysqli_fetch_array($get_rel_dep_val);
				$id_dep_id = $array_dep['id_dep'];
				$dep_val = $array_dep['value'];
				$coin_dep = $array_dep['coin'];

				$get_dep = mysqli_query($con, "SELECT * FROM deposits WHERE id='$id_dep_id' AND id_user='$uid'");
				$array_plan = mysqli_fetch_array($get_dep);
			    $dep_plan = $array_plan['type_dep'];

				$row_withdep = mysqli_num_rows($get_rel_dep_val);
				$row_getdep = mysqli_num_rows($get_dep);
				
				$get_proto = mysqli_query($con, "SELECT * FROM net_protos WHERE id_dep = '$id_dep_id'");
				$array_net_proto = mysqli_fetch_array($get_proto);
				$id_dep_proto = $array_net_proto['net'];

				if($row_withdep >= 1 && $row_getdep >= 1 && $proto == $id_dep_proto && $coin_dep == $coin_with){

					$array_dep = mysqli_fetch_array($get_dep);
					
		 			include "with/confirm_with.php";
		 			
		 			//start comp value with -> deposit rest
		 			if($confirm_amount == "true"){
		 				
		 				//start
		 				$get_info_percent = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
			            $array_info = mysqli_fetch_array($get_info_percent);
			          
			            if($dep_plan == "Starter"){
			              $percent = $array_info['plan1'];
			            }else if($dep_plan == "Advanced"){
			              $percent = $array_info['plan2'];
			            }else if($dep_plan == "Premium"){
			              $percent = $array_info['plan3'];
			            }
		 				
		 				$max_profit_dep = (($percent * $dep_val) / 100) * 30; //total return -> profit total + dep amount

		 				$dec_value_rel_dep = $max_profit_dep - $amount_with; // total rest -> total return - total withdraw
		 				$dec_with_val = $dec_value_rel_dep - $valor; // check credit rest -> total withdraw rest - this value resquest 
						//end

		 				//start valid rest deposit with total withdraw request
		 				if($dec_with_val >= 0 && $dec_value_rel_dep >= 1){

		 					if($valor < 1){

					 			echo "<p class='text-danger'>Minimum withdrawal allowed is <b>$ 1</b>.</p>";
					 			exit();
					 		
					 		}else if($valor > $dep_val){

					 			echo "<p class='text-danger'>Oops, withdrawal amount is greater than the current deposit.</p>";

					 		}else{

						 		$total_v = $total['total_disp'];
						 		
					 			//add saque on db
					 			$insert_saque = mysqli_query($con, "INSERT INTO saque (quantidade,id_user,data,wallet,proto,qtd_dias,status,con_with) VALUES ('$valor','$uid','$data','$wallet','$proto','1','0','$id_with')");
					 			$att_amount = mysqli_query($con, "UPDATE usuarios SET total_disp=total_disp-'$valor' WHERE email='$email'");
					 			
					 			//start
								$title_not = base64_encode("Withdrawal created"); 
				 				$text_not = base64_encode("Withdrawal, amount $ ".$valor." created successfully, check your withdrawal list for +info.");
								$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");
								//end

								echo "<p class='text-light'>Withdraw created successfully, value of <a href='#saque' class='text-primary'>".$valor."</a> <i class='fa fa-check-square' aria-hidden='true'></i></p>";

								//start
								$subject = "withdraw";
							    include "email/emails_send.php";
								//end

						 	}
							//end valid rest deposit with total withdrawal request

						}else{

							echo "<p class='text-danger'>Withdrawal invalid</p>";
						}
						//end comp value with -> deposit rest
						
				 	}else{

				 		//start first with -> deposit
				 		$randar = array();
				 		$rand_num = "";
				
				 		$array_alfa = array(0 => "a", 1 => "b", 2 => "c", 3 => "d", 4 => "e", 5 => "f", 6 => "g", 7 => "h", 8 => "i", 9 => "j", 10 => "k", 11 => "l", 12 => "n", 13 => "m", 14 => "o", 15 => "p", 16 => "q", 17 => "r", 18 => "s", 19 => "t", 20 => "u", 21 => "v", 22 => "w", 23 => "x", 24 => "y", 25 => "z");

				 		$valid_num = false;
				 		$count = 0;

	 					if($valor < 1){

				 			echo "<p class='text-danger'>Minimum withdrawal allowed is <b>$ 1</b>.</p>";
				 			exit();
				 		
				 		}else if($valor > $dep_val){

				 			echo "<p class='text-danger'>Oops, withdrawal amount is greater than the current deposit.</p>";

				 		}else{

					 		while($valid_num == false && $request_with == "valid"){

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
					 			$comp_dep = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE id_charnum = '$rand_str'");

					 			if($comp_dep = mysqli_affected_rows($con) < 1){ //valid num -> not found in db
					 			
					 				$valid_num = true;

					 			}else{
					 			
					 				$count = 0;
					 			}

					 			//
					 			if($valid_num == true){

						 			$insert_saque = mysqli_query($con, "INSERT INTO saque (quantidade,id_user,data,wallet,proto,qtd_dias,status,con_with) VALUES ('$valor','$uid','$data','$wallet','$proto','1','0','$rand_str')");
										
						 			$get_with_id = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$uid' ORDER BY id DESC LIMIT 1");
						 			$get_last_with = mysqli_fetch_array($get_with_id);
						 			$id_last_with = $get_last_with['id'];
						 			$status = "0";
						 			//echo $coin_with." ".$id_dep_id." ".$valor;
						 			$insert_rel_dep = mysqli_query($con, "INSERT INTO rel_withdraw (id_with,id_charnum,qtd,coin,data,dep_con,type_out) VALUES ('$id_last_with','$rand_str','$valor','$coin_with','$data','$id_dep_id','$type_out')");
						 			//

						 			//
						 		    $title_not = base64_encode("Withdraw request");
						 		    $href = '#';
						 		    if($type_out == "dep"){
						 		    	$type_out_not = "rakeback";
						 		    }else{
						 		    	$type_out_not = "loterry";
						 		    }

						 			$text_not = base64_encode("Withdraw ".$type_out_not.", ".$rand_str." amount $ ".$valor." ".$coin_with." created successfully, check your withdraw list for +info.");
									
									$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");
								
									$att_amount = mysqli_query($con, "UPDATE usuarios SET total_disp=total_disp-'$valor' WHERE email='$email'");
								 	echo "<p class='text-light'>Withdraw created successfully, value of <a href='#saque' class='text-primary'> $ ".$valor."</a> <i class='fa fa-check-square' aria-hidden='true'></i></p>";
									//
							 		
						 			$subject = "withdraw";
							    	include "email/emails_send.php";
						    	}
					 		}
					 	}
				 		//end first with -> deposit
				 		//echo "new rel with";
				 	}
			
				}else{

					if($row_withdep < 1 && $row_getdep < 1){
						echo "<p class='text-danger'>Deposit number and user id error, try again</p>";
					}else if($row_withdep < 1){
						echo "<p class='text-danger'>Deposit number error, try again</p>";
					}else if($row_getdep < 1){
						echo "<p class='text-danger'>User id error, try again</p>";
					}if($coin_with != $coin_dep){
						echo "<p class='text-danger'>Currency invalid for withdrawal, error try again</p>";
					}else{
						echo "<p class='text-danger'>Withdraw protocol error, try again</p>";
					}
					if($request_with == "invalid"){
						echo "<p class='text-danger'>Withdraw amount invalid, try again</p>";
					}
				}
			 	
			}else{
				echo "Error, try again";
			}
		}

	}else{
		echo "<p class='text-danger'>Error, try again</p>";
	}

}else{

	echo "<p class='text-danger'>Error, try again</p>";
	//exit();	

 }

?>