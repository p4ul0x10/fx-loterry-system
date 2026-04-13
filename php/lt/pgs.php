<?php
include $_SERVER['DOCUMENT_ROOT']."/php/conn.php";
include $_SERVER['DOCUMENT_ROOT']."/php/theme-mod/mode_class.php";
include $_SERVER['DOCUMENT_ROOT']."/php/lt/pgs-functions.php";

session_start();
$email = $_SESSION['email'];

$get_id = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
$ar_id = mysqli_fetch_array($get_id);
$idu = $ar_id['id'];

$get_user_pg = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$idu'");
$ar_user = mysqli_fetch_array($get_user_pg);

if(isset($_POST['np'])){ //dropdown num items / page

	$pg_id = $_POST['id'];
	$pg_num = $_POST['np'];

}else{ //prev || next page num

	$pg_id = $_POST['num'];

}

$lt_dt = $_POST['data'];
$current_dt = str_split($lt_dt);
$str_id = str_split($pg_id);
	
if($str_id[0] == "w" && !isset($_POST['np'])){

	$pg_num = $ar_user['lt_wipg'];
	$pgwn = $ar_user['pgw'];

}else if($str_id[0] == "n" && !isset($_POST['np'])){

	$pg_num = $ar_user['lt_nipg'];
	$pgwn = $ar_user['pgn'];

}	

//start set current last db saved units per view
if($pg_num < 1 && $str_id[0] == "w"){

	$pg_num = $ar_user['lt_wipg'];

}else if($pg_num < 1 && $str_id[0] == "n"){

	$pg_num = $ar_user['lt_nipg'];

}
//end

