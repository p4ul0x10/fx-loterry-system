<?php

include '../conn.php';

$server_lt_session = 0;
$server_lt_time_rest = 0;
$server_lt_session_last_v = 0;

$query_server = mysqli_query($con, "SELECT * FROM info WHERE id = 1");
$array_server = mysqli_fetch_array($query_server);

$server_lt_session = $array_server['lt_session'];
$server_lt_session_last_v = $server_lt_session - 1;

if($server_lt_session >= 1){ //gen win list

	$query_lt_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id > 0 ORDER BY id DESC LIMIT 1");
	$array_lt_winners = mysqli_fetch_array($query_lt_winners);

	$last_lt_session = $array_lt_winners['session_id'];

	if($last_lt_session == $server_lt_session_last_v){

		$query_tkt_buyed = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE current_session = '$server_lt_session_last_v'");
		
		$count_checked1 = 0;
		$count_checked2 = 0;
		$count_checked3 = 0;
		$pos_numeric = 0;

		while ($ar_tkt_id_user = mysqli_fetch_array($query_tkt_buyed)) {
			
			$array_lt_user_aux = array($count_checked1 => $ar_tkt_id_user['id_user']);
			$count_checked1++;

		}
	
		for($i = 0; $i < $count_checked1; $i++){ 
			
			$num_i = $array_lt_user_aux[$i];

			for($ii = 0; $ii < $count_checked1; $ii++){ 
			
				$num_ii = $array_lt_user_aux[$ii];
				
				if($array_lt_user_aux[$i] != 0){
					
					if($i != $ii && $num_i == $num_ii){

						$array_lt_user_aux[$ii] = 0;
					
					}
				
				}
			
			}

		}

		$count_lt_users = 0;
		$array_lt_user = array();

		for($i_aux = 0; $i_aux < $count_checked1; $i_aux++){

			if($array_lt_user_aux[$i_aux] != 0){
		
				$array_lt_user[$count_lt_users] = $array_lt_user_aux[$i_aux];
				$count_lt_users++;
		
			}

		}

		while ($array_tkt_buyed = mysqli_fetch_array($query_tkt_buyed)) {
			
			$pos_numeric = $pos_numeric + $array_tkt_buyed['value'];
			
			$array_lt_user_value = array($count_checked2 => $pos_numeric);
			$array_lt_user_rel_dep = array($count_checked3 => $array_tkt_buyed['rel_package']);
		
			$count_checked2++;
			$count_checked3++;

		}

		$users_div = $count_lt_users / 2;
		$users_div_ajust = round($users_div);
		$pos_winner = 1;

		$ar_winners = array(); 
		$ar_winid = array();
		$ar_winrange = array();
		$ar_winpos = array();

		$cw = 0;

		while ($cw != $users_div_ajust) { 
			
			$max_num = rand(0, $pos_numeric);
			
			if($pos_winner == 1){ //first added (order asc -> amount)

			    $num_valid = 0;
				
				for ($cwv = 0; $cwv < $count_checked2; $cwv++) { 
					
					if($cwv == 0){

						//start
						for ($cn = 0; $cn < $count_checked2; $cn++) { 
							
							if($max_num > $array_lt_user_value[$cn] && $pos_numeric == 1){
						
								$num_valid = $array_lt_user_value[$cn];
						
							}
						
						}
						//end

						//start
						if($pos_winner == 1 && $max_num > $num_valid && $max_num <= $array_lt_user_value[$cwv]){

							$ar_winners[$cw] = $cwv;
							
							$ar_winpos[$cw] = $pos_winner;
							$ar_winid[$cw] = $array_lt_user[$cwv];
							$ar_winrange[$cw] = $array_lt_user_value[$cwv]; 

							$cw++;
							$pos_winner++;
						
						}
						//end
					}
			
				}

			}else{ //olds added

				$valid_count = true;

				for ($cwv = 0; $cwv < $count_checked2; $cwv++) { 
					
					if($cwv > 0){

						if($max_num > $array_lt_user_value[$cwv-1] && $max_num <= $array_lt_user_value[$cwv]){

							//start
							for ($cwc = 0; $cwc <= $cw; $cwc++) { 
								
								if($ar_winners[$cwc] == $cwc){
									$valid_count = false;
								}
							}
							//end

							//start
							if($pos_winner < 3 && $ar_winid[$cw-1] == $array_lt_user[$cwv] && $cw > 0){
								$pos_wc = false;
							}else if($pos_winner < 3 && $cw == 0){
								$pos_wc = true;
							}else if($pos_winner > 2){
								$pos_wc = true;
							}
							//end
							
							//start
							if($valid_count == true && $pos_wc == true){

								$ar_winners[$cw] = $cwv;
								
								$ar_winpos[$cw] = $pos_winner;
								$ar_winid[$cw] = $array_lt_user[$cwv-1];
								$ar_winrange[$cw] = $array_lt_user_value[$cwv-1]; 
								
								$cw++;
								$pos_winner++;
							
							}
							//end
						}

					}else if($cwv == 0){

						if($max_num <= $array_lt_user_value[$cwv]){

							//start
							for ($cwc = 0; $cwc <= $cw; $cwc++) { 
								
								if($ar_winners[$cwc] == $cwc){
									$valid_count = false;
								}
							
							}
							//end

							//start
							if($valid_count == true){

								$ar_winners[$cw] = $cwv;
							
								$ar_winpos[$cw] = $pos_winner;
								$ar_winid[$cw] = $array_lt_user[$cwv];
								$ar_winrange[$cw] = $array_lt_user_value[$cwv]; 
								
								$cw++;
								$pos_winner++;
						
							}
							//end
						}
                            
					}

					$valid_count = true;	
			
				}
			
			}

			if($cw == $users_div_ajust){
				
				break;
			
			}

		}

		//start 
		$query_amount_session = mysqli_query($con, "SELECT sum(value) AS value FROM loterry_tkt_buyed WHERE current_session = '$server_lt_session_last_v'");

		$array_sum_amount_session = mysqli_fetch_array($query_amount_session);
		$amount_tkt = $array_sum_amount_session['value'];
		
		$value_per_tkt = 0.20;
		$porcent_per_lt = 80;

		$amount_lt_session = ($porcent_per_lt * ($value_per_tkt * $amount_tkt)) / 100;

		$array_lt_value = array();

		for ($i = 0; $i < $users_div_ajust; $i++) { 
		
			if($i == 0){ //first win

				$value_first_win = (40 * ($value_per_tkt * $amount_lt_session)) / 100; //receive 40% -> rest 40%
				$value_rest = ($value_per_tkt * $amount_lt_session) - $value_first_win;
				
				$array_lt_value[0] = $value_first_win;
			
				$value_second_win = (20 * $value_rest) / 100; // rest value / max winners - 2 -> (2° win)
				$value_rest = $value_rest - $value_second_win;
				
				$array_lt_value[1] = $value_second_win;
				$amount_per_users = $value_rest / ($users_div_ajust - 2); // rest value / max winners - 1 -> (1° win)
				
			}else{

				$array_lt_value[$i] = $amount_per_users; //			

			}	
			
			$check_count = $users_div_ajust - $i;

			if($check_count <= 1){
				
				$amount_rest = 0;

				for($ii = 2; $ii < $users_div_ajust; $ii++){

					$value_per_user = $array_lt_value[$ii] / $ii; //desc rate win per user
					$array_lt_value[$ii] = $value_per_user;

					$amount_per_users -= $value_per_user;
				
				}

				if($amount_per_users > 0){

					$div_rest_value = $amount_per_users / ($users_div_ajust - 2);
					
					if($div_rest_value > 0.00000001){

						for ($e = 2; $e < $users_div_ajust; $e++) { 
							
							$array_lt_value[$e] = $array_lt_value[$e] + $div_rest_value;

						}
					
					}

				}

			}		
		
		}
		//end
	}	

	//start add loterry winners
	for($add = 0; $add < $users_div_ajust; $add++){

		$add_user = $ar_winid[$add];
		$add_pos = $ar_winpos[$add];
		$add_total_tickets = $array_lt_value;
		$add_rel_tickets = $array_lt_user_rel_dep[$add];
		
		//-----
		$ar_str = str_split($add_rel_tickets);
		$str_p = strpos($add_rel_tickets,"-");
		 			
		$c = 0;
		$id = array();

		while($c < $str_p){

			$id[$c] = $ar_str[$c];
    		$c++;

		}

		$id_im = implode("",$id);	
		
		$query_id_dep = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_dep = '$id_im'");
		$ar_id_user_win = mysqli_fetch_array($query_id_dep); 
		$id_user_win = $ar_id_user_win['id_user'];
		$query_id_nick = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_user_win'");
		$ar_nick_win = mysqli_fetch_array($query_id_nick);
		$add_nick = $ar_nick_win['f_nome'];
		//-----
	
		$add_earns = $array_lt_value[$add];
	
		$add_parcial = ($array_lt_value[$add] / (0.20 * $amount_tkt)) * 100;
		
		$add_data = date("m,j,Y g:i a"); //date("d/m/Y");
		$add_status = "1";
		$add_session_id = $server_lt_session_last_v;

		$query_insert_winners = mysqli_query($con, "INSERT INTO loterry_winners (id_user,pos,nick,total_ticket,rel_tickets,total_earn,parcial,data,status,session_id) VALUES ('$add_user','$add_pos','$add_nick','$add_total_tickets','$add_rel_tickets','$add_earns','$add_parcial','$add_data','$add_status','$add_session_id')");
	
	}
	//end add loterry winners

	//start check dep status
	/*$get_deps = mysqli_query($con, "SELECT * FROM rel_deposits WHERE status != '2' AND status != '1'");
	if($rows_dep = mysqli_affected_rows($con) >= 1){
		while ($array_deps = mysqli_fetch_array($get_deps)) {
			$id_charnum = $array_deps['id_charnum'];
			mysqli_query($con, "UPDATE rel_deposits SET status = '2' WHERE id_charnum='$id_charnum'");
		}
	}
	$get_tickets = mysqli_query($con, "UPDATE loterry_tkt_buyed SET status = '2' WHERE current_session <= '$server_lt_session_last_v'");*/
	//end check dep status
}

?>
