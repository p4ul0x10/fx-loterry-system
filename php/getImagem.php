<?php
	
	$host = $_SERVER['REQUEST_METHOD'];
	
	if($host == "POST"){
		exit();
	}

	session_start();
	include "conn.php";
	
	$picNum = $_GET['user'];
	$ref_name = $_GET['ref_name'];
	$user = $_SESSION['email'];
	
	if(isset($user)){
		
		if(is_numeric($picNum)){

			$result = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user'");
			$ru = mysqli_affected_rows($con);
			$ar_user_profile = mysqli_fetch_array($result);

			$id_user_request = $ar_user_profile['id'];

			if($id_user_request != $picNum){
				
				$result = mysqli_query($con, "SELECT * FROM usuarios WHERE id ='$picNum'");
				
				if($rr = mysqli_affected_rows($con) >= 1){

					if($row = mysqli_fetch_object($result)){

						if(isset($row->photo)){
						
							header("Content-type: image/gif");
							echo $row->photo;
						
						}else{
						
							echo "default img";
						
						}

					}

				}				
			
			}else{
			
				if($ref_name == "null" && $ru >= 1){

					$result = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user' AND id='$picNum' AND photo > '1'");
					if($rr = mysqli_affected_rows($con) >= 1){

						if($row = mysqli_fetch_object($result)){
						
							if(isset($row->photo)){

								header("Content-type: image/gif");
								echo $row->photo;
							
							}else{
							
								echo "default img";
							
							}

						}else{
					
							echo "Nenhuma imagem encontrada, entre em contato com sua Assistência.";
					
						}
					
					}
					
				} 
			
			}

			if(isset($ref_name) && $ref_name != "null" && $ru >= 1){
				
				$result = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$ref_name'");
		
				if($rr = mysqli_affected_rows($con) >= 1){
		
					if($row = mysqli_fetch_object($result)){
		
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