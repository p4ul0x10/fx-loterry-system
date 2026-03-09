<?php
function lot_ini_end($max_id, $lt_session){

	include "../conn.php";

	$ar_lot_ini = array();
	$ar_lot_end = array();

	//start
	$get_tkt_buy_list = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$lt_session'");
	//end

	//start get set init end lot val's
	if($rw = mysqli_affected_rows($con) >= 1){
	
		$gd = 0;

		while ($ar_win = mysqli_fetch_array($get_tkt_buy_list)) { 

			//start add val ini lot end lot 
		    if($gd <= $max_id){
			
			    if($gd == 0){

			        $lot = $ar_win['total_ticket'];
			        $ar_lot_end[$gd] = $lot;

			    }else{

			        $ar_lot_end[$gd] = $ar_lot_end[$gd-1] + $ar_win['total_ticket'] + 1;

			    }
						        
			    if($gd > 0){

			        $ar_lot_ini[$gd] = $ar_lot_end[$gd-1] + 1;

			    }else{

			    	$ar_lot_ini[$gd] = 1;

			    }
		   		
		   		$gd++;

		   	}
			//end
		}
		
	}

	$ar_lot = array();

	$ar_lot[0] = $ar_lot_ini[$gd-1];
	$ar_lot[1] = $ar_lot_end[$gd-1];

	$out = $ar_lot;

	return $out;

}

function lot_return_ini_end($fs){
	
	//start get num lot min - max
	$n1 = "";
	$n2 = "";

	$lot_ar = str_split($fs);

	$len = strlen($fs);
	$c = 0;
	$st = 1;

	while ($c < $len) {
		
		if($lot_ar[$c] != "-" && $lot_ar[$c] != " " && $st == 1){
			$n1 = $n1."".$lot_ar[$c]; 
		}

		if($lot_ar[$c] == "-"){
			$st = 2;
		}

		if($lot_ar[$c] != "-" && $lot_ar[$c] != " " && $st == 2){
			$n2 = $n2."".$lot_ar[$c];
		}

		$c++;
	
	}
	
	if(!is_numeric($n1) || !is_numeric($n2)){

		exit();

	}
	//end 

	$ar_n1_n2 = array();

	$ar_n1_n2[0] = $n1;
	$ar_n1_n2[1] = $n2;

	$out = $ar_n1_n2;

	return $out;
}
?>