<?php
	session_start();
	include "conn.php";
	$email = $_SESSION['email'];
	$coin = $_POST['coin'];


	if($coin != "default" && $coin != "btc" && $coin != "ltc" && $coin != "tron" && $coin != "eth" && $coin != "usdt" && $coin != "busd"){
			echo "<a href='#' title='coin updated'>Invalid coin !</a>";
	}else{

		$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($row_true = mysqli_affected_rows($con) == 1){
			
			$get_user = mysqli_fetch_array($check_id_user);
			$id = $get_user['id'];
			$update_coin = mysqli_query($con, "UPDATE user_config SET main_coin = '$coin' WHERE id_user = '$id'");
			if($row_update = mysqli_affected_rows($con) >= 1){
				echo "<a href='#' title='coin updated'>Coin updated></a>";
			}
		}
	}
?>