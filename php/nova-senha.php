<?php
	$host =$_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	session_start();
	include ("conn.php");
	
	$senha = $_POST['senha'];
	$nova1 = $_POST['nova1'];
	$nova2 = $_POST['nova2'];
	$email = $_POST['email'];
	$type =  $_POST['subject'];
	
	if (strlen($nova1) < 4 || strlen($nova2) < 4) {
		echo "<p class='alert-danger'>Min 4 caracteres for password...</p>";
		exit();
	}
	
	$checksenha= mysqli_query($con, "SELECT * FROM usuarios WHERE pw = '$senha' and email ='$email'");

	if ($r=mysqli_affected_rows($con) >= 1) {

		while ($getsenha=mysqli_fetch_array($checksenha)) {
			if ($nova1 == $getsenha['pw'] || $nova2 == $getsenha['pw']) {
				echo "<p class='alert-danger'>New password must be different of the current ...</p>";
				exit();
			}
		}
		$pw = md5($nova1);
		$addnova = mysqli_query($con, "UPDATE usuarios SET pw='$nova1' WHERE email ='$email'");
		$addnova = mysqli_query($con, "UPDATE usuarios SET senha='$pw' WHERE email ='$email'");
		echo "<p class='alert-success'>Nova senha adicionada, muito bem !</p>";
		session_destroy();
	}else{
		echo "<p class='alert-danger'>Password invalid.</p>";
	}
?>