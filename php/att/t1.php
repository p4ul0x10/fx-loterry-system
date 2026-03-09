<?php 

$host =$_SERVER['REQUEST_METHOD'];

if($host == "GET"){
	exit();
}
	
include_once "../conn.php";

session_start();

$email = $_SESSION['email'];
$get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
$array_user = mysqli_fetch_array($get_user);

$id_user = $array_user['id'];

//
$tacc = $_POST['tacc'];
$taccp = $_POST['taccp'];
$tprofit = $_POST['tprofit'];
$tacca = $_POST['tacca'];
$taccap = $_POST['taccap'];
//

//
$str_len = 0;
$var = "";
$var_now = 0;
$count_str = 0;
$count_aux = 0;

while ($count_uni_var < 5) {
	
	if($var_now == 0){
		$str_uni = strlen($tacc);
		$str = $tacc;
	} 
	
	if($var_now == 1){
		$str_uni = strlen($taccp);		
		$str = $taccp;
	} 
	
	if($var_now == 2){
		$str_uni = strlen($tprofit);
		$str = $tprofit;
	} 
	
	if($var_now == 3){
		$str_uni = strlen($tacca);
		$str = $tacca;
	} 
	
	if($var_now == 4){
		$str_uni = strlen($taccap);
		$str = $taccap;
	} 

	$replace_str_pos = str_split($str);
	
	while ($count_str < $str_uni) {
	
		if($replace_str_pos[$count_str] != " "){
			
			$var = $var."".$replace_str_pos[$count_str];
		
		}
		
		if($replace_str_pos[$count_str+1] == "p"){
		
			break;

		}

		if($count_str != 0 && $replace_str_pos[$count_str+1] == " " && $replace_str_pos[$count_str+2] != " "){
			
			$check_count = $count_str + 1;

			if($check_count >= $str_uni){
				
				$var = $var." ";
		
			}

		}

		$count_str++;

	}

	if($var_now == 0){
		$tacc = $var;
	} 

	if($var_now == 1){
		$taccp = $var." pending";		
	} 

	if($var_now == 2){
		$tprofit = $var;
	} 

	if($var_now == 3){
		$tacca = $var;
	} 

	if($var_now == 4){
		$taccap = $var." pending";
	} 

	$count_str = 0;
	$count_uni_var++;
	$var_now = $count_uni_var;
	$var = "";

}
// 
//echo $tacca; exit();
//
if(strlen($tacc) > 20 || strlen($accp) > 20 || strlen($tprofit) > 20 || strlen($tacca) > 20 || strlen($taccap) > 20){ //invalid arguments
	exit();
}
//

//
$get_tacc = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE id_user ='$id_user' AND status = '1'");

if($r_taccp = mysqli_affected_rows($con) >= 1){ //for tacc

	$ar_taccp = mysqli_fetch_array($get_tacc);
	$qtd0 = number_format($ar_taccp['quantidade'], 2, ".", "");

}

$get_taccp = mysqli_query($con, "SELECT sum(quantidade) AS qtdd FROM deposits WHERE id_user = '$id_user' AND status != '1'");

if($r_taccp = mysqli_affected_rows($con) >= 1){ //for tacc deposited

	$ar_taccp = mysqli_fetch_array($get_taccp);
	$qtd1 = number_format($ar_taccp['qtdd'], 2, ".", "");
	$qtddd = "$".$qtd1." pending";

}	

$pass_true = "false"; // for not re-check
$df_total_acc = $tacc - $qtd0;

if($tacc != $qtd0){ //total acc -> valid
	$data_acc = $qtd0;
}else{
	$data_acc = 0;
}

if($qtddd != $taccp){ //total acc pending -> valid
	$data_accp = $qtddd;
}else{
	$data_accp = 0;
}
//

//
$get_tacca = mysqli_query($con, "SELECT sum(total_acc) AS total_acc FROM usuarios WHERE email = '$email'");

