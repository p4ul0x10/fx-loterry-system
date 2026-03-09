<?php

include "../conn.php";
$first_id = $_POST['first_id'];

$get_server_info  = mysqli_query($con, "SELECT * FROM info WHERE id = '1'");
$ar_server_info = mysqli_fetch_array($get_server_info);

$server_session = $ar_server_info['lt_session']; 
$get_last = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE current_session = '$server_session' ORDER BY id DESC LIMIT 1");
$ar_last = mysqli_fetch_array($get_last);
$first_db = $ar_last['rel_package'];

if($first_id == $first_db){ //att invalid
	$break = true;
}else{ // att valid
	$break = false;
}

if($break == false){

	$get_first = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE current_session = '$server_session' ORDER BY id ASC");
	$ar_session0 = array();
	$ar_session1 = array();
	$i = 0;

	while($ar_session_list = mysqli_fetch_array($get_first)){ 

		$ar_session0[$i] = $ar_session_list['value'];
		$ar_session1[$i] = $ar_session_list['rel_package'];	
		$i++;

	}

	$ii = $i - 1;

	while($ii >= 0){

		echo '<li class="box-l btn float-left bg-success text-light ml-1 mr-1 mb-1 btn-sm"><a href="#tkts-line" id="'.$ar_session1[$ii].'" class="lt-tkt-box-b" onclick="modal_lt_d(id);">+ '.$ar_session0[$ii].' <img src="open-iconic-master/png/tag-3x.png" width="10px" height="10px"></a></li>';
		$ii--;
	
	}

}
?>