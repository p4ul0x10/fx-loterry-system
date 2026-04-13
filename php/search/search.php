<?php

//
include $_SERVER['DOCUMENT_ROOT']."/php/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/php/theme-mod/mode_class.php";
include $_SERVER['DOCUMENT_ROOT']."/php/lt/pgs-functions.php";
//

//
session_start();

$search = $_POST['search'];
$search_type = $_POST['search_type'];
$mode_search = $_POST['mode_search'];
//

//
$email = $_SESSION['email'];
$query_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
$ar_user = mysqli_fetch_array($query_user);

$idu = $ar_user['id'];
$query_user = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$idu'");
//

if(strlen($search) >= 16){
	exit();
}

if($search_type == 'form-control search-input-w sw'){ //for winners

	//start get user info search
	$query_config = mysqli_query($con, "SELECT * FROM user_config WHERE id_user ='$idu'");
	$ar_config = mysqli_fetch_array($query_config);

	$pgi = $ar_config['lt_wipg'];
	$pgw = $ar_config['pgw'];
	$l_dt = $ar_config['dt_w'];
	$ipg = 1;

	$dt = base64_encode($l_dt);

	$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE data = '$dt'");
	$get_last_session = mysqli_fetch_array($get_last_winners);
	$last_session_lt = $get_last_session['session_id'];
	//end
	
	//start get filters data 
	if($mode_search == "fw-name"){
		
		$ar_id = array();
		$ar_str = array();
		$ar_lot = array();

		$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
		
		//start get set 
		$n = 0;
		while($ar_list = mysqli_fetch_array($query_search)){
			
			$ar_id[$n] = $ar_list['id'];
			$ar_str[$n] = $ar_list['nick'];
			$ar_lot[$n] = $ar_list['total_ticket'];
			$n++;
		
		}
		
		$n = 0;
		$nn = 0;
		$nnn = 0;
		$cs = 0;
		$num_rows_search = mysqli_num_rows($query_search);
		$v = 0;

		$str_ar_fs = str_split($_POST['search']);
		$str_len_fs = strlen($_POST['search']);
		
		$last_count_char = 0;
		$current_char = 0;
		
		while ($n < $num_rows_search) {
			
			$str_ar = str_split($ar_str[$n]);
			$str_len = strlen($ar_str[$n]);

			while($nn < $str_len_fs){
		
				while($nnn < $str_len){

					if($str_ar_fs[$nn] == $str_ar[$nnn] && $nnn < $str_len_fs){ //name valid
						
						$v++;
						break;
					
					}

					$nnn++;

				}

				$nadd = $nn + 1;
				
				if($nadd >= $str_len_fs){

					if($v < $str_len_fs){
						$ar_id[$n] = 0;
					}

					if($v < 1){ //invalid id -> search not found
						$ar_id[$n] = 0;
					}else{
						$v = 0;
					}

				}
				
				$nn++;
		
			} 

			$nn = 0;
			$nnn = 0;
			$v = 0;
			//echo " ".$ar_id[$n]." ".$fs." ".$ar_str[$n];
		
			$n++;
		
		}
		//end

		mysqli_query($con, "UPDATE user_config SET pgw = '1' WHERE id_user = '$idu'");

	}else if($mode_search == "fw-tickets"){
	
		$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
		mysqli_query($con, "UPDATE user_config SET pgw = '1' WHERE id_user = '$idu'");

	}else if($mode_search == "fw-lot"){

		$n1 = "";
		$n2 = "";

		$lot_ar = str_split($search);

		$len = strlen($search);
		$c = 0;
		$st = 1;
		$cs = 0;

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
  
		if($pgw == 1){
			$max_ipg = 0;
		}else{
			$max_ipg = $pgi * ($pgw - 1);
		}

		$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt' AND total_ticket > 0 ORDER BY id ASC LIMIT 999999");

		mysqli_query($con, "UPDATE user_config SET pgw = '1' WHERE id_user = '$idu'");

	}
	//end
	
	//start
	$get_tkt_buy_list = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
	$num_rows = mysqli_num_rows($get_tkt_buy_list);
	//end

	$ar_lot_ini = array();
	$ar_lot_end = array();

	if($rw = mysqli_affected_rows($con) >= 1){
		
		$count_lot = 0;
		$gd = 0;
		
		//start get set data search
		while ($ar_win = mysqli_fetch_array($get_tkt_buy_list)) { 

			//start add val ini lot end lot 
		    if($gd == 0){

		        $lot = $ar_win['total_ticket'];
		        $ar_lot_end[$gd] = $lot;

		    }else{

		        $ar_lot_end[$gd] = $ar_lot_end[$gd-1] + $ar_win['total_ticket'] + 1;
		        $nn2 = $n2+1;

		    }
					        
		    if($gd > 0){

		        $ar_lot_ini[$gd] = $ar_lot_end[$gd-1] + 1;

		    }else{

		    	$ar_lot_ini[$gd] = 1;
		    	$nn2 = $lot;

		    }
		   	//end

		   	//start show data
		   	if($mode_search == "fw-name" && $ar_win['id'] == $ar_id[$cs]){ ?> 

		   		<div class="col-xl-3 col-md-6" id="<?php echo $count."-".$ar_lot_ini[$gd].""."-dt-".$ar_lot_end[$gd]; ?>">
					<div class="card bg-theme text-white mb-1">
					  	<div class="card-body" id="dt-<?php echo $count; ?>">
					      <div>
					        <p style="float: left;padding: 0px;margin: 0px;"><?php echo $ar_win['nick']; ?></p>
					        <p class="text-light" style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a href="#" class="text-light"><a href="#" class="text-muted"><?php echo $ar_lot_ini[$gd]." - ".$ar_lot_end[$gd]; ?></a> <i aria-hidden="true" class="fa fa-cubes fa-1x text-light"></i></p>
					      </div>
					    </div>

					    <div class="card-footer d-flex align-items-center justify-content-between" style="padding: 0px 0px;">
					      <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Tickets: <a href="#" class="text-muted" style="margin: 0px 4px;position: absolute;display: inline;"><?php echo $ar_win['total_ticket']; ?></a></p>
					      <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Earns: <a href="#" class="text-muted">$<?php echo $ar_win['total_earn']; ?></a></p>
					      <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Rate: <a href="#" class="text-muted"><?php echo $ar_win['parcial']; ?>%</a></p>
					      <div class="small text-white">
					        <svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
					          <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
					        </svg>
					      </div>
					    </div>
					</div> 
				</div>
		   		
		   	<?php $ipg++; } $cs++;

		   	if($mode_search == "fw-tickets" && $ar_win['total_ticket'] == $search && $ipg <= $pgi){ ?> 

		   		<div class="col-xl-3 col-md-6" id="<?php echo $count."-".$ar_lot_ini[$gd].""."-dt-".$ar_lot_end[$gd]; ?>">
					<div class="card bg-theme text-white mb-1">
					  	<div class="card-body" id="dt-<?php echo $count; ?>">
					      <div>
					        <p style="float: left;padding: 0px;margin: 0px;"><?php echo $ar_win['nick']; ?></p>
					        <p class="text-light" style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a href="#" class="text-light"><a href="#" class="text-muted"><?php echo $ar_lot_ini[$gd]." - ".$ar_lot_end[$gd]; ?></a> <i aria-hidden="true" class="fa fa-cubes fa-1x text-light"></i></p>
					      </div>
					    </div>

					    <div class="card-footer d-flex align-items-center justify-content-between" style="padding: 0px 0px;">
					      <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Tickets: <a href="#" class="text-muted" style="margin: 0px 4px;position: absolute;display: inline;"><?php echo $ar_win['total_ticket']; ?></a></p>
					      <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Earns: <a href="#" class="text-muted">$<?php echo $ar_win['total_earn']; ?></a></p>
					      <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Rate: <a href="#" class="text-muted"><?php echo $ar_win['parcial']; ?>%</a></p>
					      <div class="small text-white">
					        <svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
					          <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
					        </svg>
					      </div>
					    </div>
					</div> 
				</div>
		   		
		   	<?php $ipg++; }
	   	
	   		if($mode_search == "fw-lot" && $count_lot >= $max_ipg && $ipg <= $pgi && $ar_lot_ini[$gd] >= $n1 && $ar_lot_end[$gd] <= $n2 && $ar_lot_end[$gd] <= $nn2){ ?>
				
				<div class="col-xl-3 col-md-6" id="<?php echo $count."-".$ar_lot_ini[$gd].""."-dt-".$ar_lot_end[$gd]; ?>">
					<div class="card bg-theme text-white mb-1">
					  	<div class="card-body" style="">
					      <div>
					        <p style="float: left;padding: 0px;margin: 0px;"><?php echo $ar_win['nick']; ?></p>
					        <p style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a class="text-muted" href="#"><?php echo $ar_lot_ini[$gd]." - ".$ar_lot_end[$gd]; ?></a> <i aria-hidden="true" class="fa fa-cubes fa-1x text-light"></i></p>
					      </div>
					    </div>
					    <div class="card-footer d-flex align-items-center justify-content-between" style="padding: 0px 0px;">
					    	<a href="#" class="col-md-4 small text-white stretched-link">Tickets: <?php echo $ar_win['total_ticket']; ?></a>
					    	<a href="#" class="col-md-3 small text-white stretched-link">Earns: $<?php echo $ar_win['total_earn']; ?></a>
					    	<a href="#" class="col-md-3 small text-white stretched-link">Rate: <?php echo $ar_win['parcial']; ?>%</a>
					      <div class="small text-white">
					        <svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
					          <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
					        </svg>
					      </div>
					    </div>
					</div> 
				</div>
		
			<?php $ipg++; } $count_lot++; $gd++; }
			//end
	}
	//end

}else if($search_type == 'form-control search-input sn'){ //for network

	$query_config = mysqli_query($con, "SELECT * FROM user_config WHERE id_user ='$idu'");
	$ar_config = mysqli_fetch_array($query_config);

	$pgi = $ar_config['lt_nipg'];

	if($mode_search == "fn-id"){
	
		if($search < 1 && !is_numeric($search)){
			exit();
		}

		$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE leader_id = '$idu' ORDER BY id ASC LIMIT 9999");
		if($r_id_search = mysqli_affected_rows($con) > 1){

			$id_count = 1;

			while($array_search_id = mysqli_fetch_array($query_search)){

				if($id_count == $search){

					$id_ref = $array_search_id['id'];
					$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE id='$id_ref'");
					break;
				
				}

				$id_count++;

			}

		}

	}else if($mode_search == "fn-name"){
	
		$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE nome_ref LIKE '%$search%' ORDER BY 
			nome_ref LIMIT $pgi");
	
	}else if($mode_search == "fn-level"){
	
		$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE level_ref LIKE '%$search%' ORDER BY level_ref LIMIT $pgi");
	
	}else if($mode_search == "fn-date"){
	
		$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE started_ref LIKE '%$search%' ORDER BY started_ref LIMIT $pgi");
	
	}else if($mode_search == "fn-leader"){
	
		$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE leader_ref LIKE '%$search%' ORDER BY leader_ref LIMIT $pgi");
	
	}else if($mode_search == "fn-earns"){
	
		$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE earns_ref LIKE '%$search%' ORDER BY earns_ref LIMIT $pgi");
	
	}else if($mode_search == "fn-activity"){
	
		$query_search =  mysqli_query($con, "SELECT * FROM network_list WHERE activity_ref LIKE '%$search%' ORDER BY activity_ref LIMIT $pgi");
	
	}
	
	$count = 1;

	if($rs = mysqli_affected_rows($con) >= 1){
	
		while($ar_select_n = mysqli_fetch_array($query_search)){ ?>

		<tr>
			<th scope="row">
				<a href="#pos_ref" class="id_ref <?php text_color(); ?>"><?php if(isset($id_count)){ echo $id_count; }else{ echo $count; } ?></a>
			</th>
			<td>
				<a href="?ref_name=<?php echo $ar_select_n['nome_ref']; ?>" class="name_ref text-muted"><?php echo $ar_select_n['nome_ref']; ?></a>
			</td>
			<td>
				<a href="#ref_level" class="level_ref <?php text_color(); ?>"><?php echo $ar_select_n['level_ref']; ?></a>
			</td>
			<td>
				<a href="#ref_date" class="date_ref <?php text_color(); ?>"><?php echo $ar_select_n['started_ref']; ?></a>
			</td>
			<td>
				<a href="#up_name_ref" class="up_ref text-muted"> <?php echo $ar_select_n['leader_ref']; ?></a>
			</td>
			<td>
				<a href="#status_ref" class="status_ref <?php text_color(); ?>"><?php echo $ar_select_n['status_ref']; ?></a>
			</td>
			<td>
				<a href="?earns_ref=<?php echo $ar_select_n['nome_ref']; ?>" class="cv earns_ref <?php text_color(); ?>"><?php echo $ar_select_n['earns_ref']; ?></a>
			</td>
			<td>
				<a href="#actions" class="activity_ref <?php text_color(); ?>"><?php echo $ar_select_n['activity_ref']; ?></a>
			</td>
		</tr>

		<?php $count++; }

	}

}

?>