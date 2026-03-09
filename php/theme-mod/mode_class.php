<?php

function theme_mode_color(){

	include "php/conn.php";
	$email = $_SESSION['email'];

	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				echo "light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "dark";
			}
		}
	}
		
}

function nav_link(){

	include "php/conn.php";
	$email = $_SESSION['email'];

	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				echo "text-light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "text-light";
			}
		}
	}
		
}

function bg_color(){

	include "php/conn.php";
	$email = $_SESSION['email'];

	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				echo "text-light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "bg-theme-d";
			}
		}
	}
		
}

function text_color(){

	include $_SERVER['DOCUMENT_ROOT']."/php/conn.php";
	$email = $_SESSION['email'];

	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				echo "color-theme";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "text-light";

			}

		}
		
	}
		
}

function nav_link_out(){

	include "php/conn.php";
	$email = $_SESSION['email'];

	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				echo "btn-outline-light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "btn-outline-dark";

			}

		}

	}
		
}

function bg_theme(){

	include "php/conn.php";
	
	$email = $_SESSION['email'];

	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				echo "bg-light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "bg-dark";
			}
		}
	}
		
}

?>