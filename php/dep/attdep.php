<?php
$host =$_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}

session_start();
include "../conn.php";

$email = $_SESSION['email'];
$id_rm = $_POST['dep_id'];

if(strlen($id_rm) < 16){
	echo "ini";
	$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
	if($rgu = mysqli_affected_rows($con) >= 1){
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}
	}

	$get_usr = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_rm'");
	if($rgu = mysqli_affected_rows($con) >= 1){
		while ($idu=mysqli_fetch_array($get_usr)) {
			$dep=$idu['id_dep'];
		}
	}
	echo "dep: ".$dep." ".$id_rm;
	$get_usr = mysqli_query($con, "SELECT * FROM deposits WHERE id = '$dep' AND id_user = '$id'");
	if($rgu = mysqli_affected_rows($con) >= 1){
		echo "f";
		$rm_dep = mysqli_query($con, "DELETE FROM deposits WHERE id = '$dep'");
		$rm_dep_rel = mysqli_query($con, "DELETE FROM rel_deposits WHERE id_charnum = '$id_rm'");
		$rm = mysqli_query($con, "DELETE FROM net_protos WHERE id_dep = '$dep'");
		//$get_extrato = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id'");
	}
}
?>
