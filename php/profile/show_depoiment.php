<?php

	$host =$_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	
	include "../conn.php";

	$user = addslashes($_POST['user']);
	$get_user_id = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' OR id = '$user'");
	
	if($ru = mysqli_affected_rows($con) >= 1 && strlen($user) < 17){
		
		$array_user_depo = mysqli_fetch_array($get_user_id);
		$id_user = $array_user_depo['id'];
		$nome_user = $array_user_depo['f_nome'];

		$get_depoiment = mysqli_query($con, "SELECT * FROM depoiments WHERE id_user='$id_user' ");
		
		if($rd = mysqli_affected_rows($con) >= 1){
			$array_depoiment = mysqli_fetch_array($get_depoiment);
			echo $return = $array_depoiment['text_depo'];
		}			
	
	}else{
		
		exit();
		mysql_close();
	}
?>