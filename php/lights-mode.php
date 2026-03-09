<?php

	$host = $_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}

	session_start();
	include "conn.php";
	$email = $_SESSION['email'];
	$lights = $_POST['lights'];
	
	if($lights == "#light" || $lights == "#dark"){

		if($lights != "#light" && $lights != "#dark"){
	
				echo "Invalid light mode !";
				exit();
	
		}else{

			$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

			if($row_true = mysqli_affected_rows($con) >= 1){
				
				$get_user = mysqli_fetch_array($check_id_user);
				$id = $get_user['id'];
				
				if($lights == "#light"){
					$mode = "dark";
				}else{
					$mode = "light";
				}
				echo $mode;
				$update_coin = mysqli_query($con, "UPDATE user_config SET conf_theme = '$mode' WHERE id_user = '$id'");
				
			}
			
		}

	}else{

		$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($row_true = mysqli_affected_rows($con) >= 1){
			
			$get_user = mysqli_fetch_array($check_id_user);
			$id = $get_user['id'];

			$update_coin = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
			if($row_true = mysqli_affected_rows($con) >= 1){
			
				$get_user = mysqli_fetch_array($update_coin);
				echo $get_user['conf_theme'];
			}
		}
	}
				
?>