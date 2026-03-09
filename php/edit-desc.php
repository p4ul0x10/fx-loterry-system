<?php 
	
	$host =$_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	
	include "conn.php";

	$descricao = utf8_encode($_POST['desc']);

	if(strlen($descricao) < 18){
		echo "<p class='text-danger'>O titulo deve conter pelo menos 18 caracteres</p>";
		exit();
	}
	$att_titulo = mysqli_query($con, "UPDATE hometexto SET textodescricao='$descricao' WHERE id='1'");

	if($r=mysqli_affected_rows($con) >= 1){
		echo "<p class='text-primary'>descrição atualizada com sucesso</p>";
	}else{
		echo "<p class='text-danger'>Não foi possivel editar, tente outra vez</p>";
	}
?>