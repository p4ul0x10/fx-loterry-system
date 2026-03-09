<?php

	include "conn.php";
	session_start();
	$id_dep = $_POST['id_dep'];
	$proto = $_POST['net_proto'];
	$email = $_SESSION['email'];
	
	if(strlen($id_dep) <= 8 && strlen($proto) < 16){ //package 

		$get_user=mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($row_user = mysqli_affected_rows($con) >= 1){

			$array_user = mysqli_fetch_array($get_user);
			$id_user = $array_user['id'];

			$get_dep = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_dep'");

			if($row_dep = mysqli_affected_rows($con) >= 1){

				$array_dep_rel = mysqli_fetch_array($get_dep);
				$id_dep_rel = $array_dep_rel['id_dep'];
				$check_dep_for_user = mysqli_query($con, "SELECT * FROM deposits WHERE id = '$id_dep_rel' AND id_user ='$id_user'");

				if($check_id_dep_for_user = mysqli_affected_rows($con) >= 1){

					$array_dep_user = mysqli_fetch_array($check_dep_for_user);
					$id_dep_user = $array_dep_user['id'];
					$get_payments_adds = mysqli_query($con, "SELECT * FROM net_protos WHERE id_dep='$id_dep_user' AND net = '$proto'");
				
					if($row_proto = mysqli_affected_rows($con) >= 1){

						$array_payments = mysqli_fetch_array($get_payments_adds);
						$ar_json = array("proto" => $array_payments['net'], "wallet" => $array_payments['wallet'], "qr" => $array_payments['qr_code']);
						$json = json_encode($ar_json);
						echo $json;

					}else{
						echo $id_dep_user."null";
					}
					
				}

			}

		}

	}else if(strlen($id_dep) >= 8 && strlen($id_dep) <= 10 && strlen($proto) < 16){ //tickets
 	
 		$get_user=mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($row_user = mysqli_affected_rows($con) >= 1){

			$array_user = mysqli_fetch_array($get_user);
			$id_user = $array_user['id'];

	 		$check_dep_for_user = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE rel_package = '$id_dep' AND id_user ='$id_user'");

			if($check_id_dep_for_user = mysqli_affected_rows($con) >= 1){

				$array_dep_user = mysqli_fetch_array($check_dep_for_user);
				$id_dep_user = base64_encode($id_dep);
				$get_payments_adds = mysqli_query($con, "SELECT * FROM net_protos WHERE id_dep='$id_dep_user' AND net = '$proto'");
			
				if($row_proto = mysqli_affected_rows($con) >= 1){

					$array_payments = mysqli_fetch_array($get_payments_adds);
					$ar_json = array("proto" => $array_payments['net'], "wallet" => $array_payments['wallet'], "qr" => $array_payments['qr_code']);
					$json = json_encode($ar_json);
					echo $json;

				}else{
					echo $id_dep_user."null";
				}
			}
		}
	}

?>