<?php
function theme_mode_color_d($in){

	include "../conn.php";
	session_start();
	$email = $_SESSION['email'];

	$ar_theme_tables = array();
	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				if($in == "tables"){
					$table = "table-light";
					$text = "color-theme";
				}else{
					$text = "light";
				}

			}else if($get_user['conf_theme'] == "dark"){
			
				if($in == "tables"){
					$table = "table-dark";
					$text = "light";
				}else{
					$text = "dark";
				}
			}
		}
	}

	$ar_theme_tables[0] = $table;
	$ar_theme_tables[1] = $text;
	$ar_theme_tables[2] = $id;

	$in = $ar_theme_tables;
	
	return $in;
}

$table_color = theme_mode_color_d("tables");
$table_c = $table_color[0];
$table_t = $table_color[1];
$id_u = $table_color[2];

include "../conn.php";

$wd = $_POST['wd'];

if(!is_numeric($wd)){
	exit();
}

if($wd >= 990){

	if($wd < 1200){
		$wd = "t";
		$wrap_mode = "flex-wm";
	}else{
		$wd = "d";
	}

}else if($wd < 990){

	$wd = "m";
	$wrap_mode = "flex-w"; //smartphone show

}

if($wd == "d"){

	$get_extrato_end = mysqli_query($con, "SELECT * FROM saque WHERE id_user='$id_u' ORDER BY id DESC LIMIT 5");
	echo "<table class='tbd table table-striped ".$table_c."'>
		<thead class='".$table_t."'>
			<th>Id</th>
			<th>Valor</th>
			<th>Coin</th>
			<th>Net</th>
			<th>Date <a href='#' id='dep_data' onclick='filter(2)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
			<th>Plan <a href='#' id='dep_plan'><i class='fa fa-dep-modal fa-sort-desc text-muted' aria-hidden='true'></i></a></th>
			<th>Status <a href='#' id='dep_status' onclick='filter(3)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
			<th id='hms-f'>Time left</th>
		</thead><tbody class='tbody-dep-list ".$table_t."' style='font-size:13.5px;'>";
		$i=0;
	while ($list=mysqli_fetch_array($get_extrato_end)) {

		$this_dep = $list['id'];
		$tx = $list['tx'];
		$id_with = $list['con_with'];
		$time_left = $list['hms'];

		$get_coin = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE id_charnum='$id_with'");
				
		if($row_coin = mysqli_affected_rows($con) >= 1){
			
			$array_rel = mysqli_fetch_array($get_coin);

			if($id_with == $array_rel['id_charnum']){

				$coin = $array_rel['coin'];
				$cod_with = $array_rel['id_charnum'];
				$type_out = $array_rel['type_out'];
			}

		}	

		//start
		if($list['status'] == 0) {
			$status = "<td class='text-success'>Pending</td>";
			$btn = "<i class='fa fa-usd fa-2x ac-pay-dep' title='pay plan num ".$cod_with."' aria-hidden='true' id='con-".$cod_with."' onclick='ac_pay_dep(id);'></i>
				<i id='".$cod_with."' class='fa fa-window-close fa-2x ac-rm-dep' title='remove ".$cod_with."' aria-hidden='true'  onclick='rm_dep_m_d(id);'></i>";					
			$payment_dep = "<a href='#waiting' title='deposit ".$cod_with." payment'>Link</a>";
			$add_payments = "tr-with";
		}
		
		if($list['status'] == 1){
			$status = "<td class='text-primary'>Completed</td>";
			$payment_dep = "<a href='".$url_tx."".$tx."' target='_new' title='withdraw ".$cod_with." payment'>Link</a>";
			$btn = "<i class='fa fa-check-square fa-2x ac-pd-dep' title='".$cod_with." paid' aria-hidden='true'></i>";
			$add_payments = "tr-verify";
		}

		if($coin == "btc"){
			$coin_img = "<img class='img-action-sm'src='images/coins/btc-sm.png' title='bitcoin' width='26px' height='26px' alt='btc coin deposited'>";
		}else if($coin == "usdt"){
			$coin_img = "<img class='img-action-sm' src='images/coins/usdt-sm.png' title='tether' width='26px' height='26px' alt='usdt coin deposited'>";
		}else if($coin == "tron"){
			$coin_img = "<img class='img-action-sm' src='images/coins/trx-sm.png' title='tron' width='26px' height='26px' alt='tron coin deposited'>";
		}else if($coin == "bnb"){
			$coin_img = "<img class='img-action-sm' src='images/coins/busd-sm.png' title='binance' width='26px' height='26px' alt='bnb coin deposited'>";
		}else if($coin == "eth"){
			$coin_img = "<img class='img-actions-sm' src='images/coins/eth-sm.png' title='ethereum' width='26px' height='26px' alt='eth coin deposited'>";
		}else if($coin == "ltc"){
			$coin_img = "<img class='img-actions-sm' src='images/coins/ltc-sm.png' title='litecoin' width='26px' height='26px' alt='ltc coin deposited'>";
		}else if($coin == "pix"){
			$coin_img = "<img class='img-actions-sm' src='images/coins/pix.png' title='pix' width='26px' height='26px' alt='pix deposited'>";
		}
		
		//start get time hours, min, seconds
		$hms = $time_left;
		//end

		echo "<tr class='".$add_payments." dep-list dl".$i."' id='tr".$cod_with."'>
			<td class=".$table_t.">".$cod_with."</td>
			<td class='cv dep-amount ".$table_t."'>".$list['quantidade']."</td>
			<td class='".$table_t."'>".$coin_img."</td>
			<td class='".$table_t."'>".$list['proto']."</td>
			<td class='".$table_t."' style='font-size: 10px;'>".$list['data']."</td>
			<td class='".$table_t."'>".$type_out."</td>
			".$status."
			<td id='tm".$cod_with."' class='hms-with-p ".$table_t."'>".$hms."</td>
		</tr>";
		$i++;
	}

	echo "</tbody></table>";

}else if($wd == "m" && isset($wrap_mode)){

	//start get color theme
	$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id_u'");

	if($row_true = mysqli_affected_rows($con) >= 1){
	
		$get_user = mysqli_fetch_array($get_theme);
		
		if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

			$bg_color = "bg-light";
			$text_color = "color-theme";
			$btn_text_color = "color-theme";

		}else if($get_user['conf_theme'] == "dark"){
		
			$bg_color = "bg-dark";
			$text_color = "text-light";
			$btn_text_color = "color-theme";

		}

	}
	//end

	$get_extrato_end = mysqli_query($con, "SELECT * FROM saque WHERE id_user='$id_u' ORDER BY id DESC LIMIT 5");

	$i=0;

	while ($list=mysqli_fetch_array($get_extrato_end)) {

		$this_dep = $list['id'];
		$tx = $list['tx'];
		$id_with = $list['con_with'];
		$time_left = $list['hms'];

		$get_coin = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE id_charnum='$id_with'");
			
		if($row_coin = mysqli_affected_rows($con) >= 1){
		
			$array_rel = mysqli_fetch_array($get_coin);

			if($id_with == $array_rel['id_charnum']){

				$coin = $array_rel['coin'];
				$cod_with = $array_rel['id_charnum'];
				$type_out = $array_rel['type_out'];

			}

		}	

		//start
		$get_proto = mysqli_query($con, "SELECT * FROM net_protos WHERE id_dep = '$id_dep'");

		if($row_proto = mysqli_affected_rows($con) >= 1){

			$array_proto = mysqli_fetch_array($get_proto);
			$proto = $array_proto['net'];
		
			if($proto == "btc"){
				$url_tx = "https://www.blockchain.com/pt/explorer/transactions/btc/";
			}else if($proto == "btc-bep20"){
				$url_tx = "https://www.bscscan.com/tx/";
			}else if($proto == "segwit"){
				$url_tx = "https://www.blockchain.com/pt/explorer/transactions/btc/";
			}else if($proto == "eth-erc20"){
				$url_tx = "https://etherscan.io/tx/";
			}else if($proto == "eth-bep20"){
				$url_tx = "https://www.bscscan.com/tx/";
			}else if($proto == "trx-trc20"){
				$url_tx = "https://tronscan.org/#/transaction/";
			}else if($proto == "trx-bep20"){
				$url_tx = "https://etherscan.io/tx/";
			}else if($proto == "ltc"){
				$url_tx = "https://live.blockcypher.com/ltc/tx/";
			}else if($proto == "ltc-bep20"){
				$url_tx = "https://www.bscscan.com/tx/";
			}else if($proto == "bnb-bep20"){
				$url_tx = "https://www.bscscan.com/tx/";
			}else if($proto == "tether-erc20"){
				$url_tx = "https://etherscan.io/tx/";
			}else if($proto == "tether-bep20"){
				$url_tx = "https://www.bscscan.com/tx/";
			}

		}
		//end

		//start
		if($list['status'] == 0) {	
			$status = "<p class='text-danger mb-0'>Pending</p>";
			$add_payments = "tr-with";
		}
			
		if($list['status'] == 1){
			$status = "<p class='text-primary mb-0'>Completed</p>";
			$add_payments = "tr-verify";
		}

		if($coin == "btc"){
			$coin_img = "<img class='img-action-sm'src='images/coins/btc-sm.png' title='bitcoin' width='20px' height='20px' alt='btc coin deposited'>";
		}else if($coin == "usdt"){
			$coin_img = "<img class='img-action-sm' src='images/coins/usdt-sm.png' title='tether' width='20px' height='20px' alt='usdt coin deposited'>";
		}else if($coin == "tron"){
			$coin_img = "<img class='img-action-sm' src='images/coins/trx-sm.png' title='tron' width='20px' height='20px' alt='tron coin deposited'>";
		}else if($coin == "bnb"){
			$coin_img = "<img class='img-action-sm' src='images/coins/busd-sm.png' title='binance' width='20px' height='20px' alt='bnb coin deposited'>";
		}else if($coin == "eth"){
			$coin_img = "<img class='img-actions-sm' src='images/coins/eth-sm.png' title='ethereum' width='20px' height='20px' alt='eth coin deposited'>";
		}else if($coin == "ltc"){
			$coin_img = "<img class='img-actions-sm' src='images/coins/ltc-sm.png' title='litecoin' width='20px' height='20px' alt='ltc coin deposited'>";
		}else if($coin == "pix"){
			$coin_img = "<img class='img-actions-sm' src='images/coins/pix.png' title='pix' width='20px' height='20px' alt='pix deposited'>";
		}

		if($list['type_dep'] == "Founds"){
			$time_h = 48;
		}else{
			$time_h = 12;
		}

		//start get time hours, min, seconds
		$hms = $time_left;
		//end
 	?>
	<div id="dw-<?php echo $i; ?>" class="card pw-card card-<?php echo $cod_with; ?>" style="width: 100%;">
	  <div class="card-body <?php echo $bg_color; ?>">
	    <div class="fluid-container">
	      <div class="col-mb-with-h row">
			<div class="col-sm-12">
		      <span class="float-left color-theme">#<?php echo $cod_with; ?></span>
		      <span class="<?php echo $text_color; ?>">Value: <a href="#" class="text-muted"><?php echo "$ ".$list['quantidade']; ?></a> <i class="fa fa-angle-down text-danger" aria-hidden="true"></i></span>
		      <span class="float-right"><?php echo $status; ?></span>
		      <div class="row mt-3 p-dvm-<?php echo $cod_with; ?>" style="display: none;">
		        <div class="col-12 col-sm-12 col-10-<?php echo $cod_with; ?>">
		      	  <div class="row row-flex <?php echo $wrap_mode; ?>">
					<ul class="ul-dep" style="display: flex !important; margin: 0px auto; font-size: 15px;">		
	      			  <li class="nav-item <?php echo $text_color; ?>">
	      				Value: <a href="#" id="val-<?php echo $cod_with; ?>" class="nav-link text-muted"><?php echo "$ ".$list['quantidade']; ?> in <?php echo $coin_img; ?></a>
	      		      </li>
	      			  <li class="nav-item <?php echo $text_color; ?>">
	      				Net: <a href="#" class="nav-link text-muted" id='net-proto<?php echo $cod_with; ?>'><?php echo $list['proto']; ?></a>
	      			  </li>
	      			</ul>
	      			<ul class="ul-dep mt-3" style="display: flex !important; margin: 0px auto; font-size: 15px;">
	      			  <li class="nav-item <?php echo $text_color; ?> mr-3" style="display: block ruby;">
	      				Date: <a href="#" class="nav-link text-muted" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;"><?php echo $list['data']; ?></a>
	      			  </li>
	      			  <li class="nav-item <?php echo $text_color; ?> " style="display: block ruby;">
	      				Time left: <a href="#" class="nav-link text-muted hms-with-p" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;"><?php echo $hms; ?></a>
	      			  </li>
	      			</ul>
		      	  </div>
		        </div>
		      </div>
			</div>
		  </div>
	    </div>
	  </div>
	</div>
	<?php $i++;
	}
			
}
?>
<script type="text/javascript">
	$(".pw-card").on('click', function(){
               
  	  str_class = $(this).attr("class");
      str_class_replace = str_class.replace("card pw-card card-", "");
  		
  	  dv_id = $(this).attr("id");
  	  str_dv_id = dv_id.replace("dw-", "");

      $(".p-dvm-"+str_class_replace+":eq("+str_dv_id+")").toggle();

      dv_s = $(".p-dvm-"+str_class_replace+":eq("+str_dv_id+")").css("display");
    
      if(dv_s == "none"){
        $(".card-"+str_class_replace+":eq("+str_dv_id+") .card-body .fluid-container .col-mb-with-h .col-sm-12 hr").remove();
	  }else{
  	    $(".card-"+str_class_replace+":eq("+str_dv_id+") .card-body .fluid-container .col-mb-with-h .col-sm-12 span:eq(2)").after("<hr>");
	  }

	});
</script>