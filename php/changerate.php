<?php
	$host =$_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	include "conn.php";

	$rate = $_POST['rate'];
	$update_rate = mysqli_query($con, "UPDATE info SET ganho_diario='$rate' WHERE ganho_diario='$rate' OR ganho_diario!='$rate'");

	if ($r=mysqli_affected_rows($con) >= 1) {
		echo "<p class='text-success'>Rate atualizada com sucesso ...</p>";
	}else{
		echo "<p class='text-danger'>Ops, ocorreu um erro ...</p>";
	}
?>