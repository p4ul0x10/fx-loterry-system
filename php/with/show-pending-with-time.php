<?php

function theme_user_id(){

	include "../conn.php";

	session_start();
	$email = $_SESSION['email'];

	$ar_u = array();
	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
	}

	$ar_u[0] = $id;
	$ar_u[1] = $con;

	$in = $ar_u;
	return $in;

}

$theme_user_id = theme_user_id();

$id_u = $theme_user_id[0];
$con = $theme_user_id[1];

$ar_return = array();
$i = 0;

$get_extrato_end = mysqli_query($con, "SELECT * FROM saque WHERE id_user='$id_u' AND status != '1' ORDER BY id DESC LIMIT 5");

while($list = mysqli_fetch_array($get_extrato_end)) {

	$time_left = $list['hms'];
	
	//start get time hours, min, seconds
	$hms = gmdate("H:i:s", $time_left);
	//$hms = add_hms($time_left);
	$ar_return[$i] = $hms;

	$i++;
	//end

}

$ar_return = array(0 => $ar_return[0], 1 => $ar_return[1], 2 => $ar_return[2], 3 => $ar_return[3], 4 => $ar_return[4], 5 => $ar_return[5]);

$json = json_encode($ar_return);
echo $json;
	
?>