<?php
	session_start();
	$host = $_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	
	include "../conn.php";

	$email = $_SESSION['email'];
	$id = addslashes($_POST['id']);
	
	if(is_numeric($id)){
		$check_id = mysqli_query($con, "SELECT * FROM notifications WHERE id='$id' AND email='$email'");
		if($r_check = mysqli_affected_rows($con) >= 1){
			$rm = mysqli_query($con, "UPDATE notifications SET action = '1' WHERE id='$id'");
		}
	}
?>