if($str_id[0] == "w" || $str_id[0] == "n"){ //pagination sys

	$last_dt_on_db = $ar_user['dt_w']; //last date searched

	if($str_id[0] == "w"){

		if($last_dt_on_db == ""){ //for last session closed == true

			$dt = $current_dt[0]."".$current_dt[1]."".$current_dt[2]."".$current_dt[3]."".$current_dt[4]."".$current_dt[5]."".$current_dt[6]."".$current_dt[7]."".$current_dt[8]."".$current_dt[9];
	
		}else{ //for != sessions -> session or days

			$dt = $last_dt_on_db;

		}

		$n = 0;		
		$len_dt = strlen($lt_dt);
		$str_dt = str_split($lt_dt);
	
		while ($n < $len_dt) { //loop on chars of the date field -> find turn 0 am 1 pm
	
			if($str_dt[$n] == "a" && $str_dt[$n+1] == "m"){ //% 2 == 0 -> turn 1
		
				$session_turn = "am";
				break;
		
			}else if($str_dt[$n] == "p" && $str_dt[$n+1] == "m"){ //% 2 != 0 -> turn 0

				$session_turn = "pm";
				break;
		
			}	

			$n++;

		}
	
	}
	
	if($str_id[0] == "w" && !$session_turn){ //error or possible field front end changed

		exit();
	
	}

	if(!isset($_POST['np']) && $pg_id != "w-prev-w" && $pg_id != "w-next-w" && $pg_id != "n-prev-n" && $pg_id != "n-next-n" && $pg_id != "w-prev-w-d" && $pg_id != "w-next-w-d"){ //is numeric -> pg_id == num pg

		$n = 0;
		$num_pg = "";		
		$len_num = strlen($pg_id);

		while ($n < $len_num) {
		
			if($str_id[$n] != "w" && $str_id[$n] != "n"){
				$num_pg = $num_pg."".$str_id[$n];
 			}	

			$n++;
	
		}

		if($str_id[0] ==  "w"){
			$pg_mode = "num-w";
		}else{
			$pg_mode = "num-n";
		}

	}else if($pg_id != "w-prev-w" && $pg_id != "w-next-w" && $pg_id != "n-prev-n" && $pg_id != "n-next-n" && $pg_id != "w-prev-w-d" && $pg_id != "w-next-w-d"){

		if(!isset($_POST['np']) && $ar_user['pgw'] == $num_pg && $ar_user['max_lwn'] == "true" || !isset($_POST['np']) && $ar_user['pgw'] == $num_pg && $ar_user['max_lwp'] == "true"){
			
			exit();
  			
  		}

  }else if(!isset($_POST['np']) && $ar_user['max_lwn'] == "true" && $str_id[2] == "n" && $str_id[0] == "w" || !isset($_POST['np']) && $ar_user['max_lwp'] == "true" && $str_id[2] == "p" && $str_id[0] == "w"){
  
  	exit();

  }else if(!isset($_POST['np']) && $ar_user['max_lnn'] == "true" && $str_id[2] == "n" && $str_id[0] == "n" || !isset($_POST['np']) && $ar_user['max_lnp'] == "true" && $str_id[2] == "p" && $str_id[0] == "n"){
  	exit();

  }
  //

//start 

if($_POST['fs'] != "0"){

	$fw = $_POST['fw'];
	$fs = $_POST['fs'];

	if($fw == "fw-name" || $fw == "fw-lot" || $fw == "fw-tickets"){
		
	}else{
		exit();
	}

	if(isset($fw) && $fs == "" || isset($fw) && $fs == " "){
		exit();
	}

	if(isset($fw) && isset($fs)){ //lt winners -> mode filter

		$en_data_lwin = base64_encode($ar_user['dt_w']);
		$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id > 0 AND data = '$en_data_lwin' ORDER BY id DESC LIMIT 1");

		$get_last_session = mysqli_fetch_array($get_last_winners);	
		$last_session_lt = $get_last_session['session_id'];

		$npv = $ar_user['lt_wipg'];
		$f_count = 1;
		$count_wld = 1;

		if($fw == "fw-name"){
			
			$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt' AND nick LIKE '%$fs%'");

			while ($ar_search = mysqli_fetch_array($query_search)) {
				
				$count_wld++;

			}

			$wcount = $npv;

		}else if($fw == "fw-lot"){	

			//echo $fw." ----1 ".$fs; exit();

			//start get num lot min - max
			$n1n2 = lot_return_ini_end($fs);
			
			$n1 = $n1n2[0];
			$n2 = $n1n2[1];
			//end  

			$get_tkt_buy_list = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE current_session = '$last_session_lt'");

			$lot = 1;
			$wcount = $npv; 
			$count_v = 0;

			while ($r = mysqli_fetch_array($get_tkt_buy_list)) {

				//start init end lot
				if($f_count == 1){				
					$old_lot = $lot;
				}else{
					$old_lot = $lot + 1;
				}

			  	$lot = $old_lot + $r['value'];
				//end init end lot
			  
			  	if($lot >= $n1 && $lot <= $n2){ //for check [!]
			  		$count_v++;
			  	}

			  	$f_count++;

			}

			$count_wld = $count_v;
			
		}else if($fw == "fw-tickets"){
			
			//echo $fw." 2---- ".$fs; exit();

			$query_filter = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id > 0 AND value = '$fs' AND current_session = '$last_session_lt'");

			$count_wld = mysqli_num_rows($query_filter);
			$wcount = $npv;
		
		}

		$div_nv_tw_no_exactly = false;
		//echo $count_wld." ".$wcount." ".$pgwn." ".$last_session_lt; exit();
		if($count_wld > $wcount){ //lines on db > itens / view 

			if($count_wld % $wcount == 0){ //exactly div

		  		$div_nv_tw = $count_wld / $wcount; //qtd pgs

			}else{ //no exactly div

		  		$div_nv_tw_no_exactly = $count_wld % $wcount;
		  		$div_nv_tw = ($count_wld - $div_nv_tw_no_exactly) / $wcount; //qtd pgs

			} 

		}else{ //lines on db < itens / view

			$div_nv_tw = 1;

		} 
		
		//echo $div_nv_tw." ".$pgwn; exit();
	
		$pgwn--;

		if($div_nv_tw >= $pgwn){

			$pgs_mode = "filter";
		
		}
		$pgwn++;

	}

}

//end

//start pagination methods script
if(isset($_POST['np'])){ //new number per page view / page setted

	if($str_id[0] == "w"){ //loterry card winners info -> reset initial values
		
		mysqli_query($con, "UPDATE user_config SET lt_wipg = '$pg_num', pgw = '1' WHERE id_user = '$idu'");	
		mysqli_query($con, "UPDATE user_config SET max_lwp = 'false', max_lwn = 'false' WHERE id_user = '$idu'");	
	
	}else if($str_id[0] == "n"){ //loterry table network info -> reset initial values
	
		mysqli_query($con, "UPDATE user_config SET lt_nipg = '$pg_num', pgn = '1' WHERE id_user = '$idu'");	
		mysqli_query($con, "UPDATE user_config SET max_lnp = 'false', max_lnn = 'false' WHERE id_user = '$idu'");
	
	}

	if($pg_id == "w-prev-w-d" || $pg_id == "w-next-w-d"){ //return itens / new day -> session

		$query_last_session = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id > 0 ORDER BY id DESC LIMIT 1");
		$ar_last_ts = mysqli_fetch_array($query_last_session);

		ini_set('display_errors', 0);
		$str_dt = $current_dt; 

		//month /day /year  
		$dt_dc = date('d'); // 
		$dt_mc = date('n'); //
		$dt_yc = date('y'); //

		$dt_d = $str_dt[3]."".$str_dt[4]; //day for select
		$dt_m = $str_dt[0]."".$str_dt[1]; //month for select
		$dt_y = $str_dt[6]."".$str_dt[7]."".$str_dt[8]."".$str_dt[9]; //year for select

		if($dt_y <= $dt_yc){

			if($dt_dc != 1 && $dt_d > $dt_dc && $dt_m > $dt_mc || $dt_dc != 1 && $dt_m > $dt_mc && $dt_y > $dt_yc || $dt_d != 1 && $dt_d > $dt_dc && $dt_y > $dt_yc){ 

				exit(); //for invalid data values

			}

			$dt_pass_t = $dt_d;	
		}

		if($pg_id == "w-prev-w-d"){ // -1 day 
			
			$dt_d -= 1;
		
		}else{ // + 1 day
		
			$dt_d += 1;
		
		}	
		
		if($dt_d <= 1){ //day == 1 / check next dates
			
			$ld_m = cal_days_in_month(CAL_GREGORIAN, $dt_m, $dt_y); // last dat of the month
			
			$dt_d = $ld_m;
			$m = $dt_m - 1;

			$dt_m = $m;

			if($m < 1){ //reajust year

				$dt_y = $dt_y - 1;
				$dt_m = "12";
		
			}
		
			$dt = $dt_m."/".$dt_d."/".$dt_y; //final date for search results

		}else{ //possible max day of the month
			
			$ld_m = cal_days_in_month(CAL_GREGORIAN, $dt_m, $dt_y); // last dat of the month
			
			if($dt_d >= $ld_m){

				$dt_d = "01";
				$m = $dt_m + 1;

				$dt_m = $m;

				if($m > 12){ //next year

					$d = "01";
					$m = "01";
					$md_y = $md_y + 1;

				}			

			}

			$dt = $dt_m."/".$dt_d."/".$dt_y; //final date for search results
			$pg_mode = $pg_id;

		}

	}else if($str_id[0] == "w"){ //for units per view choosed
 	
 		if($last_dt_on_db == ""){ //for last session closed == true

			$dt = $current_dt[0]."".$current_dt[1]."".$current_dt[2]."".$current_dt[3]."".$current_dt[4]."".$current_dt[5]."".$current_dt[6]."".$current_dt[7]."".$current_dt[8]."".$current_dt[9];
	
		}else{ //for != sessions -> session or days

			$dt = $last_dt_on_db;

		}

	}
	//end 

	//start get session id for day selected
	if(isset($dt) && $pg_id == "w-prev-w-d" || $pg_id == "w-next-w-d"){  //block for new winners search data
		
		$str_dt = base64_encode($dt);
		
		$str_dt0 = 1;
		$str_dt1 = 1;

		if($dt_pass_t > $dt){

			$query_last_session = mysqli_query($con, "SELECT * FROM loterry_winners WHERE data = '$str_dt' ORDER BY id DESC LIMIT 1");
			
			if($rd = mysqli_affected_rows($con) < 1){ //no find dates for return

				$str_dt0 = 0;

			}

		}else if($dt_pass_t < $dt){
		
			$query_last_session = mysqli_query($con, "SELECT * FROM loterry_winners WHERE data = '$str_dt' ORDER BY id ASC LIMIT 1");
		
			if($rd = mysqli_affected_rows($con) < 1){ //no find dates for return

				$str_dt0 = 0;

			}	
		
		}

		if($str_dt0 == 0){

			exit();

		}else{ //last session found

			$ar_ls_d = mysqli_fetch_array($query_last_session);
			$last_session_lt = $ar_ls_d['session_id'];

		}

		//echo $last_session_lt;
	
	}
	//end
	
}else if($pg_mode == "num-w" || $pg_id == "w-prev-w" || $pg_id == "w-next-w"){ //block for winners sys

	if($pg_id == "w-next-w" && $pgwn >= $ar_user['e_pg_w']){
		
		exit();
	
	}else if($pg_id == "w-next-w" && $pgwn < $ar_user['e_pg_w']){
	
		$pg_mode = "next";
	}
	
	if($pg_id == "w-prev-w" && $pgwn <= $ar_user['i_pg_w']){

		exit();

	}else if($pg_id == "w-prev-w" && $pgwn > $ar_user['i_pg_w']){

		$pg_mode = "prev";
	} 

	if($pg_mode == "num-w" && $pgwn >= $ar_user['i_pg_w'] && $pgwn <= $ar_user['e_pg_w']){

		mysqli_query($con, "UPDATE user_config SET pgw = $num_pg WHERE id_user = '$idu'");	

	}else if($pg_mode == "num-w" && $pgwn < $ar_user['i_pg_w'] || $pg_mode == "num-w" && $pgwn > $ar_user['e_pg_w']){

		exit();
	
	}	

}else if($pg_mode == "num-n" || $pg_id == "n-prev-n" || $pg_id == "n-next-n"){ //block for network sys

	if($pg_id == "n-next-n"){
		
		//mysqli_query($con, "UPDATE user_config SET pgn = pgn + 1 WHERE id_user = '$idu'");	

		if($ar_user['max_lnp'] == "true"){ 
		
			mysqli_query($con, "UPDATE user_config SET max_lnp = 'false' WHERE id_user = '$idu'");
		
		}

		$pg_mode = "next";

	}else if($pg_id == "n-prev-n"){
	
		if($pgwn > 1){
			//mysqli_query($con, "UPDATE user_config SET pgn = pgn - 1 WHERE id_user = '$idu'");	
		}

		if($ar_user['max_lnn'] == "true"){
		
			mysqli_query($con, "UPDATE user_config SET max_lnn = 'false' WHERE id_user = '$idu'");
			//mysqli_query($con, "UPDATE user_config SET pgn = pgn - 1 WHERE id_user = '$idu'");	
		
		}

		$pg_mode = "prev";

	}else if($pg_mode == "num-n"){

		mysqli_query($con, "UPDATE user_config SET pgn = $num_pg WHERE id_user = '$idu'");	
	
	}	

}
//end

//start get / set user pg num pg qtd itens
$get_pg = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$idu'");
$ar_config = mysqli_fetch_array($get_pg);
//end

//start main arrays get / set ++
if($str_id[0] == "w"){ //start for loterry sys -> get / set info rel between tables

	if($pg_id != "w-prev-w-d" && $pg_id != "w-next-w-d"){ //last session for pagination 

		$dt_en = base64_encode($dt);
		$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id > 0 AND data = '$dt_en' ORDER BY id DESC LIMIT 1");
		$ar_check_session = mysqli_fetch_array($get_last_winners);
		
		$rec_session = "false";
		
		//start check divergencies between query return && session turn requested
		if($ar_check_session['session_id'] % 2 == 0 && $session_turn == "am"){ 
			
			$this_session_rec = $ar_check_session['session_id'] - 1;
			$rec_session = "true";

		}else if($ar_check_session['session_id'] % 2 == 0 && $session_turn == "pm"){

			$this_session_rec = $ar_check_session['session_id'];
			$rec_session = "true";

		}else if($ar_check_session['session_id'] % 2 == 1 && $session_turn == "pm"){
		
			$this_session_rec = $ar_check_session['session_id'] + 1;
			$rec_session = "true";
		
		}else if($ar_check_session['session_id'] % 2 == 1 && $session_turn == "am"){

			$this_session_rec = $ar_check_session['session_id'];
			$rec_session = "true";

		}
		//end

		//echo "s".$this_session_rec;
		if($rec_session == "true"){ //recheck for find 
			
			$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id > 0 AND data = '$dt_en' AND session_id = '$this_session_rec' ORDER BY id DESC LIMIT 1");
		
		}
		
		$get_last_session = mysqli_fetch_array($get_last_winners);
		$last_session_lt = $get_last_session['session_id'];
		$dt = base64_decode($get_last_session['data']);

	}
	
	$pg_id = $ar_config['pgw']; // pd_id = page number 
	$pg_num = $ar_config['lt_wipg']; //pg_num = itens per page

	if($pg_id != "w-prev-w-d" && $pg_id != "w-next-w-d"){ //for pagination mode

		$get_tkt_buy_list = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE current_session = '$last_session_lt'");

	}


	$lt = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt' ORDER BY id ASC");
	$rows_win = mysqli_num_rows($lt);

	if($last_session_lt % 2 == 0){
		$ls_str = "pm";
	}else{
		$ls_str = "am";
	}

	mysqli_query($con, "UPDATE user_config SET dt_w = '$dt' WHERE id_user = '$idu'"); //att last date searched

}else if($str_id[0] == "n"){ // for network table main table -> array for front end
	
	$pg_id = $ar_config['pgn'];
	$pg_num = $ar_config['lt_nipg'];

	$lt = mysqli_query($con, "SELECT * FROM network_list WHERE leader_id = '$idu' ORDER BY id ASC");
	$rows_win = mysqli_num_rows($lt);


}
//echo "r".$rows_win."l s".$last_session_lt;
//end

//start pagination calcs -> next prev 
if(!isset($_POST['np'])){

	if($pg_id > 1){ $ini_ishow = ($pg_id - 1) * $pg_num; }else{ $ini_ishow = $pg_id * $pg_num; }	

	if($pg_mode == "next" || $pg_mode == "num-w" || $pg_mode == "num-n"){

		if($str_id[0] == "w" && $pg_mode != "num-w"){
			
			if($pgwn == 1){

				$ini_ishow++;

			}
			
			if($pg_id > 1){
				$ini_ishow += $pg_num + 1;
			}	

		}

		if($str_id[0] == "w" && $pg_mode == "num-w"){
			
			if($pg_id == 1){

				$ini_ishow = 1;

			}
			
			if($pg_id > 1){

				$ini_ishow += 1;
				$pg_id--;

			}	

		}
		
		if($str_id[0] == "n" && $pg_mode != "num-n"){
					
			$ini_ishow = $ini_ishow + 1;
			
			if($pg_id > 1){
			
				$ini_ishow += $pg_num + 1;
				$pg_id--;

			}

		}

		if($str_id[0] == "n" && $pg_mode == "num-n"){
					
			$ini_ishow = $ini_ishow + 1;
		
			if($pg_id == 1){
				$ini_ishow = 1;
			}

			if($pg_id > 1){
			
				$ini_ishow += 1;
				$pg_id--;

			}

		}
		
		$max_ishow = $ini_ishow + $pg_num;
		$df_rows = $rows_win / ($pg_id * $pg_num);

		if($str_id[0] == "w"){
			$max_ishow--;
		}

		if($df_rows < 1){ //max limit exceeded

			if($str_id[0] == "n"){
				
				if($pg_id > 1){
					mysqli_query($con, "UPDATE user_config SET max_lnn = 'true' WHERE id_user = '$idu'");
				}else{
					//mysqli_query($con, "UPDATE user_config SET max_lnp = 'true' WHERE id_user = '$idu'");
				}
			
			}					
			
			if($str_id[0] != "n"){
				exit();
			}
			
		}else{

			$pg_now = $pgwn;

			if($str_id[0] == "w" && $pg_mode != "num-w" && $pg_now < $ar_user['e_pg_w']){	
				mysqli_query($con, "UPDATE user_config SET pgw = pgw + 1 WHERE id_user = '$idu'"); //pg winners added
			}else if($str_id[0] == "w" && $pg_mode != "num-w" && $pg_now > $ar_user['e_pg_w']){
				exit(); //max pg limit exceeded
			}

			if($str_id[0] == "n" && $pg_mode != "num-n" && $pg_now < $ar_user['e_pg_n']){
				mysqli_query($con, "UPDATE user_config SET pgn = pgn + 1 WHERE id_user = '$idu'"); //pg network added
			}else if($str_id[0] == "n" && $pg_mode != "num-n" && $pg_now > $ar_user['e_pg_n']){
				exit(); //max pg limit exceeded
			}

		}

	}else if($pg_mode == "prev"){

		if($pg_id > 1){
		
			if($str_id[0] == "w"){
				$ini_ishow = ($ini_ishow + 1) - $pg_num;
			}else{
				$ini_ishow = ($ini_ishow + 1) - $pg_num;
			}

			if($str_id[0] == "w"){
				$max_ishow = $ini_ishow + $pg_num - 1;
			}else{
				$max_ishow = $ini_ishow + $pg_num;
			}

		}else{

			$ini_ishow = 0;

			if(isset($pgs_mode)){
				$max_ishow = $pg_num;	
			}else{
				$max_ishow = $pg_num - 1;
			}

		}

		if($pgwn == 1){ //max limit exceeded

			if($str_id[0] == "n"){
				mysqli_query($con, "UPDATE user_config SET max_lnp = 'true' WHERE id_user = '$idu'");
			}

			exit();

		}else{

			if($str_id[0] == "w"){
				mysqli_query($con, "UPDATE user_config SET pgw = pgw - 1 WHERE id_user = '$idu'");	
			}
	
			if($pgwn > 1 && $str_id[0] == "n"){
				mysqli_query($con, "UPDATE user_config SET pgn = pgn - 1 WHERE id_user = '$idu'");		
			}
			
		}

	}

}else{

	if($pg_id == 1){
		$ini_ishow = 1;
		$max_ishow = $pg_num;
	}

}
//end

//start decision case exist page num choosed
$limit_ini = 1;
$ipg = $ini_ishow;

if(!isset($_POST['np'])){ //for prev next

	$ini_ishow_ini = $ini_ishow; 

}else if(isset($_POST['np'])){ //for page num choosed

	$ini_ishow_ini = $limit_ini;

	if(isset($_POST['fs']) && $_POST['fw'] != "fw-name" && $_POST['fs'] != "0" || $_POST['fw'] == "fw-name" && $_POST['fs'] != "" && $_POST['fs'] != " " && $_POST['fs'] != 0){

		$max_ishow += 1;

	}

}

$count = 1;
$ggd = 0;

$ar_lot_ini = array();
$ar_lot_end = array();
//end

//echo $pgs_mode." - ".$ini_ishow." - ".$max_ishow;

//start show itens by filter
if(isset($pgs_mode)){ 

	$f_count = 1;
	$lot = 0;
	$count_all = 1;
	$gd = 0;
	$ggd = 0;

	$ar_id = array();
	$ar_str = array();
	
	$count_lfm = 1;
	$r_ini_ishow = $ini_ishow - 1;
	
	if($fw == "fw-name"){
		
		$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
		$query_search0 = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
		$query_search1 = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");

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

		$num_rows_search = mysqli_num_rows($query_search);
		$v = 0;

		$str_ar_fs = str_split($_POST['fs']);
		$str_len_fs = strlen($_POST['fs']);

		while ($n < $num_rows_search) {
			
			$str_ar = str_split($ar_str[$n]);
			$str_len = strlen($ar_str[$n]);

			while($nn < $str_len_fs){
		
				while($nnn < $str_len){

					if($str_ar_fs[$nn] == $str_ar[$nnn]){ //name valid
						$v++;
					}

					$nnn++;

				}

				$nadd = $nn + 1;
				
				if($nadd >= $str_len_fs){
				
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

			//echo " ".$ar_id[$n]." ".$fs." ".$ar_str[$n];
		
			$n++;
		
		}
		//end

		//start get next ini count 
		$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE nick LIKE '%$fs%' AND session_id = '$last_session_lt'");
		
		if($ini_ishow > 1){
			
			while ($ar_win_get_l = mysqli_fetch_array($query_search)) {
							
				if($count_lfm % $r_ini_ishow == 0){

					$last_pg_added = $ar_win_get_l['id'];
					break;
				
				}

				$count_lfm++;
			
			}

		}else{

			$last_pg_added = 0;
		
		}
		//end 

		//start show data
		$cs = 0;
		
		while($ar_win = mysqli_fetch_array($query_search1)){ 

			//start add val ini lot end lot 
			$ar_lot = lot_ini_end($gd, $last_session_lt);
		   	$lot_ini = $ar_lot[0];
			$lot_end = $ar_lot[1];
			//end

			if($ar_id[$cs] != "0" && $ar_win['id'] == $ar_id[$cs] && $ar_win['id'] > $last_pg_added){ 

				if($ipg <= $max_ishow && $count_all >= $ini_ishow){ ?>
			    <div class="col-xl-3 col-md-6" id="<?php echo $f_count."-".$ls_str.""."-dt-".$dt; ?>">
					<div class="card bg-theme text-white mb-1">
					  	<div class="card-body" id="dt-<?php echo $f_count; ?>">
					      <div>
					        <p style="float: left;padding: 0px;margin: 0px;"><?php echo $ar_win['nick']; ?></p>
					        <p style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a class="text-muted" href="#"><?php echo $lot_ini." - ".$lot_end; ?></a></p>
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
				<?php $f_count++; $ipg++;
		  		
				}else{

					break;
				}

			}

			$gd++;
			$count_all++;
			$cs++;

		}
		//end

		//mysqli_query($con, "UPDATE user_config SET id_lname_f = '1' WHERE id_user = '$idu'");

	}else if($fw == "fw-lot"){	
		
		//start get num lot min - max
		$n1n2 = lot_return_ini_end($fs);
		
		$n1 = $n1n2[0];
		$n2 = $n1n2[1];
		$nn2 = $n2 + 1;
		//end

		//start
		$get_tkt_buy_list = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
		$num_rows = mysqli_num_rows($get_tkt_buy_list);
		//end

		if($rw = mysqli_affected_rows($con) >= 1){
		
			$count_lot = 1;
			$gd = 0;
			$ipg = 0;

			while ($ar_win = mysqli_fetch_array($get_tkt_buy_list)) { 

				//start add val ini lot end lot 
			   	$nn2 = $n2 + 1;

			    $ar_lot = lot_ini_end($gd, $last_session_lt);
			   	$lot_ini = $ar_lot[0];
				$lot_end = $ar_lot[1];
			   	//end

			   	//start show data
		   		if($ipg < $pg_num && $count_lot >= $ini_ishow && $lot_ini >= $n1 && $lot_end <= $nn2){ ?>
					
					<div class="col-xl-3 col-md-6">
						<div class="card bg-theme text-white mb-1">
						  	<div class="card-body" style="">
						      <div>
						        <p style="float: left;padding: 0px;margin: 0px;"><?php echo $ar_win['nick']; ?></p>
						        <p style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a class="text-muted" href="#"><?php echo $lot_ini." - ".$lot_end; ?></a></p>
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
			
				<?php $ipg++; } $count_lot++; $gd++; 
			
			}
			//end
		}

	}else if($fw == "fw-tickets"){

		$query_search0 = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
		$query_search1 = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");
		
		//start get next ini count 
		$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE total_ticket = '$fs' AND session_id = '$last_session_lt'");
		
		if($ini_ishow > 1){
			
			while ($ar_win_get_l = mysqli_fetch_array($query_search)) {
							
				if($count_lfm % $r_ini_ishow == 0){

					$last_pg_added = $ar_win_get_l['id'];
					break;
				
				}

				$count_lfm++;
			
			}

		}else{

			$last_pg_added = 0;
		
		}
		//end 

		//start show data
		while($ar_win = mysqli_fetch_array($query_search1)){ 

			//start init end lot
			$ar_lot = lot_ini_end($gd, $last_session_lt);
		   	$lot_ini = $ar_lot[0];
			$lot_end = $ar_lot[1];
			//end
	
			if($ar_win['total_ticket'] == $fs && $ar_win['id'] > $last_pg_added){ 
			 	
			    if($ipg <= $max_ishow && $count_all >= $ini_ishow){ ?>
			    <div class="col-xl-3 col-md-6" id="<?php echo $f_count."-".$ls_str.""."-dt-".$dt; ?>">
					<div class="card bg-theme text-white mb-1">
					  	<div class="card-body" id="dt-<?php echo $f_count; ?>">
					      <div>
					        <p style="float: left;padding: 0px;margin: 0px;"><?php echo $ar_win['nick']; ?></p>
					        <p style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a class="text-muted" href="#"><?php echo $lot_ini." - ".$lot_end; ?></a></p>
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
				<?php $f_count++; $ipg++;
				
				}else{
				
					break;
				
				}

			}

			$gd++;
			$count_all++;

		}
		//end
	
	}

	exit(); //pgs mode filter success

}
//end

//start ajust init lot count (for winners)
if($str_id[0] == "w"){
	
	if($pgwn > 1 && $pg_mode == "next"){
		$ggd = (($pgwn - 1) * $ar_user['lt_wipg']) - 1;
	}else{
		$ggd = 0;
	}

}
//end

//start count id page view (for network)
$get_user_pg_n = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$idu'");
$ar_user_pg_n = mysqli_fetch_array($get_user_pg_n);

if($pg_mode == "num-n"){ $pgn = $num_pg; }else{ $pgn = $ar_user_pg_n['pgn']; }

if($pg_mode == "num-n"){ $ini_id_count = ($pgn * $pg_num) - $pg_num; }else{ 

	if($pg_mode == "prev"){

		if($pgn == 1){ $ini_id_count = "0"; }else{ $ini_id_count = ($pgn * $pg_num) - $pg_num; }
	
	}else if($pg_mode == "next"){ $ini_id_count = ($pgn * $pg_num) - $pg_num; }

}
//end

//start return on front end -> data -> loterry and network info
while($ar_win = mysqli_fetch_array($lt)){ 
	
	if($str_id[0] == "w"){
		
		//start init end lot
		$ar_lot = lot_ini_end($ggd, $last_session_lt);
   		$lot_ini = $ar_lot[0];
		$lot_end = $ar_lot[1];
		//end
	
	}

	if(isset($_POST['np']) && $ini_ishow <= $max_ishow || !isset($_POST['np']) && $ini_ishow < $max_ishow){
		
		if($str_id[0] == "n" && $ini_ishow <= $max_ishow && $limit_ini >= $ini_ishow_ini){ $ini_ishow++; }

	}else{ break; }

	if($limit_ini >= $ini_ishow_ini && $str_id[0] == "w" && $ipg <= $max_ishow){ //return loterry data ?>
	<div class="col-xl-3 col-md-6" id="<?php echo $count."-".$ls_str.""."-dt-".$dt; ?>">
		<div class="card bg-theme text-white mb-1">
		  	<div class="card-body" id="dt-<?php echo $count; ?>">
		      <div>
		        <p style="float: left;padding: 0px;margin: 0px;"><?php echo $ar_win['nick']; ?></p>
		        <p class="text-light" style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a href="#" class="text-light"><a href="#" class="text-muted"><?php echo $lot_ini." - ".$lot_end; ?></a> <i aria-hidden="true" class="fa fa-cubes fa-1x text-light"></i></p>
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
	<?php $ipg++; }else if($limit_ini >= $ini_ishow_ini && $str_id[0] == "n"){ //return network data 
	if($pgn <= 1){ $count_id = $count; }else{ $count_id = $ini_id_count + $count; } ?>
	<?php $mode_theme_text_pgs = text_color(); ?>
	<tr>
		<th scope="row">
			<a href="#pos_ref" class="id_ref text-muted"><?php echo $count_id; ?></a>
		</th>
		<td>
			<a href="?ref_name=<?php echo $ar_win['nome_ref']; ?>" class="name_ref <?php echo $mode_theme_text_pgs[0]; ?>"><?php echo $ar_win['nome_ref']; ?></a>
		</td>
		<td>
			<a href="#ref_level" class="level_ref text-muted"><?php echo $ar_win['level_ref']; ?></a>
		</td>
		<td>
			<a href="#ref_date" class="date_ref text-muted"><?php echo $ar_win['started_ref']; ?></a>
		</td>
		<td>
			<a href="#up_name_ref" class="up_ref <?php echo $mode_theme_text_pgs[0]; ?>"> <?php echo $ar_win['leader_ref']; ?></a>
		</td>
		<td>
			<a href="#status_ref" class="status_ref <?php echo $mode_theme_text_pgs[0]; ?>"><?php echo $ar_win['status_ref']; ?></a>
		</td>
		<td>
			<a href="?earns_ref=<?php echo $ar_win['nome_ref']; ?>" class="cv earns_ref text-muted"><?php echo $ar_win['earns_ref']; ?></a>
		</td>
		<td>
			<a href="#actions" class="activity_ref text-muted"><?php echo $ar_win['activity_ref']; ?></a>
		</td>
	</tr>
	<?php $count++; if($str_id[0] == "n" && $ini_ishow > $max_ishow && $limit_ini >= $ini_ishow_ini){ break; } 
	} 

$limit_ini++; $ggd++; } } ?>
