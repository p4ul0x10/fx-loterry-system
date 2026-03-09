<?php

	ini_set( 'display_errors', 0);
	include "../conn.php";

	session_start();

	if(isset($_POST['gp_check'])){
		$id_user = $_SESSION['id_user'];
		mysqli_query($con, "UPDATE user_config SET gp_true = 'false' WHERE id_user = $id_user");
		exit();
	}

	$analitics = $_POST['analitics'];
	$filter = $_POST['filter'];
	$email = $_SESSION['email'];
	$month_current = $_POST['month'];
	$year_current = $_POST['cyear'];

	$array_direct_id_user = array();
	$array_direct_data = array();

	$leader = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");

	$array_leader = mysqli_fetch_array($leader);
	$leader_nome = $array_leader['f_nome'];
	$id_user = $_SESSION['id_user'];

	//start get method prev || next month
	$method = substr($filter, 1, 1);
	
	if($method == "1"){
		
		$month_current = $month_current - 1;

		if($month_current < 10){
			$m = "0"."".$month_current;
			$month_current = $m;
		}

		if($month_current < 1){
			$month_current = 12;
			$year_current -= 1;
		}

	}else if($method == "2"){

		$month_current = $month_current + 1;

		if($month_current < 10){
			$m = "0"."".$month_current;
			$month_current = $m;
		}	

		if($month_current > 12){
			$m = "0"."".$month_current;
			$month_current = $m;
			$year_current += 1;
		}

	}else{

		$month_current = $month_current;

		if($month_current < 10){
			$m = "0"."".$month_current;
			$month_current = $m;
		}	

		if($month_current > 12){
			$m = "0"."".$month_current;
			$month_current = $m;
		}

	}
	
	//end get method prev || next month
	//echo $month_current; exit();

	include "analitics/functions.php";

	if($analitics == "1"){ //analitics list 1
		
		$count_rows = 0;
		$array_direct_country = array();

		$get_first_year = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome = '$leader_nome' ORDER BY id ASC LIMIT 1");
		$get_last_year = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome = '$leader_nome' ORDER BY id DESC LIMIT 1");

		$arr_fly = mysqli_fetch_array($get_first_year);
		$fy = $arr_fly['data'];

		$arr_ly = mysqli_fetch_array($get_last_year);
		$ly = $arr_ly['data'];

		$str_fy = str_split($fy);
		$str_ly = str_split($ly);
		
		if($str_fy[4] == ","){
			$str_feny = $str_fy[5]."".$str_fy[6]."".$str_fy[7]."".$str_fy[8];
		}else{
			$str_feny = $str_fy[6]."".$str_fy[7]."".$str_fy[8]."".$str_fy[9];						
		}

		if($str_ly[4] == ","){
			$str_leny = $str_ly[5]."".$str_ly[6]."".$str_ly[7]."".$str_ly[8];
		}else{
			$str_leny = $str_ly[6]."".$str_ly[7]."".$str_ly[8]."".$str_ly[9];						
		}
		
		if($year_current >= $str_feny && $year_current <= $str_leny){
		
			analitics_graph($con, "f1", $id_user, $leader_nome, $month_current, $year_current, $_POST['wd_col']);

		}else{
			echo "offdata";
		}
	
	}else if($analitics == "2"){
		
		for ($i=0; $i < 100; $i++) { 
			$array_direct_id_user[$i] = 0;
			$array_direct_data[$i] = 0;
		}

		$cc = 0;
		$last = "null";
		$add = 1;
		$count_rows = 0;
		$array_direct_country = array();
		$array_direct_data = array();

		$get_first_year = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome = '$leader_nome' ORDER BY id DESC LIMIT 1");
		$arr_fly = mysqli_fetch_array($get_first_year);
		$lfy = $arr_fly['data'];

		$get_last_year = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome = '$leader_nome' ORDER BY id DESC LIMIT 1");
		$arr_lly = mysqli_fetch_array($get_last_year);
		$lly = $arr_lly['data'];

		$str_fly = str_split($lfy);
		$str_lly = str_split($lly);
	
		if($str_fly[4] == ","){
			$str_feny = $str_fly[5]."".$str_fly[6]."".$str_fly[7]."".$str_fly[8];
		}else{
			$str_feny = $str_fly[6]."".$str_fly[7]."".$str_fly[8]."".$str_fly[9];						
		}
		
		if($str_lly[4] == ","){
			$str_leny = $str_lly[5]."".$str_lly[6]."".$str_lly[7]."".$str_lly[8];
		}else{
			$str_leny = $str_lly[6]."".$str_lly[7]."".$str_lly[8]."".$str_lly[9];						
		}

		if($year_current >= $str_feny && $year_current <= $str_leny){

			$get_direct_link = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome = '$leader_nome'");
				
			if($row_rirect_link = mysqli_affected_rows($con) >= 1){
				
				while($qarray_direct_link = mysqli_fetch_array($get_direct_link)){
					
					$array_direct_data[$count_rows] = $qarray_direct_link['data']; 		
					$array_direct_country[$count_rows] = $qarray_direct_link['country'];
					$count_rows++;
				
				}

				$count_data = 0;
				$num_day = 0;
				$month = $month_current;
				$day = date("j");
				$array_day = array();
				$array_max_access_day = array();
				$array_country_access = array();
				$array_country = array();
				$access = 1;
			
				//start add country by month
				for ($i = 0; $i < $count_rows; $i++) { 

					$array_country_access[$i] = 0;

					if($last != $array_direct_country[$i]){ //check if country true || false for add
							
						for($ii = 0; $ii <= $cc; $ii++){

							if($array_country[$ii] == $array_direct_country[$i]){ //country added previously
								$add = 0; //no add 
							}
						}
						
						if($add == 1){ //add true

							$array_m = $array_direct_data[$i][0]."".$array_direct_data[$i][1];	

							if($month == $array_m){ 

								$array_country[$cc] = $array_direct_country[$i];
								$last = $array_direct_country[$i];
								$cc++;
							}

						}
						
						$add = 1;
					
					}
					
				}
				//end add country by month

				//start add access num 
				$add_access = 0;
				
				for ($cf = 0; $cf < $cc; $cf++) { 
					
					for ($ca = 0; $ca < $count_rows; $ca++) { 
				
						$madd = $array_direct_data[$ca][0]."".$array_direct_data[$ca][1];

						if($array_country[$cf] == $array_direct_country[$ca] && $month == $madd){
						
							$array_country_access[$add_access] = $array_country_access[$add_access] + 1;
					
						}
					
					}

					$add_access++;
				
				}

				$num_rows_flag = 0;
				//end add access num
                
                if($_POST['wd_col'] < 1050){
                	$wd_country = $_POST['wd_col'];
                	$wd_if_tm = "width: ".$wd_country."px !important ";	
                }else{
                	$wd_if_tm = "";
                }

				//start show country list
				echo '<div id="box-country" class="col-12 mb-4" style="'.$wd_if_tm.'float: left !important; height: 30px;">
				<div class="col-2 float-left" onclick="att_pg(21'.$month_current.');">
					<i id="l" aria-hidden="true" class="col-2 fa fa-2x fa-angle-left color-theme float-left"></i>
				</div>
				<div class="col-2 float-right" onclick="att_pg(22'.$month_current.');">
					<i id="r" aria-hidden="true" style="float: right !important;" class="col-2 fa fa-2x fa-angle-right color-theme float-right"></i>
				</div>
				</div>';             

				echo "<div class='col-10 mt-4 graph-mb-analitics' style='clear:both; margin: 0px auto;'><ul style='margin: 0px auto !important; display:inline-flex;'>";
				while ($num_rows_flag <= $add_access) {
				
					$array_m = $array_direct_data[$num_rows_flag][0]."".$array_direct_data[$num_rows_flag][1];
					
					if($array_country[$num_rows_flag] != ""){
					
						$flag = strtolower($array_country[$num_rows_flag]);
						$access_per_country = $array_country_access[$num_rows_flag];
						echo '<li class="nav-item text-muted"><a href="#"><img src="images/flags/'.$flag.'.svg" width="20" height="20"></a>&nbsp '.$access_per_country.' &nbsp</li>';	
						
					}
					
					$num_rows_end = $num_rows_flag % 7;

					if($num_rows_flag != $add_access && $num_rows_flag > 0 && $num_rows_end == 0 || $num_rows_flag == $add_access && $num_rows_flag != $add_access) {
						echo "</ul>"; 
					}

					if($num_rows_flag == $add_access){
						//echo "<ul>";
					}

					$num_rows_flag++;

				}
			
				echo "</div>";
				//end show country list
			
				$id_user = $_SESSION['id_user'];
        		mysqli_query($con, "UPDATE user_config SET gp_true = 'true' WHERE id_user = $id_user");
			
			}

		}else{

			//echo "offdata";
			exit();
		
		}

	}else if($analitics == "3"){

		$count_rows = 0;
		$get_first_year = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$leader_nome' ORDER BY id ASC LIMIT 1");
		$get_last_year = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$leader_nome' ORDER BY id DESC LIMIT 1");

		$arr_fy = mysqli_fetch_array($get_first_year);
		$fy = $arr_fy['data'];

		$arr_ly = mysqli_fetch_array($get_last_year);
		$ly = $arr_ly['data'];

		$str_fy = str_split($fy);
		$str_ly = str_split($ly);
		
		if($str_fy[4] == ","){
			$str_feny = $str_fy[5]."".$str_fy[6]."".$str_fy[7]."".$str_fy[8];
		}else{
			$str_feny = $str_fy[6]."".$str_fy[7]."".$str_fy[8]."".$str_fy[9];						
		}

		if($str_ly[4] == ","){
			$str_leny = $str_ly[5]."".$str_ly[6]."".$str_ly[7]."".$str_ly[8];
		}else{
			$str_leny = $str_ly[6]."".$str_ly[7]."".$str_ly[8]."".$str_ly[9];						
		}
		
		if($year_current >= $str_feny && $year_current <= $str_leny){

			analitics_graph($con, "f3", $id_user, $leader_nome, $month_current, $year_current, $_POST['wd_col']);

		}else{

			echo "offdata";
			exit();

		}

	}else if($analitics == "4"){

		//start
		$get_direct_dep_id = mysqli_query($con, "SELECT * FROM data_dep_pay WHERE id > 0");
		
		$count_ar_id = 0;
		$valid_y = 0;

		while($array_direct_user_id = mysqli_fetch_array($get_direct_dep_id)){

			$id_charnum = $array_direct_user_id['id_charnum'];

			$cmp_id = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_charnum'");
		
			$array_id_user = mysqli_fetch_array($cmp_id);

			$id_charnum_user = $array_id_user['id_dep'];
			
			$cmp_dep_id = mysqli_query($con, "SELECT * FROM deposits WHERE id = '$id_charnum_user'");
			$array_dep_user = mysqli_fetch_array($cmp_dep_id);
			$id_dep_user = $array_dep_user['id_user'];

			//
			$get_first_yearv = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_dep_user' AND sponsor = '$leader_nome' ORDER BY id ASC LIMIT 1");

			$get_last_yearv = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_dep_user' AND sponsor = '$leader_nome' ORDER BY id DESC LIMIT 1");

			$arr_fy = mysqli_fetch_array($get_first_yearv);
			$fy = $arr_fy['data'];
			
			$arr_ly = mysqli_fetch_array($get_last_yearv);
			$ly = $arr_ly['data'];

			$str_fy = str_split($fy);
			$str_ly = str_split($ly);

			if($str_fy[4] == ","){
				$str_feny = $str_fy[5]."".$str_fy[6]."".$str_fy[7]."".$str_fy[8];
			}else{
				$str_feny = $str_fy[6]."".$str_fy[7]."".$str_fy[8]."".$str_fy[9];						
			}

			if($str_ly[4] == ","){
				$str_leny = $str_ly[5]."".$str_ly[6]."".$str_ly[7]."".$str_ly[8];
			}else{
				$str_leny = $str_ly[6]."".$str_ly[7]."".$str_ly[8]."".$str_ly[9];						
			}
			//end
			
			//start	
			if($valid_y == 0){ //uniq id exclusive == false
			
				if($year_current >= $str_feny && $year_current <= $str_leny){
					
					$cmp_user = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_dep_user' AND sponsor = '$leader_nome'");

					if($rows_user = mysqli_affected_rows($con) >= 1){

						$array_user_data = mysqli_fetch_array($cmp_user);
						$array_direct_id_user[$count_ar_id] = $array_direct_id_user[$count_ar_id] + 1;
						$array_direct_data[$count_ar_id] = $array_user_data['data'];
						$count_ar_id++;
				
					}

					$valid_y = 1; //id exclusive == true

				}else{

					echo "offdata";
					exit();
				
				}

			}

		}
		//end
		
		//start
		analitics_graph($con, "f4", $id_user, $leader_nome, $month_current, $year_current, $_POST['wd_col']);
		//end

	}else if($analitics == "5"){

		$get_ref_user = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$leader_nome'");
		
		if($rows_ru = mysqli_affected_rows($con) >= 1){

			$ar_w_ru = array();
			$ar_w_dsu = array();
			$ar_w_ssu = array();

			$c_ru = 0;
			$c_su = 0;

			$num_ru = mysqli_num_rows($get_ref_user);
			$num_ru -= 1;

			while ($list_ru = mysqli_fetch_array($get_ref_user)) {
					
				$ar_w_ru[$c_ru] = $list_ru['id'];
				$id_ru = $ar_w_ru[$c_ru];

				$get_su = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id_ru'");
				
				if($r_su = mysqli_affected_rows($con) >= 1){

					$ar_su = mysqli_fetch_array($get_su);
					$ar_w_dsu[$c_su] = $ar_su['data']; 
					$ar_w_ssu[$c_su] = $ar_su['status'];		

					if($c_su == 0){
				
						$get_fwiths = mysqli_query($con, "SELECT * FROM saque WHERE id > 0 AND id_user = '$id_ru'");
								
						if($row_fw = mysqli_affected_rows($con) < 1){
							$get_fwiths = $year_current;
						}else{
							$ar_fw = mysqli_fetch_array($get_fwiths);
							$get_fwiths = $ar_fw['data'];
						}

					}

					$c_su++;
			
				}

				if($num_ru == $c_ru && isset($get_fwiths)){
					
					$get_lwiths = mysqli_query($con, "SELECT * FROM saque WHERE id > 0 AND id_user = '$id_ru'");
					
					if($row_lw = mysqli_affected_rows($con) < 1){
						$get_lwiths = $get_fwiths;
					}else{
						$ar_lw = mysqli_fetch_array($get_lwiths);
						$get_lwiths = $ar_lw['data'];
					}

				}else if($num_ru == $c_ru && !isset($get_fwiths)){
				
					$get_lwiths = mysqli_query($con, "SELECT * FROM saque WHERE id > 0 AND id_user = '$id_ru'");
					
					if($row_lw = mysqli_affected_rows($con) < 1){
						$get_lwiths = $year_current;
						$get_fwiths = $year_current;
					}else{
						$ar_lw = mysqli_fetch_array($get_lwiths);
						$get_lwiths = $ar_lw['data'];
						$get_fwiths = $year_current; 
					}

				}
				
				$c_ru++;
			
			}

		}else{

			echo "offdata";
			exit();
		
		}

		if($c_ru < 1){
			
			echo "offdata";
			exit();
	
		}

		$arr_fy = $get_fwiths;
		$fy = $arr_fy;

		$arr_ly = $get_lwiths;
		$ly = $arr_ly;
	
		$str_fy = str_split($fy);
		$str_ly = str_split($ly);
	
		if($str_fy[4] == ","){
			$str_feny = $str_fy[5]."".$str_fy[6]."".$str_fy[7]."".$str_fy[8];
		}else{
			$str_feny = $str_fy[6]."".$str_fy[7]."".$str_fy[8]."".$str_fy[9];						
		}	
		
		if($str_ly[4] == ","){
			$str_leny = $str_ly[5]."".$str_ly[6]."".$str_ly[7]."".$str_ly[8];
		}else{
			$str_leny = $str_ly[6]."".$str_ly[7]."".$str_ly[8]."".$str_ly[9];						
		}

		if($year_current >= $str_feny && $year_current <= $str_leny){

			$count_ar_id = 0;
		
		}else{
			
			echo "offdata";
			exit();

		}	

		$c_ad = 0;
		while($c_ad < $c_su){

			if($ar_w_ssu[$c_ad] == "1"){
			
				$array_direct_id_user[$count_ar_id] = $array_direct_id_user[$count_ar_id] + 1;
				$array_direct_data[$count_ar_id] = $ar_w_dsu[$c_ad];
				$count_ar_id++;

			}

			$c_ad++;
		
		}
		echo '<script>console.log('.$count_ar_id.')</script>';

		//start
		analitics_graph($con, "f5", $id_user, $leader_nome, $month_current, $year_current, $_POST['wd_col']);
		//end

	}else if($analitics == "6"){

		$get_fdeps = mysqli_query($con, "SELECT * FROM deposits WHERE id > 0 ORDER BY id ASC LIMIT 1");
		$get_ldeps = mysqli_query($con, "SELECT * FROM deposits WHERE id > 0 ORDER BY id DESC LIMIT 1");

		$arr_fy = mysqli_fetch_array($get_fdeps);
		$fy = $arr_fy['data'];
		
		$arr_ly = mysqli_fetch_array($get_ldeps);
		$ly = $arr_ly['data'];

		$str_fy = str_split($fy);
		$str_ly = str_split($ly);
		
		if($str_fy[4] == ","){
			$str_feny = $str_fy[5]."".$str_fy[6]."".$str_fy[7]."".$str_fy[8];
		}else{
			$str_feny = $str_fy[6]."".$str_fy[7]."".$str_fy[8]."".$str_fy[9];						
		}

		if($str_ly[4] == ","){
			$str_leny = $str_ly[5]."".$str_ly[6]."".$str_ly[7]."".$str_ly[8];
		}else{
			$str_leny = $str_ly[6]."".$str_ly[7]."".$str_ly[8]."".$str_ly[9];						
		}
		
		if($year_current >= $str_feny && $year_current <= $str_leny){
			
			$count_rows = 0;
			$get_direct_deposit_id = mysqli_query($con, "SELECT * FROM deposits WHERE id > 0");
			$count_ar_id = 0;
		
		}else{
		
			echo "offdata";
			exit();
		
		}	
			
		//start
		analitics_graph($con, "f6", $id_user, $leader_nome, $month_current, $year_current, $_POST['wd_col']);
		//end

	}
		
?>