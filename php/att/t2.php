<?php

//
$host = $_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}
	
include "../conn.php";

session_start();

$email = $_SESSION['email'];
$get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
$array_user = mysqli_fetch_array($get_user);

$id_user = $array_user['id'];

$tp = $_POST['tp'];
$te = $_POST['te'];
$tt = $_POST['tt'];
$tmw = $_POST['tmw'];
$tr = $_POST['tr'];
$ltd = $_POST['ltd'];

if(strlen($tp) > 16 || strlen($te) > 16 || strlen($tt) > 16 || strlen($tmw) > 16 || strlen($tr) > 16 || strlen($ltd) > 16){

	exit();

}
//

//start find info's current lt
$t_entrys = 0;
$t_tickets = 0; 

$ar_users_lt = array();
$ci = 0;

$get_info_lt = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id > 0");

while($info_lt = mysqli_fetch_array($get_info_lt)){

	$t_entrys++;
	$t_tickets = $t_tickets + $info_lt['value'];
	$ar_users_lt[$ci] = $info_lt['id_user'];
	$ci++;

}

if($t_entrys != $te){
	$data_te = $t_entrys;
}else{
	$data_te = 0;
}

if($t_tickets != $tt){
	$data_tt = $t_tickets;
}else{
	$data_tt = 0;
}
//end

//start check valid num of the participants
$t_users_lt = 0;
$cii = $ci - 1;

$count_tp = mysqli_num_rows($get_info_lt);

for ($i = 0; $i < $ci; $i++) { 

	for ($ii = $cii; $ii >= 0; $ii--) { 
    
  		if($i != $ii && $ar_users_lt[$i] == $ar_users_lt[$ii] && $ar_users_lt[$i] != 0 && $ar_users_lt[$ii] != 0){
    	
    		$ar_users_lt[$ii] = 0;
  			$count_tp--;
  	
  		} 

	}

}

$t_users_lt = $count_tp;

if($t_users_lt != $tp){
	$data_tp = $t_users_lt;
}else{
	$data_tp = 0;
}
//end

//start max winners
$tt_participants = $t_users_lt % 2;

if($tt_participants == 0){
	$max_winners = $t_users_lt / 2;
}else{	
	$max_winners = ($t_users_lt - 1) / 2;
}

if($max_winners != $tmw){
	$data_tmw = $max_winners;
}else{
	$data_tmw = 0;
}
//end

//start max rewards 
$t_amount_lt = $t_tickets * 0.20;
$p_amount_lt = (80 * $t_amount_lt) / 100;
$max_rewards = $p_amount_lt;

if($max_rewards < $tr){
	$data_tr = $max_rewards;
}else{
	$data_tr = 0;
}
//end

//start lt details
if($ltd == 1){ //
	
	$get_info_lt = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id > 0");
	
	$all_num_entrys = mysqli_num_rows($get_info_lt);
	
	$total_tkt = 0;
	$num_entrys = 0;
	
	$all_tkt_num = 0;
	$all_entrys = 0;
	$c_ltd = 0;
	
	$array_lt_user_aux = array();
	$array_lt_user_tkt = array();

	while($ar_lt_tkt = mysqli_fetch_array($get_info_lt)){

		if($ar_lt_tkt['id_user'] == $id_user){

			$total_tkt += $ar_lt_tkt['value'];
			$num_entrys += 1;
		
		}else{

			$all_tkt_num += $ar_lt_tkt['value'];
			$all_entrys += 1;
		
		}
		
		$array_lt_user_aux[$c_ltd] = $ar_lt_tkt['id_user'];
		$array_lt_user_tkt[$c_ltd] = $ar_lt_tkt['value'];

		$c_ltd++;
		$count_checked1 = $c_ltd;

	}

	//start get valid nums (no-repeated)
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

	$array_tkt_vt = array();
	
	$tkt_v = 0;
	$count_vt = 0;

	for ($i=0; $i < $count_lt_users; $i++) { 
		
		for ($ii=0; $ii < $count_checked1; $ii++) { 
			
			if($array_lt_user[$i] == $array_lt_user_aux[$ii]){
		
				$tkt_v += $array_lt_user_tkt[$ii];
			
			}

		}

		$array_tkt_vt[$count_vt] = $tkt_v;

		$tkt_v = 0;
		$count_vt++;

	}

	$v1 = $array_tkt_vt[0];

	for ($ii=0; $ii < $count_lt_users; $ii++) { 
		
		if(isset($nm) && $nm < $array_tkt_vt[$i]){
			
			$nm = $array_tkt_vt[$i];
		
		}else if(!isset($nm) && $v1 <= $array_tkt_vt[$i]){

			$nm = $array_tkt_vt[$i];
		
		}else if(!isset($nm) && $v1 > $array_tkt_vt[$i]){

			$nm = $v1;

		}
	
	}

	$max_tkt_amount = $nm;
	$array_lt_p = array();

	for ($i=0; $i < $count_lt_users; $i++) { 
	
		$porcent = ($array_tkt_vt[$i] / $max_tkt_amount) * 100;
		
		if($porcent != 100){

			$df_porcent = 100 - $porcent;
		
		}else{

			$df_porcent = 100;
		}

		$array_lt_p[$i] = $df_porcent;

	}	

	$v1 = $array_lt_p[0];

	for ($i=0; $i < $count_lt_users; $i++) { 
		
		if(isset($nmf) && $nmf < $array_lt_p[$i]){
			
			$nmf = $array_lt_p[$i];
		
		}else if(!isset($nmf) && $v1 <= $array_lt_p[$i]){

			$nmf = $array_lt_p[$i];
		
		}else if(!isset($nmf) && $v1 > $array_lt_p[$i]){

			$nmf = $v1;

		}

	}

	$win_marge = $nmf;

	$data_marge = $win_marge;
	$data_entrys = $num_entrys;
	$data_ttkt = $total_tkt;

	$data_all_entrys = $all_entrys;
	$data_all_tkt = $all_tkt_num;

	$add0 = '<span class="text-lt color-theme">Total entrys: <a href="#" class="text-muted t-entrys-u">'.$data_entrys.'</a> <img src="open-iconic-master/png/pie-chart-3x.png" width="20" height="20"></span>';

	$add1 = '<span class="text-lt color-theme">Chance win: <a href="#" class="text-muted t-marge">'.$data_marge.'</a> %</span>';

	$data_lt = $add0."".$add1;
	//end

}else{
	
	$data_lt = 0;

}
//end

//echo $data_tp." ".$data_te." ".$data_tt." ".$data_tmw." ".$data_tr." ".$data_lt;

//start parse info 
$ar_return = array(0 => $data_tp, 1 => $data_te, 2 => $data_tt, 3 => $data_tmw, 4 => $data_tr, 5 => $data_lt);
$json = json_encode($ar_return);

echo $json;
//end

?>