if($r_tacca = mysqli_num_rows($get_tacca) >= 1){ //for total acc amount

	$ar_tacca = mysqli_fetch_array($get_tacca);
	$qtd_acc = number_format($ar_tacca['total_acc'], 2, ".", "");
		
	if($tacca != $qtd_acc){ //re-check total amount
		$data_tacca = $qtd_acc;
	}else{
		$data_tacca = 0;	
	}

}

$get_dep_unconfirmed = mysqli_query($con, "SELECT sum(quantidade) AS qtd FROM saque WHERE id_user = '$id_user' AND status != 1");
$array_dep = mysqli_fetch_array($get_dep_unconfirmed);

$get_ltwin_unconfirmed = mysqli_query($con, "SELECT sum(total_earn) AS earn FROM loterry_winners WHERE id_user = '$id_user' AND status != '1'");
$array_win_lt = mysqli_fetch_array($get_ltwin_unconfirmed);

$total_unconfirmed = number_format($array_dep['qtd'], 2, ".", "") + number_format($array_win_lt['earn'], 2, ".", "");
$total_acc_unconfirmed = "$".$total_unconfirmed." pending";


$count_check = 0;
$ar_num = array(0 => "0", 1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6", 7 => "7", 8 => "8", 9 => "9");

while($count_check == 0){

	$str_0 = str_split($taccap);
	$str_1 = str_split($total_acc_unconfirmed);
	
	$str_len0 = strlen($taccap);
	$str_len1 = strlen($total_acc_unconfirmed);

	$cn = 0;
	$n_aux = 0;
	$t1 = "";
	$t2 = "";

	while($cn < 2){	
		
		if($cn == 0){
			$str_l = $str_len0;
		}else{
			$str_l = $str_len1;
		}	

		if($cn == 0){

			if($str_0[$n_aux] == $ar_num[0] || $str_0[$n_aux] == $ar_num[1] || $str_0[$n_aux] == $ar_num[2] || $str_0[$n_aux] == $ar_num[3] || $str_0[$n_aux] == $ar_num[4] || $str_0[$n_aux] == $ar_num[5] || $str_0[$n_aux] == $ar_num[6] || $str_0[$n_aux] == $ar_num[7] || $str_0[$n_aux] == $ar_num[8] || $str_0[$n_aux] == $ar_num[9]){
			
				$t1 = $t1."".$str_0[$n_aux];
			
			}
		
		}

		if($cn == 1){
		
			if($str_1[$n_aux] == $ar_num[0] || $str_1[$n_aux] == $ar_num[1] || $str_1[$n_aux] == $ar_num[2] || $str_1[$n_aux] == $ar_num[3] || $str_1[$n_aux] == $ar_num[4] || $str_1[$n_aux] == $ar_num[5] || $str_1[$n_aux] == $ar_num[6] || $str_1[$n_aux] == $ar_num[7] || $str_1[$n_aux] == $ar_num[8] || $str_1[$n_aux] == $ar_num[9]){
			
				$t2 = $t2."".$str_1[$n_aux];
			
			}
		
		}

		if($n_aux > $str_l){
		
			$cn++;
			$n_aux = 0;

		}else{

			$n_aux++;
	
		}
	
	}
	
	$count_check++;

}

if($t1 == $t2){
	$data_taccap = 0;
}

if(!isset($data_taccap)){
	$data_taccap = $total_acc_unconfirmed;
}
//

//
$total_depositado1 = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");

if($r = mysqli_affected_rows($con) >= 1) {
	
	$total1 = mysqli_fetch_array($total_depositado1);
	$total_earn = number_format($total1['total_amount'], 2, ".", ""); //total gerado
	
	if($total_earn != $tprofit){
		$data_profit = $total_earn;
	}else{
		$data_profit = 0;
	}

}
//

//echo $data_acc." ".$data_accp." ".$data_tacca." ".$data_taccap." ".$data_profit;

//start parse info
$ar_return = array(0 => $data_acc, 1 => $data_accp, 2 => $data_tacca, 3 => $data_taccap, 4 => $data_profit);
$json = json_encode($ar_return);
echo $json;
//end
?>