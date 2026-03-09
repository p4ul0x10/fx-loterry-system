<?php 
	
	$host =$_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	include "conn.php";

	$titulo = utf8_encode($_POST['titulo']);

	if(strlen($titulo) < 8){
		echo "<p class='text-danger'>O titulo deve conter pelo menos 8 caracteres</p>";
		exit();
	}
	$att_titulo = mysqli_query($con, "UPDATE hometexto SET textotitulo='$titulo' WHERE id='1'");

	if($r=mysqli_affected_rows($con) >= 1){
		echo "<p class='text-primary'>Titulo atualizado com sucesso</p>";
	}else{
		echo "<p class='text-danger'>Não foi possivel editar, tente outra vez</p>";
	}
?>