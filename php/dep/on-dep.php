<?php

include "../conn.php";

session_start();

$email = $_SESSION['email'];
$mode_show = $_POST['type_show'];
$display_w = $_POST['modal_type'];

echo $_GET['withdraws'];

//start defaults sets
$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");

while ($idu = mysqli_fetch_array($get_usr)) {
	$id = $idu['id'];
}

$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");

if($row_true = mysqli_affected_rows($con) >= 1){

	$get_user = mysqli_fetch_array($get_theme);
	
	if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

		if($display_w == "desktop"){

			$table_color = "table-light";
			$text_color = "color-theme";
		
		}else if($display_w == "mobile"){
		
			$bg_color = "bg-light";
			$text_color = "color-theme";
			$btn_text_color = "color-theme";
		
		}

	}else if($get_user['conf_theme'] == "dark"){
	
		if($display_w == "desktop"){
		
			$table_color = "table-dark";
			$text_color = "text-light";
		
		}else if($display_w == "mobile"){
		
			$bg_color = "bg-dark";
			$text_color = "text-light";
			$btn_text_color = "color-theme";
		
		}

	}

}
//end

if($mode_show != "withdraws"){

	//start get page num
	if(isset($_GET['pg_dep']) && $_GET['pg_dep'] > 1){
		$pg_now = $_GET['pg_dep'];
	}else{
		$pg_now = 99999999;
	}
	//end

}else if($mode_show == "withdraws"){

	//start get page num
	if(isset($_GET['pg_with']) && $_GET['pg_with'] > 1){
		$pg_now = $_GET['pg_with'];
	}else{
		$pg_now = 99999999;
	}
	//end

}

