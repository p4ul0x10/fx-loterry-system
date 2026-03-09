<?php 
	//ini_set( 'display_errors', 0);

	include ('conn.php');

	$fname=utf8_decode($_POST['fname']);
	$lname=utf8_decode($_POST['lname']);
	$email=$_POST['email'];
	$senha=utf8_decode($_POST['senha']);
	//$cpf=$_POST['cpf'];
    $data = date("m/j/Y g:i a"); //date("d/m/Y");
    $sponsor = $_POST['sponsor'];
    $subject = $_POST['subject'];

	if (strlen($senha) < 4) {
		echo "<p class='alert-danger'>Your password must be at least 4 digits long...</p>";
		exit();
	}else{
		$pw = md5($senha);
	}

	if ($subject != "created_acc") {
		echo "<p class='alert-danger'>Erro, try again...</p>";
		exit();
	}
	
	$check_acc = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email' or f_nome='$fname'");

	if($r=mysqli_affected_rows($con) >= 1){
		while ($remail = mysqli_fetch_array($check_acc)) {
			if ($remail['email']==$email) {
				echo "<p class='alert-danger'>Ops, this email has already been registered...</p>";
				exit();
			}
			if ($remail['f_nome']==$fname) {
				echo "<p class='alert-danger'>Ops, User name unavailable...</p>";
				exit();
			}
		}
		
	}else{

		$cpf = "cpf teste";	
		if(strlen($sponsor) >= 2){

			$sponsor_id =  mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$sponsor'");
			if($r_sponsor = mysqli_affected_rows($con) >= 1){

				$ar_sponsor = mysqli_fetch_array($sponsor_id);
				
				$email_sponsor = $ar_sponsor['email'];
				$id_sponsor = $ar_sponsor['id'];
				$fnamesp = $ar_sponsor['f_nome'];

				$title_not = base64_encode("New referral added");
				$text_not = base64_encode("You received a new referral user (".$fname.") in ".$data.", wait for activation...");

				$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email_sponsor','$title_not','$text_not','$data')");
			

				$criando_acc = mysqli_query($con, "INSERT INTO usuarios (f_nome,l_nome,email,senha,pw,cpf,data,sponsor) VALUES ('$fname','$lname','$email','$pw','$senha','$cpf','$data','$sponsor')");

				if ($rcria = mysqli_affected_rows($con) >= 1) {
					
					//start add new account ++
					$user_id =  mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");
				
					if($ruser = mysqli_affected_rows($con) >= 1){

						while($query_user = mysqli_fetch_array($user_id)){
							$id_user = $query_user['id'];
						}

						$add_config = mysqli_query($con, "INSERT INTO user_config (id_user,conf_theme,main_coin) VALUES ('$id_user','default','usdt')");
					}

					$title_not = base64_encode("Account created");
					$text_not = base64_encode("Welcome, ".$fname." your account has been created successfully, don't hesitate to contact support for any questions or suggestions.");

					$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$email','$title_not','$text_not','$data')");
					//end add new account ++

					//start re-check network list
					$check_sponsor = mysqli_query($con, "SELECT * FROM network_list WHERE leader_id = '$id_sponsor'");
				
					if($rc = mysqli_num_rows($check_sponsor) >= 1){

						//start delete network list
						mysqli_query($con, "DELETE FROM network_list WHERE leader_id = '$id_sponsor'");
						//end delete network list

						//start add new network list
						$count3 = 0;
						$count2 = 0;
						$count1 = 0;

						$array_network_id = 		array();
						$array_network_name = 		array();
						$array_network_level = 		array();
						$array_network_started = 	array();
						$array_network_leader = 	array();
						$array_network_level  = 	array();
						$array_network_status = 	array();
						$array_network_earns  =		array();
						$array_network_activity = 	array();

						$array_network_id2 = 			array();
						$array_network_name2 = 			array();
						$array_network_level2 = 		array();
						$array_network_started2 = 		array();
						$array_network_leader2 = 		array();
						$array_network_level2  = 		array();
						$array_network_status2 = 		array();
						$array_network_earns2  =		array();
						$array_network_activity2 = 		array();

						$array_network_id1 = 			array();
						$array_network_name1 = 			array();
						$array_network_level1 = 		array();
						$array_network_started1 = 		array();
						$array_network_leader1 = 		array();
						$array_network_level1  = 		array();
						$array_network_status1 = 		array();
						$array_network_earns1  =		array();
						$array_network_activity1 = 		array();

						$get_info = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email_sponsor'");            	
						if($rows_info = mysqli_affected_rows($con) >= 1){

							while ($ref_info = mysqli_fetch_array($get_info)) {
								
								$sponsor_main = $ref_info['f_nome'];
								$get_sponsor1 = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$sponsor_main' ORDER BY id DESC");
								
								if($rows_info3 = mysqli_affected_rows($con) >= 1){

									while($rows_info = mysqli_fetch_array($get_sponsor1)){
										
										$id3 = $rows_info['id'];
										$get_true_deposit = mysqli_query($con, "SELECT * FROM deposits WHERE status = '1' AND id_user = '$id3'");
										$deps3 = mysqli_affected_rows($con);

										if($deps3 >= 1){
										
											$get_sum = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE status = '1' AND id_user = '$id3'");
											$earns3 = 0;
											while ($get_dep3_bonus= mysqli_fetch_array($get_sum)) {
												
												$calc3 = ($get_dep3_bonus['quantidade'] / 100) * 3;
												$earns3 = $earns3 + number_format($calc3, 2, ".", "");
											}

											$status3 = "active";
											if($earns3 < "0.00000001"){
												//echo "0.00";
											}

										}else{

											$status3 = "pending";
											$earns3 = "0.00";
										}

										
										$str_data = strchr($rows_info['data']," ", true);
										
										$sponsor_main3 = $rows_info['f_nome'];

										$array_network_id[$count3] = $id_sponsor; 
										$array_network_name[$count3] = $sponsor_main3;
										$array_network_level[$count3] = 3;
										$array_network_started[$count3] = $str_data;
										$array_network_leader[$count3] = $sponsor_main;
										$array_network_status[$count3] = $status3;
										$array_network_earns[$count3] = $earns3;
										$array_network_activity[$count3] = $deps3;
										$count3++;
						
									}

					      		}
					      			
					      		$count22 = 0;
					      		while($count2 < $count3){

					          		$sponsor_main = $array_network_name[$count2];
									$get_sponsor1 = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$sponsor_main' ORDER BY id DESC");
									if($rows_info2 = mysqli_affected_rows($con) >= 1){

										while($rows_info = mysqli_fetch_array($get_sponsor1)){
											
											$id2 = $rows_info['id'];
											$get_true_deposit = mysqli_query($con, "SELECT * FROM deposits WHERE status = '1' AND id_user = '$id2'");
											$deps2 = mysqli_affected_rows($con);

											if($deps2 >= 1){
											
												$get_sum = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE status = '1' AND id_user = '$id2'");
												$earns2 = 0;
												while ($get_dep2_bonus= mysqli_fetch_array($get_sum)) {
													
													$calc2 = ($get_dep2_bonus['quantidade'] / 100) * 2;
													$earns2 = $earns2 + number_format($calc2, 2, ".", "");
												}

												$status2 = "active";
												if($earns2 < "0.00000001"){
													//echo "0.00";
												}

											}else{

												$status2 = "pending";
												$earns2 = "0.00";
											}
											
											$str_data = strchr($rows_info['data']," ", true);
											
											$sponsor_main2 = $rows_info['f_nome'];

											$array_network_id2[$count22] = $id_sponsor; 
											$array_network_name2[$count22] = $sponsor_main2;
											$array_network_level2[$count22] = 2;
											$array_network_started2[$count22] = $str_data;
											$array_network_leader2[$count22] = $rows_info['sponsor'];
											$array_network_status2[$count22] = $status2;
											$array_network_earns2[$count22] = $earns2;
											$array_network_activity2[$count22] = $deps2;
											$count22++;
										}

					          		}

									$count2++;
					      		}

					      		$count11 = 0;
					      		while($count1 < $count22){

					          		$sponsor_main = $array_network_name2[$count1];
									$get_sponsor1 = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$sponsor_main' ORDER BY id ASC");
									
									if($rows_info1 = mysqli_affected_rows($con) >= 1){

										while($rows_info = mysqli_fetch_array($get_sponsor1)){
											
											$id1 = $rows_info['id'];
											$get_true_deposit = mysqli_query($con, "SELECT * FROM deposits WHERE status = '1' AND id_user = '$id1'");
											$deps1 = mysqli_affected_rows($con);

											if($deps1 >= 1){
											
												$get_sum = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE status = '1' AND id_user = '$id1'");
												$earns1 = 0;
												while ($get_dep1_bonus= mysqli_fetch_array($get_sum)) {
													
													$calc1 = ($get_dep1_bonus['quantidade'] / 100) * 1;
													$earns1 = $earns1 + number_format($calc1, 2, ".", "");
												}

												$status1 = "active";
												if($earns1 < "0.00000001"){
													//echo "0.00";
												}

											}else{

												$status1 = "pending";
												$earns1 = "0.00";
											}
											
											
											$str_data = strchr($rows_info['data']," ", true);
											
											$sponsor_main = $rows_info['f_nome'];
											$array_network_id1[$count11] = $id_sponsor; 
											$array_network_name1[$count11] = $sponsor_main;
											$array_network_level1[$count11] = 1;
											$array_network_started1[$count11] = $str_data;
											$array_network_leader1[$count11] = $array_network_name2[$count1];
											$array_network_status1[$count11] = $status1;
											$array_network_earns1[$count11] = $earns1;
											$array_network_activity1[$count11] = $deps1;
									
											$count11++;
										}

					          		}
					      		
					          		$count1++;
					      		}
					    	}

					    	$return = 0;
					    	$returnn = 0;
					    	$returnnn = 0;
					    	$id_count = 1;

					    	while ($return < $count3) {
					       		
					    		$network_id3 = $array_network_id[$return];
					    		$network_nome3 = $array_network_name[$return];
					    		$network_level3 = $array_network_level[$return];
					    		$network_started3 = $array_network_started[$return];
					    		$network_leader3 = $array_network_leader[$return];
					    		$network_status3 = $array_network_status[$return];
					    		$network_earns3 = $array_network_earns[$return];
					    		$network_activity3 = $array_network_activity[$return];

					       		$insert_l3 = mysqli_query($con, "INSERT INTO network_list (leader_id,nome_ref,level_ref,started_ref,leader_ref,status_ref,earns_ref,activity_ref) VALUES ('$network_id3','$network_nome3','$network_level3','$network_started3','$network_leader3','$network_status3','$network_earns3','$network_activity3')");

					            while($returnn < $count22){
					           	
					            	if($array_network_leader2[$returnn] == $array_network_name[$return]){
					            	
					      				$network_id2 = $array_network_id2[$returnn];
							    		$network_nome2 = $array_network_name2[$returnn];
							    		$network_level2 = $array_network_level2[$returnn];
							    		$network_started2 = $array_network_started2[$returnn];
							    		$network_leader2 = $array_network_leader2[$returnn];
							    		$network_status2 = $array_network_status2[$returnn];
							    		$network_earns2 = $array_network_earns2[$returnn];
							    		$network_activity2 = $array_network_activity2[$returnn];

							       		$insert_l2 = mysqli_query($con, "INSERT INTO network_list (leader_id,nome_ref,level_ref,started_ref,leader_ref,status_ref,earns_ref,activity_ref) VALUES ('$network_id2','$network_nome2','$network_level2','$network_started2','$network_leader2','$network_status2','$network_earns2','$network_activity2')");

						            	while($returnnn < $count11){
						            	
						            		if($array_network_leader1[$returnnn] == $array_network_name2[$returnn]){
						            		
						            			$network_id1 = $array_network_id1[$returnnn];
									    		$network_nome1 = $array_network_name1[$returnnn];
									    		$network_level1 = $array_network_level1[$returnnn];
									    		$network_started1 = $array_network_started1[$returnnn];
									    		$network_leader1 = $array_network_leader1[$returnnn];
									    		$network_status1 = $array_network_status1[$returnnn];
									    		$network_earns1 = $array_network_earns1[$returnnn];
									    		$network_activity1 = $array_network_activity1[$return];

									       		$insert_l1 = mysqli_query($con, "INSERT INTO network_list (leader_id,nome_ref,level_ref,started_ref,leader_ref,status_ref,earns_ref,activity_ref) VALUES ('$network_id1','$network_nome1','$network_level1','$network_started1','$network_leader1','$network_status1','$network_earns1','$network_activity1')");
						        
									       	 	$id_count++;

						            		}
					        	
					            			$returnnn++;
					        			}
	
							       	 	$id_count++;
	
					       			}

					        		$returnn++;
					        	}

					       		$returnnn = 0;
					        	$returnn = 0;
					        	$return++;
					       	 	$id_count++;
					    	
					    	}
							
							$update_cont = mysqli_query($con, "UPDATE usuarios SET total_ref=$id_count WHERE email ='$user'");
							
						}
						//end add new network list

						$insert_last_ref = mysqli_query($con, "INSERT INTO network_list (leader_id,nome_ref,level_ref,started_ref,status_ref,earns_ref,activity_ref) VALUES ('$id_sponsor','$fname','3','$data','$sponsor','Pending','0.00','0')");

					}else{
						
						$insert_first_ref = mysqli_query($con, "INSERT INTO network_list (leader_id,nome_ref,level_ref,started_ref,leader_ref,status_ref,earns_ref,activity_ref) VALUES ('$id_sponsor','$fname','3','$data','$sponsor','Pending','0.00','0')");
					
					}
					//end re-check network list

					//start print success ++
 					echo "<p class='alert-success'>Account created successfully !</p>";
					include "email/emails_send.php";
					//end print success ++

				}else{

					echo "<p class='alert-danger'>Ops, An error has occurred...</p>";
				}

			}else{
				
				echo "<p class='alert-danger'>Sponsor not found.</p>";
			}
			
		}else{

			echo "<p class='alert-danger'>Erro inesperado com sponsor</p>";
		}
	}

?>