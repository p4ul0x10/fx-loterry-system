<?php

include "conn.php";

	session_start();
	$id_dep = $_POST['id_charnum'];
	$email = $_SESSION['email'];
	$rows_p = 0;
	if(strlen($id_dep) <= 8){
		
		$query_identy= mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_dep'");

		if($rows_identy = mysqli_affected_rows($con) >= 1){

			$array_identy = mysqli_fetch_array($query_identy);
			$id_dep_d = $array_identy["id_dep"];
			$query_get_user = mysqli_query($con, "SELECT * FROM deposits WHERE id = '$id_dep_d'");
			$array_user = mysqli_fetch_array($query_get_user);
			$id_user_dep = $array_user['id_user'];
		
			$query_deps = mysqli_query($con, "SELECT * FROM deposits WHERE id_user='$id_user_dep'");
			$c=0;
			if($rows_dep = mysqli_affected_rows($con) >= 1){
		
				while($rows_deps = mysqli_fetch_array($query_deps)){
					
					if($rows_deps['id_user'] == $id_user_dep && $rows_deps['id'] <= $id_dep_d){
						$rows_p = $rows_p + 27+7;
						if($c >= 2){
							$rows_p=$rows_p+(0*$c);
						}
						$c++;
					}
				}

				sleep(2);
				echo $c;
			}		

		}

	}else{

		echo "tickets";
	}
?>