if($display_w == "mobile"){ //mobile modals -> show

	$wrap = $_POST['wrap'];

	if($wrap == "initial"){ //tablet show
		$wrap_mode = "flex-wm";
	}else{
		$wrap_mode = "flex-w"; //smartphone show
	}

	if($mode_show == "dep-packages"){

		$md = "'modal-dep'";
		$get_dep = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' ORDER BY id DESC");
		
		$num_rows_dep = mysqli_num_rows($get_dep);
		$ar_deps = mysqli_fetch_array($get_dep);
		
		if($pg_now != 99999999){

			$rec_pg = ($pg_now - 1) * 5;
			
			$ini_pg = 1;			
			$checked = false;

			while($ar_dep = mysqli_fetch_array($ar_deps)){

				if($ini_pg >= $rec_pg){

					$ini_pos = $ar_dep['id'];
					break;

				}
				
				$ini_pg++;
			
			}			
		
		}else{

			$ini_pos = 99999999;

		}
		//
		
		$get_extrato = mysqli_query($con, "SELECT * FROM deposits WHERE id < '$ini_pos' AND id_user = '$id' ORDER BY id DESC LIMIT 5");
		
		if($r = mysqli_affected_rows($con) >= 1){
		
			while($list=mysqli_fetch_array($get_extrato)) {

				$this_dep = $list['id'];
				$get_coin = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep='$this_dep'");
				
				if($row_coin = mysqli_affected_rows($con) >= 1){

					while($array_rel = mysqli_fetch_array($get_coin)){

						$coin = $array_rel['coin'];
						$cod_dep = $array_rel['id_charnum'];
						$tx = $array_rel['tx'];
						$id_dep = $array_rel['id_dep'];

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
					}else if($proto == "arbitrum"){
						if($coin == "eth"){
								$url_tx = "https://optimistic.etherscan.io/tx/";
						}else if($coin == "usdt"){
								$url_tx = "https://optimistic.etherscan.io/tx/";
						}	
					}else if($proto == "avaxc"){
						if($coin == "eth"){
								$url_tx = "https://subnets.avax.network/c-chain/tx/";
						}else if($coin == "usdt"){
								$url_tx = "https://subnets.avax.network/c-chain/tx/";
						}	
					}
          
				}
				//end

				//start
				if($list['status'] == 0) {
					$status = "<p class='text-success'>Pending</p>";
					$btn = "<i class='fa fa-usd fa-2x ac-pay-dep ".$btn_text_color."' title='pay plan num ".$cod_dep."' aria-hidden='true' id='con-".$cod_dep."' onclick='ac_pay_dep(id);'></i>
						<i id='".$cod_dep."' class='fa fa-window-close fa-2x ac-rm-dep ".$btn_text_color."' title='remove ".$cod_dep."' aria-hidden='true' onclick='rm_dep_m_d(id);'></i>";					
					$payment_dep = "<a class='nav-link' href='#waiting' title='deposit ".$cod_dep." payment'>Link</a>";
					$add_payments = "tr-dep";
				}
				
				if($list['status'] == 1){
					$status = "<p class='text-primary'>Completed</p>";
					$payment_dep = "<a class='nav-link' href='".$url_tx."".$tx."' target='_new' title='deposit ".$cod_dep." payment'>Link</a>";
					$btn = "<i class='fa fa-check-square fa-2x ac-pd-dep ".$btn_text_color."' title='".$cod_dep." paid' aria-hidden='true'></i>";
					$add_payments = "";
				}

				if($coin == "btc"){
					$coin_img = "<img class='img-action-sm img-".$cod_dep."' src='images/coins/btc-sm.png' title='bitcoin' width='16px' height='16px' id='".$list['quantidade']."' alt='btc coin deposited'>";
				}else if($coin == "usdt"){
					$coin_img = "<img class='img-action-sm img-".$cod_dep."' src='images/coins/usdt-sm.png' title='tether' width='16px' height='16px' id='".$list['quantidade']."' alt='usdt coin deposited'>";
				}else if($coin == "tron"){
					$coin_img = "<img class='img-action-sm img-".$cod_dep."' src='images/coins/trx-sm.png' title='tron' width='16px' height='16px' id='".$list['quantidade']."' alt='tron coin deposited'>";
				}else if($coin == "bnb"){
					$coin_img = "<img class='img-action-sm img-".$cod_dep."' src='images/coins/busd-sm.png' title='binance' width='16px' height='16px' id='".$list['quantidade']."' alt='bnb coin deposited'>";
				}else if($coin == "eth"){
					$coin_img = "<img class='img-actions-sm img-".$cod_dep."' src='images/coins/eth-sm.png' title='ethereum' width='16px' height='16px' id='".$list['quantidade']."' alt='eth coin deposited'>";
				}else if($coin == "ltc"){
					$coin_img = "<img class='img-actions-sm img-".$cod_dep."' src='images/coins/ltc-sm.png' title='litecoin' width='16px' height='16px' id='".$list['quantidade']."' alt='ltc coin deposited'>";
				}else if($coin == "pix"){
					$coin_img = "<img class='img-actions-sm img-".$cod_dep."' src='images/coins/pix.png' title='pix' width='16px' height='16px' id='".$list['quantidade']."' alt='pix deposited' >";
				}
			?>
		<div class="card card-<?php echo $cod_dep; ?>" style="width: 100%;">
        <div class="card-body <?php echo $bg_color; ?>" style="padding: 1.25rem 1.25rem 0px 1.25rem;">
          <!--<h5 class="card-title">Card title</h5>
          <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
        <div class="fluid-container">
          <div class="col-mb-dep-h row">
				<div class="col-sm-12">
				    <span class="float-left color-theme">#<?php echo $cod_dep; ?></span>
				    <span class="float-right"><?php echo $status; ?></span>
				    <br>
				    <hr>
				    <div class="row mt-3">
				      <div class="col-btn-m-<?php echo $cod_dep; ?> col-2 col-sm-2">
				        <?php echo $btn; ?>
				      </div>
				      <div class="col-10 col-sm-10 col-10-<?php echo $cod_dep; ?>">
				      	<div class="row row-flex <?php echo $wrap_mode; ?>">
									<ul class="ul-dep" style="display: flex !important;">					      		
			      				<li class="nav-item <?php echo $text_color; ?>">
			      					Plan: <a href="#" class="nav-link text-muted"><?php echo $list['type_dep']; ?></a>
			      				</li>
			      				<li class="nav-item <?php echo $text_color; ?>">
			      					Value: <a href="#" id="val-<?php echo $cod_dep; ?>" class="nav-link text-muted"><?php echo "$ ".$list['quantidade']; ?> in <?php echo $coin_img; ?></a>
			      				</li>
			      				<li class="nav-item <?php echo $text_color; ?>">
			      					Tx: <?php echo $payment_dep; ?>
			      				</li>
			      			</ul>
			      			<ul class="ul-dep" style="display: flex !important;">
			      				<li class="nav-item <?php echo $text_color; ?>">
			      					Net: <a href="#" class="nav-link text-muted" id='net-proto<?php echo $cod_dep; ?>'><?php echo $proto; ?></a>
			      				</li>
			      				<li class="nav-item <?php echo $text_color; ?>">
			      					Date: <a href="#" class="nav-link text-muted"><?php echo $list['data']; ?></a>
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
      <?php
			}
			
		}

	}else if($mode_show == "dep-tickets"){
		
		$get_extrato = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id' ORDER BY id DESC");
		
		$num_rows_dep = mysqli_num_rows($get_extrato);
		$ar_extrato_t = mysqli_fetch_array($get_extrato);
		
		if($pg_now != 99999999){

			$rec_pg = ($pg_now - 1) * 5;
			
			$ini_pg = 1;			
			$checked = false;

			while($ar_dep = mysqli_fetch_array($get_extrato)){

				if($ini_pg >= $rec_pg){


					$ini_pos = $ar_dep['id'];
					break;

				}
				
				$ini_pg++;
			
			}			
		
		}else{

			$ini_pos = 9999999;

		}
		//
		echo $ini_pos." ".$ini_pg; exit();
		//start verify if tickets is true for dep rel id
		$break_l = 0;
	
		$get_tickets = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id < '$ini_pos' AND id_user = '$id' ORDER BY id DESC LIMIT 5");
		
		if($rows_tkt = mysqli_affected_rows($con) >= 1){

			while($array_tkt_info = mysqli_fetch_array($get_tickets)){

				if($break_l >= 5){ break; }

				$id_rel_dep = $array_tkt_info['rel_package']; //."-".$array_tkt_info['id']; //id rel dep+id 
				$id_tkt = $array_tkt_info['id'];
				$qtd = $array_tkt_info['value'];
				$status = $array_tkt_info['status'];
				$data = $array_tkt_info['data'];
				$tx = $array_tkt_info['tx'];

				if($status != 1){
					$status_str = "<a href='#' class='text-success'>Pending</a>";
				}else{
					$status_str = "<a href='#' class='text-primary'>Completed</a>";
				}

				$ar_str = str_split($array_tkt_info['rel_package']);
	 			$str_p = strpos($array_tkt_info['rel_package'],"-");
				 			
				$c = 0;
				$id = array();

				while($c < $str_p){

					$id[$c] = $ar_str[$c];
			
		    		$c++;
				}

				$id_im = implode("",$id);
				
				$get_coin = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_im'");
				
				if($rows_coin = mysqli_affected_rows($con) >= 1){
			
					$get_dcoin = mysqli_fetch_array($get_coin);
					$coin = $get_dcoin['coin'];

				}else{ echo "1";
					exit();
				}

				$id_dep_rel_c = base64_encode($id_rel_dep);
				
				$break_l++;
				
				//start get network protocol -> tickets side
				$get_proto = mysqli_query($con, "SELECT * FROM net_protos WHERE id_dep = '$id_dep_rel_c'");
				
				if($row_proto = mysqli_affected_rows($con) >= 1){
				
					$array_proto = mysqli_fetch_array($get_proto);
					$proto = $array_proto['net'];
				
					if($proto == "btc"){
						$url_tx = "https://www.blockchain.com/pt/explorer/transactions/btc/";
						$coin = "btc";
					}else if($proto == "btc-bep20"){
						$url_tx = "https://www.bscscan.com/tx/";
						$coin = "btc";
					}else if($proto == "segwit"){
						$url_tx = "https://www.blockchain.com/pt/explorer/transactions/btc/";
						$coin = "btc";
					}else if($proto == "eth-erc20"){
						$url_tx = "https://etherscan.io/tx/";
						$coin = "eth";
					}else if($proto == "eth-bep20"){
						$url_tx = "https://www.bscscan.com/tx/";
						$coin = "eth";
					}else if($proto == "trx-trc20"){
						$url_tx = "https://tronscan.org/#/transaction/";
						$coin = "tron";
					}else if($proto == "trx-bep20"){
						$url_tx = "https://etherscan.io/tx/";
						$coin = "tron";
					}else if($proto == "ltc"){
						$url_tx = "https://live.blockcypher.com/ltc/tx/";
						$coin = "ltc";
					}else if($proto == "ltc-bep20"){
						$url_tx = "https://www.bscscan.com/tx/";
						$coin = "ltc";
					}else if($proto == "bnb-bep20"){
						$url_tx = "https://www.bscscan.com/tx/";
						$coin = "bnb";
					}else if($proto == "tether-erc20"){
						$url_tx = "https://etherscan.io/tx/";
						$coin = "usdt";
					}else if($proto == "tether-bep20"){
						$url_tx = "https://www.bscscan.com/tx/";
						$coin = "usdt";
					}else if($proto == "arbitrum"){
						if($coin == "eth"){
								$url_tx = "https://optimistic.etherscan.io/tx/";
						}else if($coin == "usdt"){
								$url_tx = "https://optimistic.etherscan.io/tx/";
						}	
					}else if($proto == "avaxc"){
						if($coin == "eth"){
								$url_tx = "https://subnets.avax.network/c-chain/tx/";
						}else if($coin == "usdt"){
								$url_tx = "https://subnets.avax.network/c-chain/tx/";
						}	
					}

				}else{
					//echo "-------------";
				}
				//end network protocol -> tickets side
			
				//start
				if($coin == "btc"){
					$coin_img = "<img class='img-action-sm'src='images/coins/btc-sm.png' title='bitcoin' width='16px' height='16px' alt='btc coin deposited'>";
				}else if($coin == "usdt"){
					$coin_img = "<img class='img-action-sm' src='images/coins/usdt-sm.png' title='tether' width='16px' height='16px' alt='usdt coin deposited'>";
				}else if($coin == "tron"){
					$coin_img = "<img class='img-action-sm' src='images/coins/trx-sm.png' title='tron' width='16px' height='16px' alt='tron coin deposited'>";
				}else if($coin == "bnb"){
					$coin_img = "<img class='img-action-sm' src='images/coins/busd-sm.png' title='binance' width='16px' height='16px' alt='bnb coin deposited'>";
				}else if($coin == "eth"){
					$coin_img = "<img class='img-actions-sm' src='images/coins/eth-sm.png' title='ethereum' width='16px' height='16px' alt='eth coin deposited'>";
				}else if($coin == "ltc"){
					$coin_img = "<img class='img-actions-sm' src='images/coins/ltc-sm.png' title='litecoin' width='16px' height='16px' alt='ltc coin deposited'>";
				}else if($coin == "pix"){
					$coin_img = "<img class='img-actions-sm' src='images/coins/pix.png' title='pix' width='16px' height='16px' alt='pix deposited'>";
				}
				//end	verify if tickets is true for dep rel id
	
			$value_tkt = 0.20 * $array_tkt_info['value'];

		?>
		<div class="card <?php echo $bg_color; ?>" style="width: 100%;">
        <div class="card-body" style="padding: 1.25rem 1.25rem 0px 1.25rem;">
          <!--<h5 class="card-title">Card title</h5>
          <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>-->
          <div class="fluid-container">
          	<div class="row">
			  <div class="col-sm-12">
			    <span class="float-left color-theme">#<?php echo $id_rel_dep; ?></span>
			    <span class="float-right"><?php echo $status_str; ?></span>
			    <br>
			    <hr>
			    <div class="row mt-3">
			      <div class="col-10 col-sm-10 mgl-center">
			      	<div class="row row-flex <?php echo $wrap_mode; ?>">
								<ul style="display: flex !important;">					      		
		      				<li class="li-dep nav-item <?php echo $text_color; ?>">
		      					Plan: <a href="#" class="nav-link text-muted">Loterry</a>
		      				</li>
		      				<li class="li-dep nav-item <?php echo $text_color; ?>">
		      					Value: <a href="#" class="nav-link text-muted"><?php echo "$ ".$value_tkt; ?> in <?php echo $coin_img; ?></a>
		      				</li>
		      				<li class="li-dep nav-item <?php echo $text_color; ?>">
		      					Tickets: <a href="#" class="nav-link text-muted"><?php echo $qtd; ?></a>
		      				</li>
		      			</ul>
				      	<ul style="display: flex !important;">
		      				<li class="li-dep nav-item <?php echo $text_color; ?>">
		      					Net: <a href="#" id="<?php echo $id_rel_dep; ?>" class="nav-link text-muted"><?php echo $proto; ?></a>
		      				</li>
		      				<li class="li-dep nav-item <?php echo $text_color; ?>">
		      					Date: <a href="#" class="nav-link text-muted"><?php echo $data; ?></a>
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
		<?php
					
			}
		}
	
	}
	
}else if($display_w == "desktop"){ //desktop modals -> show

	if($mode_show == "dep-packages"){
		
		//
		$get_extrato = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' ORDER BY id DESC");
		$num_rows_dep = mysqli_num_rows($get_extrato);

		$cdeps = 0;
		$ar_dep = array();

		while($deps = mysqli_fetch_array($get_extrato)){

			$ar_dep[$cdeps] = $deps['id'];
			$cdeps++;

		}

		if($pg_now != 99999999){

			$rec_pg = ($pg_now - 1) * 5;
			$ini_pos = $ar_dep[$rec_pg];
		
		}else{

			$ini_pos = 99999999;

		}
		echo $pg_now; exit();
		$get_extrato_end = mysqli_query($con, "SELECT * FROM deposits WHERE id < '$ini_pos' AND id_user='$id' ORDER BY id DESC LIMIT 5");
		//

		?>
		<?php if($r = mysqli_affected_rows($con) >= 1){
			echo "<table class='tbd table table-striped ".$table_color."'>
				<thead class='".$text_color."'>
					<th>Action</th>
					<th>#</th>
					<th>Value <a href='#' id='dep_val' onclick='filter(1)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
					<th>Coin</th>
					<th>Net</th>
					<th>Date <a href='#' id='dep_data' onclick='filter(2)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
					<th>Plan <a href='#' id='dep_plan'><i class='fa fa-dep-modal fa-sort-desc text-muted' aria-hidden='true'></i></a></th>
					<th>Tx</th>
					<th>Status <a href='#' id='dep_status' onclick='filter(3)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
				</thead><tbody class='tbody-dep-list ".$text_color."' style='font-size:13.5px;'>";
			while ($list=mysqli_fetch_array($get_extrato_end)) {

				$this_dep = $list['id'];
				$get_coin = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep='$this_dep'");
				if($row_coin = mysqli_affected_rows($con) >= 1){
					$i=0;
					while($array_rel = mysqli_fetch_array($get_coin)){
						$coin = $array_rel['coin'];
						$cod_dep = $array_rel['id_charnum'];
						$tx = $array_rel['tx'];
						$id_dep = base64_encode($array_rel['id_dep']);
						$i++;
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
					}else if($proto == "arbitrum"){
						if($coin == "eth"){
								$url_tx = "https://optimistic.etherscan.io/tx/";
						}else if($coin == "usdt"){
								$url_tx = "https://optimistic.etherscan.io/tx/";
						}	
					}else if($proto == "avaxc"){
						if($coin == "eth"){
								$url_tx = "https://subnets.avax.network/c-chain/tx/";
						}else if($coin == "usdt"){
								$url_tx = "https://subnets.avax.network/c-chain/tx/";
						}	
					}

				}
				//end

				//start
				if($list['status'] == 0) {
					$status = "<td class='text-success'>Pending</td>";
					$btn = "<i class='fa fa-usd fa-2x ac-pay-dep' title='pay plan num ".$cod_dep."' aria-hidden='true' id='con-".$cod_dep."' onclick='ac_pay_dep(id);'></i>
						<i id='".$cod_dep."' class='fa fa-window-close fa-2x ac-rm-dep' title='remove ".$cod_dep."' aria-hidden='true'  onclick='rm_dep_m_d(id);'></i>";					
					$payment_dep = "<a href='#waiting' title='deposit ".$cod_dep." payment'>Link</a>";
					$add_payments = "tr-dep";
				}
				
				if($list['status'] == 1){
					$status = "<td class='text-primary'>Completed</td>";
					$payment_dep = "<a href='".$url_tx."".$tx."' target='_new' title='deposit ".$cod_dep." payment'>Link</a>";
					$btn = "<i class='fa fa-check-square fa-2x ac-pd-dep' title='".$cod_dep." paid' aria-hidden='true'></i>";
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

			  echo "<tr class='".$add_payments." dep-list dl".$i."' id='tr".$cod_dep."'>
			  	<td>".$btn."</td>
					<td>".$cod_dep."</td>
					<td class='cv dep-amount'>".$list['quantidade']."</td>
					<td id='img-coin".$cod_dep."'>".$coin_img."</td>
					<td id='net-proto".$cod_dep."'>".$list['proto']."</td>
					<td style='font-size: 10px;'>".$list['data']."</td>
					<td>".$list['type_dep']."</td>
					<td>".$payment_dep."</td>
					".$status."
				</tr>";

				/*echo "<tr id='trrm".$cod_dep."' style='display: none;'>
				<td>Do you want to delete this deposit? <button class='btn btn-sm btn-primary yesdep' id='y-".$cod_dep."' title='exclude dep'>Yes</button><button class='btn btn-sm btn-danger ndep' id='n-".$cod_dep."' title='no delete deposit'>No</button></td>
				</tr>";*/

			}
			
			echo "</tbody></table>";

		}else{

			echo "<h4 class='text-center'>Nenhum transação realizada.</h4>";
		}

	}else if($mode_show == "dep-tickets"){

		//
		$get_extrato = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id' ORDER BY id ASC");
		$num_rows_dep = mysqli_num_rows($get_extrato);

		$cdeps = 0;
		$ar_dep = array();

		while($deps = mysqli_fetch_array($get_extrato)){

			$ar_dep[$cdeps] = $deps['id'];
			$cdeps++;

		}

		if($pg_now != 99999999){

			$rec_pg = $pg_now - 1;
			$ini_pos = $ar_dep[$rec_pg * 5];
		
		}else{

			$ini_pos = 99999999;

		}
		//

		$get_extrato = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id'");
		$break_l = 0;
		
		if($r = mysqli_affected_rows($con) >= 1){
			echo "<table class='tbd table table-striped ".$table_color."'>
				<thead class='".$text_color."'>
					<th>Action</th>
					<th>#</th>
					<th>Value <a href='#' id='dep_val' onclick='filter(1)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
					<th>Coin</th>
					<th>Net</th>
					<th>Date <a href='#' id='dep_data' onclick='filter(2)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
					<th>Plan <a href='#' id='dep_plan'><i class='fa fa-dep-modal fa-sort-desc text-light' aria-hidden='true'></i></a></th>
					<th>Tx</th>
					<th>Status <a href='#' id='dep_status' onclick='filter(3)'><i class='fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald' aria-hidden='true'></i></a></th>
				</thead><tbody class='tbody-dep-list ".$text_color."' style='font-size:13.5px;'>";
			
			while ($list = mysqli_fetch_array($get_extrato)) {

				$this_dep = $list['id'];
				$get_coin = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep='$this_dep'");
				
				if($row_coin = mysqli_affected_rows($con) >= 1){
		
					while($array_rel = mysqli_fetch_array($get_coin)){
						$coin = $array_rel['coin'];
						$cod_dep = $array_rel['id_charnum'];
						//$tx = $array_rel['tx'];
						$id_dep = $array_rel['id_dep'];
					}
				
					//start verify if tickets is true for dep rel id
					$get_tickets = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id < '$ini_pos' AND rel_package LIKE '$cod_dep%' ORDER BY id DESC LIMIT 5");
					
					if($rows_tkt = mysqli_affected_rows($con) >= 1){

						while($array_tkt_info = mysqli_fetch_array($get_tickets)){

							if($break_l >= 5){ break; }

							$id_rel_dep = $array_tkt_info['rel_package']; //."-".$array_tkt_info['id']; //id rel dep+id 
							$id_tkt = $array_tkt_info['id'];
							$qtd = $array_tkt_info['value'];
							$status = $array_tkt_info['status'];
							$data = $array_tkt_info['data'];
							$tx = $array_tkt_info['tx'];
							$id_dep_rel_c = base64_encode($id_rel_dep);
							
							$break_l++;
							
							//start get network protocol -> tickets side
							$get_proto = mysqli_query($con, "SELECT * FROM net_protos WHERE id_dep = '$id_dep_rel_c'");
							
							if($row_proto = mysqli_affected_rows($con) >= 1){
							
								$array_proto = mysqli_fetch_array($get_proto);
								$proto = $array_proto['net'];
							
								if($proto == "btc"){
									$url_tx = "https://www.blockchain.com/pt/explorer/transactions/btc/";
									$coin = "btc";
								}else if($proto == "btc-bep20"){
									$url_tx = "https://www.bscscan.com/tx/";
									$coin = "btc";
								}else if($proto == "segwit"){
									$url_tx = "https://www.blockchain.com/pt/explorer/transactions/btc/";
									$coin = "btc";
								}else if($proto == "eth-erc20"){
									$url_tx = "https://etherscan.io/tx/";
									$coin = "eth";
								}else if($proto == "eth-bep20"){
									$url_tx = "https://www.bscscan.com/tx/";
									$coin = "eth";
								}else if($proto == "trx-trc20"){
									$url_tx = "https://tronscan.org/#/transaction/";
									$coin = "tron";
								}else if($proto == "trx-bep20"){
									$url_tx = "https://etherscan.io/tx/";
									$coin = "tron";
								}else if($proto == "ltc"){
									$url_tx = "https://live.blockcypher.com/ltc/tx/";
									$coin = "ltc";
								}else if($proto == "ltc-bep20"){
									$url_tx = "https://www.bscscan.com/tx/";
									$coin = "ltc";
								}else if($proto == "bnb-bep20"){
									$url_tx = "https://www.bscscan.com/tx/";
									$coin = "bnb";
								}else if($proto == "tether-erc20"){
									$url_tx = "https://etherscan.io/tx/";
									$coin = "usdt";
								}else if($proto == "tether-bep20"){
									$url_tx = "https://www.bscscan.com/tx/";
									$coin = "usdt";
								}else if($proto == "arbitrum"){
									if($coin == "eth"){
											$url_tx = "https://optimistic.etherscan.io/tx/";
									}else if($coin == "usdt"){
											$url_tx = "https://optimistic.etherscan.io/tx/";
									}	
								}else if($proto == "avaxc"){
									if($coin == "eth"){
											$url_tx = "https://subnets.avax.network/c-chain/tx/";
									}else if($coin == "usdt"){
											$url_tx = "https://subnets.avax.network/c-chain/tx/";
									}	
								}

							}else{
								echo "-------------";
							}
							//end network protocol -> tickets side
						
							//start

							if($status == 1){
								$status = "<td class='text-primary'>Completed</td>";
								$payment_dep = "<a href='".$url_tx."".$tx."' target='_new' title='deposit ".$id_rel_dep." payment'>Link</a>";
								$btn = "<i class='fa fa-check-square fa-2x ac-pd-dep' title='".$id_rel_dep." paid' aria-hidden='true'></i>";
								$add_payments = "";
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

						  echo "<tr class='".$add_payments." dep-list' id='tr".$id_rel_dep."'>
						  	<td>".$btn."</td>
								<td>".$id_rel_dep."</td>
								<td class='cv dep-amount'>".$qtd."</td>
								<td>".$coin_img."</td>
								<td id='net-proto".$id_rel_dep."'>".$proto."</td>
								<td style='font-size: 10px;'>".$data."</td>
								<td>".$list['type_dep']." -> tkt</td>
								<td>".$payment_dep."</td>
								".$status."
								
							</tr>";
						
							/*echo "<tr id='trrm".$id_rel_dep."' style='display: none;'>
							<td>Do you want to delete this deposit? <button class='btn btn-sm btn-primary yesdep' id='y-".$cod_dep."' title='exclude ".$id_tkt."'>Yes</button><button class='btn btn-sm btn-danger ndep' id='n-".$cod_dep."' title='no delete deposit'>No</button></td>
							</tr>";*/
						}
		
					}
					//end	verify if tickets is true for dep rel id

				}

			}
			
			echo "</tbody></table>";
		
		}else{
			
			echo "<h4 class='text-center'>Nenhum transação realizada.</h4>";
		}

	}else if($mode_show == "withdraws"){

		//
		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id' ORDER BY id ASC");
		$num_rows_dep = mysqli_num_rows($get_extrato);

		$cdeps = 0;
		$ar_dep = array();

		while($deps = mysqli_fetch_array($get_extrato)){

			$ar_dep[$cdeps] = $deps['id'];
			$cdeps++;

		}

		if($pg_now != 99999999){

			$rec_pg = $pg_now - 1;
			$ini_pos = $ar_dep[$rec_pg * 5];
		
		}else{

			$ini_pos = 99999999;

		}
		//
		
		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id <= '$ini_pos' AND id_user = '$id' ORDER BY id DESC LIMIT 5");

		if($r = mysqli_affected_rows($con) >= 1){
	
			echo "<table class='table table-striped ".$table_color."'>
				<thead>
					<th>Action</th>
					<th>#</th>
					<th>Valor <a href='#'><i class='fa fa-dep-modal fa-sort-desc text-light' aria-hidden='true'></i></a></th>
					<th>Coin</th>
					<th>Payment</th>
					<th>Data <a href='#'><i class='fa fa-dep-modal fa-sort-desc text-light' aria-hidden='true'></i></a></th>
					<th>Status <a href='#'><i class='fa fa-dep-modal fa-sort-desc text-light' aria-hidden='true'></i></a></th>
					<th>Tell in</th>
				</thead><tbody class='".$text_color."' style='font-size:13.5px;'>";
			while ($list=mysqli_fetch_array($get_extrato)) {
				
				//
				$this_dep = $list['id'];
				$get_coin = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE id_with='$this_dep'");
				if($row_coin = mysqli_affected_rows($con) >= 1){
				
					while($array_rel = mysqli_fetch_array($get_coin)){
						$coin = $array_rel['coin'];
						$tx_withdraw = "<a href=".$array_rel['tx_prove']." target='_new' title='payment ".$array_rel['id_charnum']." prove'>Link</a>";
						$id_num_char_w = $array_rel['id_charnum'];
						$dep_rel = $array_rel['dep_con'];
					}

				}
				
				//start
				
				//end

				if ($list['status'] == 0) {
					$status = "<td class='text-success'>Pending</td>";
					$btn = "<i class='fa fa-clock-o fa-2x ac-rm-with' title='waiting ".$id_num_char_w."' aria-hidden='true'></i>";
				}
				
				if ($list['status'] == 1) {
					$status = "<td class='text-primary'>Completed</td>";
					$btn = "<i class='fa fa-check-square fa-2x ac-pd-with' title='".$id_num_char_w." paid' aria-hidden='true'></i>";
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
					$coin_img = "<img class='img-actions-sm' src='images/coins/pix.png' title='litecoin' width='26px' height='26px' alt='pix deposited'>";
				}
				//

				//
				$get_rel_with = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep = '$dep_rel'");
				if($rrel_dep = mysqli_affected_rows($con) >= 1){
					while($array_rel_dep = mysqli_fetch_array($get_rel_with)){
						$con_dep = "<a href='#' title='tell in'>".$array_rel_dep['id_charnum']."</a>"; 
					}
				}
				//

			echo "<tr>
					<td>".$btn."</td>
					<td>".$id_num_char_w."</td>
					<td class='cv with-amount'>".$list['quantidade']."</td>
					<td>".$coin_img."</td>
					<td>".$tx_withdraw."</td>
					<td style='font-size: 10px;'>".$list['data']."</td>
					".$status."
					<td>".$con_dep."</td>
				</tr>";
			}
			echo "</tbody></table>";
	
		}else{

			echo "<h4 class='text-center'>Nenhum transação realizada.</h4>";
		}

	}

}
?>