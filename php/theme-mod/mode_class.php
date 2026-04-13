<?php

function theme_mode_color(){

	include $_SERVER['DOCUMENT_ROOT']."/php/conn.php";
	$email = $_SESSION['email'];

	$var_mode_theme = array();
	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$vmt = "light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				$vmt = "dark";
			}
		}
	
		$var_mode_theme[0] = $vmt;
	}
	
	return $var_mode_theme;	

}

function nav_link(){

	include $_SERVER['DOCUMENT_ROOT']."/php/conn.php";
	$email = $_SESSION['email'];

	$var_mode_color = array();
	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$vmc = "color-theme";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				$vmc = "text-light";
			
			}
		
		}
	
		$var_mode_color[0] = $vmc;

	}
	
	return $var_mode_color;	
}

function text_color(){

	include $_SERVER['DOCUMENT_ROOT']."/php/conn.php";
	$email = $_SESSION['email'];

	$var_mode_text_color = array();
	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$vtt = "color-theme";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				$vtt = "text-light";

			}

		}
		
		$var_mode_text_color[0] = $vtt;
	
	}
		
	return $var_mode_text_color;

}

function nav_link_out(){

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

				echo "btn-outline-light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "btn-outline-dark";

			}

		}

	}
		
}

function bg_theme(){

	include $_SERVER['DOCUMENT_ROOT']."/php/conn.php";
	$email = $_SESSION['email'];

	$var_mode_bg = array();
	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$vtb = "bg-light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				$vtb = "bg-dark";
			
			}
		
		}
	
		$var_mode_bg[0] = $vtb;

	}
	
	return $var_mode_bg;

}

function bg_color(){

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

				echo "text-light";
			
			}else if($get_user['conf_theme'] == "dark"){
			
				echo "bg-theme-d";
			}
		}
	}
		
}
?>