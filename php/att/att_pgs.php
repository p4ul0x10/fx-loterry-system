<?php
include $_SERVER['DOCUMENT_ROOT']."/php/lt/pgs-functions.php";

$host =$_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}
	
include_once "../conn.php";

session_start();
$email = $_SESSION['email'];

$get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
$array_user = mysqli_fetch_array($get_user);

$id_user = $array_user['id'];

$get_user_config = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id_user'");
$array_user_config = mysqli_fetch_array($get_user_config);

$en_data_lwin = base64_encode($array_user_config['dt_w']);

$pg_mode = $_POST['pg_mode'];

$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1 AND data = '$en_data_lwin'");

if(!isset($_POST['status'])){ //info no status

	$count_wld = $_POST['max_wi'];
	$wcount = $_POST['iview'];
	
	if($pg_mode == "w"){ //for winners
		$npv = $array_user_config['lt_wipg'];
		$pg = $array_user_config['pgw'];
		$last_dt_win = $array_user_config['dt_w'];
		
		$count_wld = mysqli_num_rows($get_last_winners);
		$wcount = $npv;
	}

}else{ //info winners att 
	
	$status = $_POST['status'];
	$f_t = $_POST['f_t'];
	$f_v = $_POST['f_v'];

	$user = $_SESSION['email'];
	
	if($pg_mode == "w"){
		$npv = $array_user_config['lt_wipg'];
		$pg = $array_user_config['pgw'];
		$last_dt_win = $array_user_config['dt_w'];
	}

	if($status == 1){

		$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1 AND data = '$en_data_lwin' ORDER BY id DESC LIMIT 1");

		$get_last_session = mysqli_fetch_array($get_last_winners);	
		$last_session_lt = $get_last_session['session_id'];

		if($f_t == "fw-name"){
			
			$query_search = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt' AND nick LIKE '%$f_v%'");
			$count_wld = mysqli_num_rows($query_search);
			$wcount = $npv;

		}else if($f_t == "fw-lot"){	

			//start get num lot min - max
			$n1n2 = lot_return_ini_end($f_v);
			
			$n1 = $n1n2[0];
			$n2 = $n1n2[1];
			//end 

			$get_tkt_buy_list = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt'");

			$rc = 0;
			$num_rows = mysqli_num_rows($get_tkt_buy_list);

			$array_id_lt = array();
			$array_value_lt = array();

			$lot = 1;
			$wcount = $npv; 
			$count_v = 0;

			while ($r = mysqli_fetch_array($get_tkt_buy_list)) {

			  	if($r['total_ticket'] >= $n1 && $r['total_ticket'] <= $n2){
			  		$count_v++;
			  	}

			  	$rc++;

			}

			$count_wld = $count_v;

		}else if($f_t == "fw-tickets"){

			$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE total_ticket = '$f_v'");

			$count_wld = mysqli_num_rows($get_last_winners);
			$wcount = $npv;

		}

	}else{

		$count_wld = mysqli_num_rows($get_last_winners);
		$wcount = $npv;
	}

}

$bg_theme = $_POST['bg_theme'];
$div_nv_tw_no_exactly = false;

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

if($pg_mode == "w"){

	if(isset($_POST['iview']) && $_POST['iview'] <= 100 && $_POST['iview'] > 0){
		if($_POST['iview'] == 12 || $_POST['iview'] == 24 || $_POST['iview'] == 48 || $_POST['iview'] == 100){
			$pg_num = $_POST['iview'];
			mysqli_query($con, "UPDATE user_config SET lt_wipg = '$pg_num', pgw = '1' WHERE id_user = '$id_user'");
		}else{
			exit();
		}

	}

?>
<li class="page-item page-pre">
   	<a class="ppage-nnw page-link bg-theme bc-theme text-light" aria-label="previous page" href="javascript:void(0)" id="w-prev-w" onclick="pgs(id)">‹</a>
</li>
<?php
for ($i = 0; $i < $div_nv_tw; $i++){ 
$ii = $i + 1; 
?>
<li class="page-item">
<?php if($i == 0){ ?>
	<a id ="w<?php echo $ii; ?>" class="page-nnw page-link bc-theme color-theme <?php echo $bg_theme; ?>" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "w".$ii; ?>')"><?php echo $ii; ?></a>
<?php }else{ ?>
	<a id ="w<?php echo $ii; ?>" class="page-nnw page-link bg-theme bc-theme text-light" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "w".$ii; ?>')"><?php echo $ii; ?></a>
<?php } ?>
</li>  
<?php } if($div_nv_tw_no_exactly != false){ $ii += 1; //rest div / page limit ?>
<li class="page-item">
<a id ="w<?php echo $ii; ?>" class="page-nnw page-link bg-theme bc-theme text-light" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "w".$ii; ?>')"><?php echo $ii; ?></a>
</li>
<?php } ?>
<li class="page-item page-next">
	<a class="npage-nnw page-link bg-theme bc-theme text-light" aria-label="next page" href="javascript:void(0)" id="w-next-w" onclick="pgs(id)">›</a>
</li> 
<?php 
}else{ ?>
<li class="page-item page-pre">
    <a class="ppage-nnn page-link bg-theme bc-theme text-light" aria-label="previous page" href="javascript:void(0)" id="n-prev-n" onclick="pgs(id)">‹</a>
</li>	
<?php
for ($i = 0; $i < $div_nv_tw; $i++){ 
	$ii = $i + 1; 
?>
<li class="page-item">
<?php if($i == 0){ ?>
<a id ="n<?php echo $ii; ?>" class="page-nnn page-link bc-theme color-theme <?php echo $bg_theme; ?>" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "n".$ii; ?>')"><?php echo $ii; ?></a>
<?php }else{ ?>
<a id ="n<?php echo $ii; ?>" class="page-nnn page-link bg-theme bc-theme text-light" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "n".$ii; ?>')"><?php echo $ii; ?></a>
<?php } ?>
</li>  
<?php } 
if($div_nv_tw_no_exactly != false){ $ii += 1; //rest div / page limit ?>	
<li class="page-item">
<a id ="n<?php echo $ii; ?>" class="page-nnn page-link bg-theme bc-theme text-light" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "n".$ii; ?>')"><?php echo $ii; ?></a>
</li>
<?php } ?>
<li class="page-item page-next">
<a class="npage-nnn page-link bg-theme bc-theme text-light" aria-label="next page" href="javascript:void(0)" id="n-next-n" onclick="pgs(id)">›</a>
</li>

<?php } 
if($div_nv_tw_no_exactly != false){ $end_pg = $div_nv_tw + 1; }else{ $end_pg = $div_nv_tw; } 

if($pg_mode == "w"){
	mysqli_query($con, "UPDATE user_config SET i_pg_w = '1', e_pg_w = '$end_pg' WHERE id_user='$id_user'");
}else if($pg_mode == "n"){
	mysqli_query($con, "UPDATE user_config SET i_pg_n = '1', e_pg_n = '$end_pg' WHERE id_user='$id_user'");
} ?>