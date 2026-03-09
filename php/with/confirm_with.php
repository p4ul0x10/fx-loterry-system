<?php
	
	$confirm_amount = "false";	

	$get_with_confirmed = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE dep_con = '$id_dep_id'");
	
	if($row_with_confirmed = mysqli_affected_rows($con) >= 1){
		
		$array_rel = mysqli_fetch_array($get_with_confirmed);	
		$id_with = $array_rel['id_charnum'];
		
		$get_check_with_id = mysqli_query($con, "SELECT sum(quantidade)qtd FROM saque WHERE con_with='$id_with'"); 
		
		if($row_dep = mysqli_affected_rows($con) >= 1){
			
			$array_qtd = mysqli_fetch_array($get_check_with_id);
			$id_withdep = $array_rel['dep_con'];
			$amount_with = $array_qtd['qtd'];
			
			$confirm_amount = "true";
			
		}else{
			
			echo "withdraw not found";
		}
	}

?>