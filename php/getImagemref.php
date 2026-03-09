<?php
	
	$host =$_SERVER['REQUEST_METHOD'];
	if($host == "POST"){
		exit();
	}

	session_start();
	include "conn.php";
	$picNum = $_GET['picNum'];
	$ref_name = $_GET['ref_name'];
	$user = $_SESSION['email'];

	if(isset($user)){
		
		if(is_numeric($picNum)){

			$result = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user'");
			$ru = mysqli_affected_rows($con);

			if(!isset($ref_name) && $ru >= 1){

				$result = mysqli_query($con, "SELECT * FROM usuarios WHERE id=$picNum AND photo > '1'");
				if($rr = mysqli_affected_rows($con) >= 1){
					if($row=mysqli_fetch_object($result)){
					header("Content-type: image/jpg");
					echo $row->photo;
					}else{
						echo "Nenhuma imagem encontrada, entre em contato com sua Assistência.";
					}
				}
			} 
		
		}else{
			echo "error string!";
		}
	
	}
?>