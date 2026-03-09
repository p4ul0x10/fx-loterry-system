<?php

	ini_set( 'display_errors', 0);

	$host = $_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}

	session_start();
	include "../conn.php";

	$user = $_SESSION['email'];
	$file = $_FILES['file'];
	$paste = "imagesperfil";

	$get_id = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$user'");
	$array_user = mysqli_fetch_array($get_id);
	$id_user = $array_user['id']; 

	if($file != NULL){

		$nomeFinal = $id_user.'.jpg';
		$dir_nome_final = "php";

		if(move_uploaded_file($file['tmp_name'], $nomeFinal)){

			$fileSize = filesize($nomeFinal);
			$fileFinal = addslashes(fread(fopen($nomeFinal, "r"), $fileSize));
			$add = mysqli_query($con, "UPDATE usuarios SET photo = '$fileFinal' WHERE email = '$user'");

			if($row = mysqli_affected_rows($con) >= 1){
				echo "<script>location.href='http://192.168.1.103/perfil.php?profile=imagem-enviada';</script>";
			}else{
				echo "Erro ao enviar Imagem : (<script>location.href='192.168.1.103/backoffice.php?logout=imagem-enviada';</script>";
			}

		}

	}else{

		echo "error". $user;
	
	}

?>