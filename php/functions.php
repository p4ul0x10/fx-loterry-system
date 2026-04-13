<?php 

	function numdays(){

		include("conn.php");
    
    $usr = $_SESSION['email'];
		$today = date('j');

		$percentquery = mysqli_query($con, "SELECT * FROM info");
		
		while ($rpercent=mysqli_fetch_array($percentquery)) {
		
			$percent = $rpercent['ganho_diario'];
		}
		
		$attdaycheck = mysqli_query($con, "SELECT * FROM info WHERE d_today !='$today'");
		
		if($daytt = mysqli_affected_rows($con) >= 1){
		
			$att = mysqli_query($con, "UPDATE info SET days=days+1, d_today=$today, rake_day=rake_day+1 WHERE id='1'");

			$check_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$usr'");
		
			if($r=mysqli_affected_rows($con) >= 1) {
		
				while($user=mysqli_fetch_array($check_user)) {
		
					$get_id=$user['id'];
				}
							
				$get_deposits=mysqli_query($con, "SELECT * FROM deposits WHERE id_user ='$get_id' AND status ='1' AND qtd_dias < 31");

				$num_deps = mysqli_affected_rows($con);
				if($num_deps >= 1){
	
					while($rows_dep_att = mysqli_fetch_array($get_deposits)) {
						
						$id_att = $rows_dep_att['id'];
						$rel_id = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep='$id_att'");
						$array_rel = mysqli_fetch_array($rel_id);
						$id_charnum = $array_rel['id_charnum'];

						$add_days = mysqli_query($con, "UPDATE deposits SET qtd_dias=qtd_dias+1 WHERE id = '$id_att' AND id_user='$get_id' AND status='1'");

						$dep_plan = $rows_dep_att['type_dep'];
		
						$get_info_percent = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
            $array_info = mysqli_fetch_array($get_info_percent);

            if($dep_plan == "Starter"){
              $percent = $array_info['plan1'];
            }else if($dep_plan == "Advanced"){
              $percent = $array_info['plan2'];
            }else if($dep_plan == "Premium"){
              $percent = $array_info['plan3'];
            }

						$amount = $rows_dep_att['quantidade'];
						$calc = $amount * $percent / 100;
						$calc_format = number_format($calc, 2, ".", "");
			
						$add_earn_day = mysqli_query($con, "UPDATE usuarios SET total_amount=total_amount+'$calc_format', total_disp=total_disp+'$calc_format' WHERE id='$get_id'");

						//add notification -> leader
						$title_not = base64_encode('Payment added'); 
						$text_not = base64_encode("New payment added, referring to the deposit: ".$id_charnum.", of value $ ".$amount."<br>added $ ".$calc_format." of the ".$percent."% ".$dep_plan." plan");

						$data = date("m,j,Y g:i a");

						$insert_not = mysqli_query($con, "INSERT INTO notifications (email,title_not,text_not,date_send) VALUES ('$usr','$title_not','$text_not','$data')");

					}

				}else{
				
				}
				//$get_deposits=mysqli_query($con, "SELECT * FROM deposits WHERE id_user ='$get_id'");
			}else{
	
			}
	
			$get_info = mysqli_query($con, "SELECT rake_day FROM info WHERE id ='1'");
			$ar_info = mysqli_fetch_array($get_info);
			$data = date("m,j,Y g:i a"); //date("d/m/Y");

			if($ar_info['rake_day'] > 7){

				mysqli_query($con, "UPDATE info SET rake_day='1' WHERE id = '1'");
		
			}
		
		}	
		
	}

  function numdays1(){
		include "conn.php";

		$getdays = mysqli_query($con, "SELECT * FROM info");

		if($r=mysqli_affected_rows($con) >= 1){
		
			while ($numdays = mysqli_fetch_array($getdays)) {
	
			echo "<a href='#' class='text-success'>".$numdays['days']."</a>";
		
			}	
		
		}
	
	}

	function rate_atual(){
		include "conn.php";

		$getrate = mysqli_query($con, "SELECT * FROM info");

		if($r=mysqli_affected_rows($con) >= 1) {
			
			while ($percent = mysqli_fetch_array($getrate)) {
			echo $percent['ganho_diario'];
			
			}	
		
		}
	
	}

	function simple_statistics(){
		include "conn.php";
		$get_accounts = mysqli_query($con, "SELECT * FROM deposits WHERE id > 0");
		$get_accounts_lines = mysqli_affected_rows($con);
		$get_deps = mysqli_query($con, "SELECT * FROM deposits WHERE id > 0");
		$get_dep_lines = mysqli_affected_rows($con);
		$get_with= mysqli_query($con, "SELECT * FROM saque WHERE id > 0");
		$get_with_lines = mysqli_affected_rows($con);
		/*
		 <ul class="hnav navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link link_depu
		*/
		echo "<nav class='nav-deps-all'><ul><li class='color-theme'>All Accounts<a href='#'> ".$get_accounts_lines."</a></li><li class='color-theme'>All deposits<a href='#'> ".$get_dep_lines."</a></li><li class='color-theme'>All withdraws<a href='#'> ".$get_with_lines."</a></li></ul></nav>";	
	}

	function listextrato(){

		include "conn.php";
		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		
		while($idu = mysqli_fetch_array($get_usr)) {
			$id = $idu['id'];
		}

		//start
		if(isset($_GET['pg_with']) && $_GET['pg_with'] > 1){
			$pg_now = $_GET['pg_with'];
		}else{
			$pg_now = 1;
		}
		//end

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";

			}

		}

		//
		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id' ORDER BY id DESC");
		$num_rows_dep = mysqli_num_rows($get_extrato);

		$cdeps = 0;
		$ar_dep = array();

		while($deps = mysqli_fetch_array($get_extrato)){

			$ar_dep[$cdeps] = $deps['id'];
			$cdeps++;

		}

		if($pg_now > 1){

			$rec_pg = $pg_now - 1;
			$ini_pos = $ar_dep[$rec_pg * 5];
		
		}else{

			$ini_pos = 999999999;

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
			while($list=mysqli_fetch_array($get_extrato)) {
				
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
				if($list['status'] == 0) {
					$status = "<td class='text-success'>Pending</td>";
					$btn = "<i class='fa fa-clock-o fa-2x ac-rm-with' title='waiting ".$id_num_char_w."' aria-hidden='true'></i>";
				}
				
				if($list['status'] == 1) {
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
				//end

				//start
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

	function listextrato_mobile(){

		include "conn.php";
		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		//start
		if(isset($_GET['pg_with']) && $_GET['pg_with'] > 1){
			$pg_now = $_GET['pg_with'];
		}else{
			$pg_now = 1;
		}
		//end

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "bg-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "bg-dark";
				$text_color = "text-light";
			
			}

		}

		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id'");

		$cdeps = 0;
		$ar_dep = array();

		while($deps = mysqli_fetch_array($get_extrato)){

			$ar_dep[$cdeps] = $deps['id'];
			$cdeps++;

		}

		if($pg_now > 1){

			$rec_pg = $pg_now - 1;
			$ini_pos = $ar_dep[$rec_pg * 5];
			$end_pos = $ini_pos + 5;
		
		}else{

			$ini_pos = 0;
			$end_pos = 5;

		}

		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id >= '$ini_pos' AND id <= '$end_pos' AND id_user ='$id'");
		//

		if($r = mysqli_affected_rows($con) >= 1){
			
			while($list = mysqli_fetch_array($get_extrato)) {
				
				//
				$this_dep = $list['id'];
				$get_coin = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE id_with='$this_dep'");
				if($row_coin = mysqli_affected_rows($con) >= 1){
				
					while($array_rel = mysqli_fetch_array($get_coin)){
					
						$coin = $array_rel['coin'];
						$tx_withdraw = "<a href=".$array_rel['tx_prove']." class='nav-link text-muted' target='_new' title='payment ".$array_rel['id_charnum']." prove'>Link</a>";
						$id_num_char_w = $array_rel['id_charnum'];
						$dep_rel = $array_rel['dep_con'];
					
					}

				}
				
				//start
				if($list['status'] == 0) {
					$status = "<p class='text-success'>Pending</p>";
					$btn = "<i class='fa fa-clock-o fa-2x ac-rm-with color-theme' title='waiting ".$id_num_char_w."' aria-hidden='true'></i>";
				}
				
				if($list['status'] == 1) {
					$status = "<p class='text-primary'>Completed</p>";
					$btn = "<i class='fa fa-check-square fa-2x ac-pd-with color-theme' title='".$id_num_char_w." paid' aria-hidden='true'></i>";
				}

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
				//

				//
				$get_rel_with = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep = '$dep_rel'");
				if($rrel_dep = mysqli_affected_rows($con) >= 1){
					
					while($array_rel_dep = mysqli_fetch_array($get_rel_with)){
						$con_dep = "<a href='#' class='nav-link text-muted' title='tell in'>".$array_rel_dep['id_charnum']."</a>"; 
					}
				
				}
				//

			?>
			<div class="card <?php echo $table_color; ?>" style="width: 100%;">
        <div class="card-body" style="padding: 1.25rem 1.25rem 0px 1.25rem;">
          <div class="fluid-container">
          	<div class="row">
						  <div class="col-sm-12">
						    <span class="float-left color-theme">#<?php echo $id_num_char_w; ?></span>
						    <span class="float-right"><?php echo $status; ?></span>
						    <br>
						    <hr>
						    <div class="row mt-3">
						      <div class="col-2 col-sm-2">
						        <?php echo $btn; ?>
						      </div>
						      <div class="col-10 col-sm-10">
						      	<div class="row">
												<ul style="display: flex !important;">					      		
						      				<!--<li class="nav-item color-theme">
						      					Plan: <a href="#" class="nav-link"><?php echo $list['type_dep']; ?></a>
						      				</li>-->
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Value: <a href="#" class="nav-link text-muted"><?php echo "$ ".$list['quantidade']; ?> in <?php echo $coin_img; ?></a>
						      				</li>
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Tell in: <?php echo $con_dep; ?>
						      				</li>
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Tx: <?php echo $tx_withdraw; ?>
						      				</li>
						      			</ul>
						      			<ul style="display: flex !important;">
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Net: <a href="#" class="nav-link text-muted"><?php echo $list['proto']; ?></a>
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
			
		}else{

			echo "<h4 class='text-center'>Nenhum transação realizada.</h4>";
		
		}

	}

	function listextrato_rakeback(){

		include "conn.php";
		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";
			}

		}

		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id'");

		if($r = mysqli_affected_rows($con) >= 1){
			echo "<table class='table table-striped ".$table_color."'>
				<thead>
					<th>Action</th>
					<th>#</th>
					<th>Valor</th>
					<th>Coin</th>
					<th>Payment</th>
					<th>Data</th>
					<th>Status</th>
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

	function listextrato_rakeback_mobile(){

		include "conn.php";
		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";
			}

		}

		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id'");

		if($r = mysqli_affected_rows($con) >= 1){
			echo "<table class='table table-striped ".$table_color."'>
				<thead>
					<th>Action</th>
					<th>#</th>
					<th>Valor</th>
					<th>Coin</th>
					<th>Payment</th>
					<th>Data</th>
					<th>Status</th>
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
	
	function listextrato_ticket(){

		include "conn.php";
		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";
			}

		}

		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id'");

		if($r = mysqli_affected_rows($con) >= 1){
			echo "<table class='table table-striped ".$table_color."'>
				<thead>
					<th>Action</th>
					<th>#</th>
					<th>Valor</th>
					<th>Coin</th>
					<th>Payment</th>
					<th>Data</th>
					<th>Status</th>
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

	function listextrato_ticket_mobile(){

		include "conn.php";
		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";
			}

		}

		$get_extrato = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id'");

		if($r = mysqli_affected_rows($con) >= 1){
			echo "<table class='table table-striped ".$table_color."'>
				<thead>
					<th>Action</th>
					<th>#</th>
					<th>Valor</th>
					<th>Coin</th>
					<th>Payment</th>
					<th>Data</th>
					<th>Status</th>
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

  function listdeposito(){

		include "conn.php";
		session_start();

		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";

			}

		}

		//
		if(isset($_GET['pg_dep']) && $_GET['pg_dep'] > 1){
			$pg_now = $_GET['pg_dep'];
		}else{
			$pg_now = 1;
		}

		$get_extrato = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' ORDER BY id DESC");
		$num_rows_dep = mysqli_num_rows($get_extrato);

		$cdeps = 0;
		$ar_dep = array();

		while($deps = mysqli_fetch_array($get_extrato)){

			$ar_dep[$cdeps] = $deps['id'];
			$cdeps++;

		}

		if($pg_now > 1){

			$rec_pg = $pg_now - 1;
			$ini_pos = $ar_dep[$rec_pg * 5];
		
		}else{

			$ini_pos = 9999999;

		}

		$get_extrato_end = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' AND id <= '$ini_pos' ORDER BY id DESC LIMIT 5");
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
						$id_dep = $array_rel['id_dep'];
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

	}

  function listdeposito_mobile(){

		include "conn.php";
		session_start();

		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		//start
		if(isset($_GET['pg_dep']) && $_GET['pg_dep'] > 1){
			$pg_now = $_GET['pg_dep'];
		}else{
			$pg_now = 99999999;
		}
		//end

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");

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

		$md = "'modal-dep'";
	
		$get_deps = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' ORDER BY id DESC");
		
		if($pg_now != 99999999){

			$rec_pg = ($pg_now - 1) * 5;
			
			$ini_pg = 1;			
			$checked = false;

			while($ar_dep = mysqli_fetch_array($get_deps)){

				if($ini_pg >= $rec_pg){

					$ini_pos = $ar_dep['id'];
					break;

				}
				
				$ini_pg++;
			
			}			
		
		}else{

			$ini_pos = 99999999;

		}

		$get_extrato = mysqli_query($con, "SELECT * FROM deposits WHERE id < '$ini_pos' AND id_user = '$id' ORDER BY id DESC LIMIT 5");

		if($r = mysqli_affected_rows($con) >= 1){
		
			while ($list=mysqli_fetch_array($get_extrato)) {

				$this_dep = $list['id'];
				$get_coin = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep = '$this_dep'");
				
				if($row_coin = mysqli_affected_rows($con) >= 1){

					while($array_rel = mysqli_fetch_array($get_coin)){

						$coin = $array_rel['coin'];
						$cod_dep = $array_rel['id_charnum'];
						$tx = $array_rel['tx'];
						$id_dep = $array_rel['id_dep'];
						$time_left = $array_rel['hms'];
					
						if($time_left > 1){
					
							$isset_hms = 1;
					
						}

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
					$status = "<p class='text-success'>Pending</p>";
					$btn = "<i class='fa fa-usd fa-2x ac-pay-dep ".$btn_text_color." float-left' title='pay plan num ".$cod_dep."' aria-hidden='true' id='con-".$cod_dep."' onclick='ac_pay_dep(id);'></i>
						<i id='".$cod_dep."' class='fa fa-window-close fa-2x ac-rm-dep ".$btn_text_color." float-right' title='remove ".$cod_dep."' aria-hidden='true' onclick='rm_dep_m_d(id);'></i>";					
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
			<?php $hms = gmdate("H:i:s", $time_left); ?>
			<div class="card card-<?php echo $cod_dep; ?>" style="width: 100%;">
        <div class="card-body <?php echo $bg_color; ?>" style="padding: 1.25rem 1.25rem 0px 1.25rem;">
          <div class="fluid-container">
          	<div class="col-mb-dep-h row">
						  <div class="col-sm-12">
						    <span class="float-left color-theme">#<?php echo $cod_dep; ?></span>
						    <span class="float-right"><?php echo $status; ?></span>
						    <br>
						    <hr>
						    <div class="row mt-3">
						      <div class="col-12 col-sm-12 col-10-<?php echo $cod_dep; ?>">
						      	<div class="row row-flex">
						      		<div class="row m-auto">	
												<ul class="ul-dep font-dep-mt-3 float-left" style="display: flex !important;">		
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Plan: <a href="#" class="nav-link text-muted"><?php echo $list['type_dep']; ?></a>
						      				</li>
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Value: <a href="#" id="val-<?php echo $cod_dep; ?>" class="nav-link text-muted"><?php echo "$ ".$list['quantidade']; ?> in <?php echo $coin_img; ?></a>
						      				</li>
						      				<li class="nav-item <?php echo $text_color; ?>">
						      				<?php if(!$isset_hms){ echo "Tx: ".$payment_dep; }else if($isset_hms){ echo "Time left: <a href='#' class='nav-link text-muted hms-dep-p' title='deposit time left'>".$hms."</a>"; } ?>
						      				</li>
						      			</ul>
						      			<ul class="ul-dep font-dep-mt-3 float-right" style="display: flex !important;">
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
						      <?php if($list['status'] == 0){ ?><div class="col-btn-m-<?php echo $cod_dep; ?> col-12 col-sm-12 mb-3">
						        <?php echo $btn; ?>
						      </div><?php } ?>
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

	function listdeposito_t(){

		include "conn.php";
		
		session_start();
		$email = $_SESSION['email'];
		
		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
	
		while($idu = mysqli_fetch_array($get_usr)) {
			$id = $idu['id'];
		}

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
	
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";

			}

		}

		//
		if(isset($_GET['pg_dep']) && $_GET['pg_dep'] > 1){
			$pg_now = $_GET['pg_dep'];
		}else{
			$pg_now = 1;
		}

		$get_extrato = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id' ORDER BY id DESC");
		$num_rows_dep = mysqli_num_rows($get_extrato);

		$cdeps = 0;
		$ar_dep = array();

		while($deps = mysqli_fetch_array($get_extrato)){

			$ar_dep[$cdeps] = $deps['id'];
			$cdeps++;

		}

		if($pg_now > 1){

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
			
			while($list = mysqli_fetch_array($get_extrato)){

				$this_dep = $list['id'];
				$get_coin = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep='$this_dep'");
				
				if($row_coin = mysqli_affected_rows($con) >= 1){
		
					while($array_rel = mysqli_fetch_array($get_coin)){
				
						$coin = $array_rel['coin'];
						$cod_dep = $array_rel['id_charnum'];
						$id_dep = $array_rel['id_dep'];
				
					}
				
					//start verify if tickets is true for dep rel id
					$get_tickets = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id <= '$ini_pos' AND id_user = '$id' ORDER BY id DESC LIMIT 5");
					
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
								}else{
									$coin = "pix";
								}

							}else{
								//echo "-------------";
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
					
						}

					}
					
					//end	verify if tickets is true for dep rel id

				}

			}
			
			echo "</tbody></table>";
		
		}else{
			
			echo "<h4 class='text-center'>Nenhum transação realizada.</h4>";
		
		}

	}

  function listdeposito_mobile_t(){

		include "conn.php";
		
		$email = $_SESSION['email'];

		$get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		
		while ($idu=mysqli_fetch_array($get_usr)) {
			$id=$idu['id'];
		}

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
		
		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$bg_color = "bg-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$bg_color = "bg-dark";
				$text_color = "text-light";

			}

			//
			if(isset($_GET['pg_dep']) && $_GET['pg_dep'] > 1){
				$pg_now = $_GET['pg_dep'];
			}else{
				$pg_now = 1;
			}

			$get_extrato = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id' ORDER BY id DESC");
			
			$num_rows_dep = mysqli_num_rows($get_extrato);
			$ar_extrato_t = mysqli_fetch_array($get_extrato);
			
			if($pg_now > 1){

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

			//start verify if tickets is true for dep rel id
			$break_l = 0;
		
			$get_tickets = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id <= '$ini_pos' AND id_user ='$id' ORDER BY id DESC LIMIT 5");
			
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
						}else{
							$coin = "pix";
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
          <div class="fluid-container">
          	<div class="col-mb-dep-h row">
						  <div class="col-sm-12">
						    <span class="float-left color-theme">#<?php echo $id_rel_dep; ?></span>
						    <span class="float-right"><?php echo $status_str; ?></span>
						    <br>
						    <hr>
						    <div class="row mt-3">
						      <div class="col-12 col-sm-12 mgl-center">
						      	<div class="row row-flex">
												<ul class="ul-dep" style="display: flex !important;">					      		
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Plan: <a href="#" class="nav-link text-muted">Loterry</a>
						      				</li>
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Value: <a href="#" class="nav-link text-muted"><?php echo "$ ".$value_tkt; ?> in <?php echo $coin_img; ?></a>
						      				</li>
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Tickets: <a href="#" class="nav-link text-muted"><?php echo $qtd; ?></a>
						      				</li>
						      			</ul>
						      			<ul class="ul-dep" style="display: flex !important;">
						      				<li class="nav-item <?php echo $text_color; ?>">
						      					Net: <a href="#" id="<?php echo $id_rel_dep; ?>" class="nav-link text-muted"><?php echo $proto; ?></a>
						      				</li>
						      				<li class="nav-item <?php echo $text_color; ?>">
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

} 

?>

<?php
	
	function reset_searchs(){
		include "conn.php";
		$user = $_SESSION['email'];
		$get_nome = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user'");
		$ar_user = mysqli_fetch_array($get_nome);
		$id_user = $ar_user['id'];
		
		mysqli_query($con, "UPDATE user_config SET pgw = '1' WHERE id_user='$id_user'");
		mysqli_query($con, "UPDATE user_config SET pgn = '1' WHERE id_user='$id_user'");
	}

  function total_sponsors(){
  	include "conn.php";

  	$get_total_sponsor =mysqli_query ($con, "SELECT * FROM usuarios WHERE sponsor != '' AND sponsor != '1'");

  	if($r=mysqli_num_rows($get_total_sponsor)){
  		echo $r;
  	}
  }

	function titulo(){
		include "conn.php";
		$titulo = mysqli_query($con, "SELECT * FROM hometexto");
		while ($texto = mysqli_fetch_array($titulo)) {
			echo utf8_decode($texto['textotitulo']);
		}
	}

	function descricao(){
		include "conn.php";
		$descricao = mysqli_query($con, "SELECT * FROM hometexto");
		while ($texto = mysqli_fetch_array($descricao)) {
			echo utf8_decode($texto['textodescricao']);
		}
	}

	function referencia(){
		include "conn.php";
		$user_id = $_SESSION['email'];
		$get_id = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user_id'");

		while ($r=mysqli_fetch_array($get_id)) {
			$id = $r['f_nome'];
		}
		echo "<a id='my_link' href='#' class='text-muted'> http://".$_SERVER['SERVER_NAME']."/registro.php?sponsor=".$id."</a>";
	}

	function user(){
		include "conn.php";
		$user = $_SESSION['email'];
		$get_nome = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user'");

		while ($r=mysqli_fetch_array($get_nome)) {
			echo "<h4 class='text-muted bemvindo'>Bem vindo,</h4><p class='nick color-theme user'> ". utf8_encode($r['f_nome'])."</p>";
		}

	}

	function total_contas(){

		include "conn.php";
		$total_contas = mysqli_query($con, "SELECT * FROM usuarios");
		if ($total = mysqli_num_rows($total_contas)) {
			echo "<p class='text-muted'>".$total. " <i class='far fa-check-circle fa-1x'></i></p>";
		}

	}

   function nome(){
		include "conn.php";
		$email = $_SESSION['email'];
		$total_depositado = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
			while ($total=mysqli_fetch_array($total_depositado)) {
			
			echo utf8_decode($total['f_nome']);
		}
		
	}

	 function email(){
		include "conn.php";
		$email = $_SESSION['email'];
		$total_depositado = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
			while ($total=mysqli_fetch_array($total_depositado)) {
			
			echo utf8_decode($total['email']);
		}
		
	}

	function cpf(){
		include "conn.php";
		$email = $_SESSION['email'];
		$total_depositado = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
			while ($total=mysqli_fetch_array($total_depositado)) {
			
			echo utf8_decode($total['cpf']);
		}
		
	}

	function total_depositado(){
		include "conn.php";
		$total_depositado = mysqli_query($con, "SELECT sum(total_acc)total_acc FROM usuarios WHERE total_acc > 0");

			if ($r=mysqli_affected_rows($con) >= 1) {
			
			while ($total=mysqli_fetch_array($total_depositado)) {
			$valor = $total['total_acc'];
			
			echo "<p class='text-muted' style='display: inline-block;'>".$valor." <i class='fas fa-level-up-alt fa-1x'></i></p>";
			}
		
		}else{
			echo "0.00";
		}

	}

	function totalBonus(){
		include "conn.php";
		$total_bonus = mysqli_query($con, "SELECT sum(total_amount)total_amount FROM usuarios WHERE total_amount > 0");
			while ($totalb=mysqli_fetch_array($total_bonus)) {
			$valor = $totalb['total_amount'];
			echo "<p class='text-muted' style='display: inline-block;'>".$valor." <i class='fas fa-level-down-alt fa-1x'></i></p>";
		}

	}

	function qtd_users_ref(){

		include "conn.php";	
		$email = $_SESSION['email'];
		$getid=mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");

		if($r=mysqli_affected_rows($con) >= 1){
			
			while ($id=mysqli_fetch_array($getid)) {
				$my_id = $id['f_nome'];
			}
		
		}

		$user = mysqli_query($con, "SELECT * FROM usuarios WHERE id > 1 AND sponsor='$my_id'");
		if ($refs=mysqli_num_rows($user) >= 1) {
		
			echo "<div class='text-muted' style='display: inline-block !important;'>".$refs."</div>";

		}else{

			echo "<div class='text-muted'>0</p>";
		}

	}

	function qtd_bonus_ref(){
		
		include "conn.php";	
		$email = $_SESSION['email'];
		$getid=mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");

		if($r=mysqli_affected_rows($con) >= 1){
			while ($id=mysqli_fetch_array($getid)) {
				$my_id = $id['f_nome'];
			}
		}

		$userqtd = mysqli_query($con, "SELECT * FROM usuarios WHERE id > 1 AND sponsor='$my_id'");
		
		if ($refs=mysqli_affected_rows($con) >= 1) {
		
			$qtd  = mysqli_query($con, "SELECT sum(total_bonus)total_bonus FROM usuarios WHERE f_nome='$my_id'");
			while ($t_qtd =  mysqli_fetch_array($qtd)){
				$valor_bonus = $t_qtd['total_bonus'];
				if ($valor_bonus == 0) {
					$valor_bonus = "0.00";
				}
			echo "<p class='cv text-muted total-earns-ref' style='display: inline-block;'>".number_format($valor_bonus, 2, ".", "")."</p>";
			}
		
		}else{
			echo "0.00";
		}

	} 

	function table_ref1(){

		include_once "conn.php";
		session_start();
		$user = $_SESSION['email'];
		$get_info = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$user'");
		$count = 1;

		$get_user = mysqli_fetch_array($get_info);
		$id = $get_user['id'];
		$count_ref_db = $get_user['total_ref'];

		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");

		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$table_color = "table-light";
				$text_color = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$table_color = "table-dark";
				$text_color = "text-light";

			}

		}

		echo "<style>.fa-ref { height: 5px !important;
		float: initial !important;
		position: absolute !important;
		margin: 5px 5px !important; }
		@media only screen and  (max-device-width : 700px){
		  .table-mobile-ref1 { position: relative !important; float: left !important; width: 100% !important; display: block !important; overflow-x: auto !important; }
		  .filter-table-ref1 { position: relative !important; float: right !important; margin-right: 0% !important; }

		}</style>";
		echo '<script type="text/javascript" src="js/ref_script.js"></script>';
		echo '<table id="box-menu-table" class="table table-striped '.$table_color.' table-mobile-ref1 ref-table-top color-theme">
          <thead class="'.$text_color.'">
            <tr>
              <th scope="col"><span class="filter-table-ref1">#<i id="rf1" class="fa fa-ref fa-sort-desc '.$text_color.'" aria-hidden="true" onclick="ref_click(1);"></i></span></th>
              <th scope="col">Name</th>
              <th scope="col"><span class="filter-table-ref1">Level<i id="rf2" class="fa fa-ref fa-sort-desc '.$text_color.'" aria-hidden="true" onclick="ref_click(2);"></i></span></th>
              <th scope="col">Started</span></th>
              <th scope="col">Leader</th>
              <th>Status</th>
              <th><span class="filter-table-ref1">Earns<i id="rf4" class="fa fa-ref fa-sort-desc '.$text_color.'" aria-hidden="true" onclick="ref_click(4);"></i></span></th>
              <th><span class="filter-table-ref1">Activity<i id="rf5" class="fa fa-ref fa-sort-desc '.$text_color.'" aria-hidden="true" onclick="ref_click(5);"></i></span></th>
            </tr>
          </thead><tbody class="tbodyref" style="max-height: 500px; overflow-y: auto;">';
	  $get_net_list = mysqli_query($con, "SELECT * FROM network_list WHERE leader_id ='$id' ORDER BY id ASC LIMIT 10");

	  if($rtl = mysqli_affected_rows($con) >= 1){
			while ($array_network = mysqli_fetch_array($get_net_list)) {
		echo '<tr>
		<th scope="row"><a href="#pos_ref" class="id_ref '.$text_color.'">'.$count.'</a></th>
		<td><a href="?ref_name='.$array_network['nome_ref'].'" class="name_ref">'.$array_network['nome_ref'].'</a></td>
		<td><a href="#ref_level" class="level_ref '.$text_color.'">'.$array_network['level_ref'].'</a></td>
		<td><a href="#ref_date" class="date_ref '.$text_color.'">'.$array_network['started_ref'].'</a></td>
		<td><a href="#up_name_ref" class="up_ref">'.$array_network['leader_ref'].'</a></td>
		<td><a href="#status_ref" class="status_ref '.$text_color.'">'.$array_network['status_ref'].'</a></td>
		<td><a href="?earns_ref='.$array_network['earns_ref'].'" class="cv earns_ref '.$text_color.'">'.$array_network['earns_ref'].'</a></td>
		<td><a href="#actions" class="activity_ref '.$text_color.'">'.$array_network['activity_ref'].'</a></td>
			</tr>';   
			$count++;
			}    	
		}
		echo '</tbody>
	        </table>';
	        echo '<div class="fixed-table-pagination" style=""><div class="float-left pagination-detail"><div class="page-list color-theme">Showing in <div class="btn-group dropdown dropup">
	        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
	        <span class="page-size">
	        10
	        </span>
	        <span class="caret"></span>
	        </button>
	        <div class="dropdown-menu"><a class="dropdown-item active" href="#">10</a><a class="dropdown-item " href="#">25</a><a class="dropdown-item " href="#">50</a><a class="dropdown-item " href="#">100</a><a class="dropdown-item " href="#">All</a></div></div> rows per page</div></div><div class="float-right pagination"><ul class="pagination"><li class="page-item page-pre"><a class="page-link" aria-label="previous page" href="javascript:void(0)">‹</a></li><li class="page-item active"><a class="page-link" aria-label="to page 1" href="javascript:void(0)">1</a></li><li class="page-item"><a class="page-link" aria-label="to page 2" href="javascript:void(0)">2</a></li><li class="page-item"><a class="page-link" aria-label="to page 3" href="javascript:void(0)">3</a></li><li class="page-item"><a class="page-link" aria-label="to page 4" href="javascript:void(0)">4</a></li><li class="page-item"><a class="page-link" aria-label="to page 5" href="javascript:void(0)">5</a></li><li class="page-item page-last-separator disabled"><a class="page-link" aria-label="" href="javascript:void(0)">...</a></li><li class="page-item"><a class="page-link" aria-label="to page 80" href="javascript:void(0)">80</a></li><li class="page-item page-next"><a class="page-link" aria-label="next page" href="javascript:void(0)">›</a></li></ul></div></div>';
		echo '<script>h = parseFloat($("body").height()) + parseFloat($(".table-mobile-ref1").height()) + parseFloat(250); $(".fix").css({"height":h+"px"}); function inif(){ $(".search-input").prop("disabled", false); }</script>';

	}

	function perfil(){
		include "conn.php";
		$user = $_SESSION['email'];
		$get_perfil = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user'");

		echo '<script>function open_file_btn(){

		$("#btn-img").show();
			
		}

		function showpw(){
		
			if($(".pw-user").attr("type") == "password"){
				$(".pw-user").attr("type", "text");
			}else{
				$(".pw-user").attr("type", "password");
			}
		
		}</script>';

		while ($r=mysqli_fetch_array($get_perfil)) {
		
			$idu = $r['id'];
			$get_user = mysqli_query($con, "SELECT * FROM user_config WHERE id_user ='$idu'");
			$user_set = mysqli_fetch_array($get_user);
			$ipgeo = $user_set['ipgeo'];
		  $visible = $user_set['visible'];
			
			if($user_set['conf_theme'] == "light" || $user_set['conf_theme'] == "default"){

				$bg_color = "bg-light";
				$text_color = "color-theme";

			}else if($user_set['conf_theme'] == "dark"){
			
				$bg_color = "bg-dark";
				$text_color = "text-light";

			}

			echo '<div class="card well well-sm '.$bg_color.' card-profile" style="width: 98%;margin: 0px auto !important;">
            	<div class="row">
              	<div class="col-sm-6 col-md-4 py-4">';
          $result = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$user' AND photo > '1'");
					if($row = mysqli_affected_rows($con) >= 1){
						echo '<img id="profileimg" src="php/getImagem.php?user='.$idu.'&ref_name=null" width="200px" height="200px" style="border-radius: 50% 50% 50% 50%;"/>';
					}else{
						echo '<i class="fa fa-user-circle fa-5x" aria-hidden="true"></i>';
					}
          
          $get_rows_dep = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$idu'");
          $rows_dep = mysqli_num_rows($get_rows_dep);

          $get_rows_with = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$idu'");
          $rows_with = mysqli_num_rows($get_rows_with);

          $get_rows_ref = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$user'");
          $rows_ref = mysqli_fetch_array($get_rows_ref);
          $rows_referral= $rows_ref['total_ref'];

          echo '<form method="POST" action="php/imagesperfil/addimg.php" enctype="multipart/form-data" id="form-img">
                  <input id="file_btn_profile" type="file" class="file_btn_profile" name="file" accept="image/*" onclick="open_file_btn();"/>
                    <button id="btn-img" type="submit" class="btn btn-sm bg-default text-dark" style="display:none;">Mudar foto</button>
                    <div id="return-profile-img"></div>
                  </form>
                  <p class="color-theme" style="font-size: 18px;">Nickname: <a href="#" class="text-muted" title="Nickname">'.utf8_encode($r['f_nome']).'</a></p>
                </div>';
          echo '<div class="col-md-4 mt-3" style="font-size: 16px; position: relative;">
				  <span style="font-size: 18px;"><b class="color-theme">Activitys</b></span>
				  <div class="activits_profile '.$text_color.'">Deposits: <a href="#" class="text-muted">'.$rows_dep.'</a></div>
				  <div class="activits_profile '.$text_color.'">Withdraws: <a href="#" class="text-muted">'.$rows_with.'</a></div>
				  <div class="activits_profile '.$text_color.'">Loterrys: <a href="#" class="text-muted">12</a></div>
				  <div class="activits_profile '.$text_color.'">Referrals: <a href="#" class="text-muted">'.$rows_referral.'</a></div>
				  <div class="activits_profile '.$text_color.'">IP: <a href="#" id="ip" class="text-muted">'.base64_decode($ipgeo).'</a></div>
				  <div class="activits_profile '.$text_color.'">> Total deposits <a href="#" class="text-muted">100</a></div>
				  <div class="activits_profile '.$text_color.'">< Total withdraw <a href="#" class="text-muted">170</a></div>
				</div>';
        echo '<div class="col-md-4 mt-3 '.$text_color.' user-info" style="font-size: 16px; position: relative;">

            <span style="font-size: 18px;"><p class="color-theme">User name: <a href="#" class="text-muted" title="First name">'.utf8_encode($r['l_nome']).'</a></p></span>
            <small class="color-theme"><cite>E-mail <i class="glyphicon glyphicon-map-marker">
            </i></cite></small>
            <p>
            <i class="glyphicon glyphicon-envelope"></i><a class="color-theme emailuser">'.$r['email'].'</a>
            <br>
            <i class="glyphicon glyphicon-globe"></i>Password: <input type="password" class="pw-user" name="user password" value="'.$r['pw'].'"><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="28px" viewBox="0 0 24 24" onclick="showpw();" class="bg-dark color-theme vis" style="position:absolute; margin-top: 0px; margin-left: -20px;"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M1 12s4-8 11-8s11 8 11 8s-4 8-11 8s-11-8-11-8"/><circle cx="12" cy="12" r="3"/></g></svg>
            	<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="28px" viewBox="0 0 24 24" onclick="showpw();" class="bg-dark text-primary nov" style="display:none; position:absolute; margin-top: 0px; margin-left: -20px;"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24M1 1l22 22"/></svg>
            <br>
            <i class="glyphicon glyphicon-gift color-theme">Member since: </i><a class="color-theme">'.$r['data'].'</a></p>
       			 <label class="color-theme">Account info</label>';
       			if($visible == "" || $visible == "public"){
       				echo ' - Public  <svg xmlns="http://www.w3.org/2000/svg" class="accountvisible" id="aca" width="30px" height="30px" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M336 208v-95a80 80 0 0 0-160 0v95"/><rect width="320" height="272" x="96" y="208" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" rx="48" ry="48"/></svg>';
       				echo "<br><small>Profile public for users</small>";
       			}else if($visible == "anonymous"){
       				echo ' - Anonymous <svg xmlns="http://www.w3.org/2000/svg" class="accountvisible" id="acv" width="30px" height="30px" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M336 112a80 80 0 0 0-160 0v96"/><rect width="320" height="272" x="96" y="208" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" rx="48" ry="48"/></svg>';
       				echo "<br><small>Profile anonymous for members</small>";
       			}
       			
       			echo '<div class="text-primary account-statusv" style="font-size:14px; height: 20px;"></div>
	              <div class="col mb-3 profile-change-mb">
	              	<a href="#change_pw" class="btn open-mudarsenha bg-theme text-light" onclick="change_pw();">Change password</a>
									<a href="#change_email" class="btn open-mudaremail bg-theme text-light" onclick="change_email();">Change email</a>
	              </div>	
              </div>
            </div>
          </div>
            ';
		
        }
		
	}

	function user_profile(){

		include "conn.php";
		
		$user = $_SESSION['email'];

		$get_perfil = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$user'");
		
		if(isset($user)){
			
				while ($imgr=mysqli_fetch_array($get_perfil)) {

					echo '<img id="profileimg" src="php/imagesperfil/'.$imgr['id'].'.jpg" width="42px" height="42px" style="margin-left: 0px !important; border-radius: 50% 50% 50% 50%;"/>';
				}

			}else{
				echo '<i class="fa fa-user-circle fa-3x" aria-hidden="true" style="width:43px; height:43px; margin-left: 0px !important; border-radius: 50% 50% 50% 50%;"/></i>';
			}
		
		}

	function total_depositado_user(){

		include "conn.php";
		$email = $_SESSION['email'];
		
		$usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($r=mysqli_affected_rows($con) >= 1){
			while ($usracc = mysqli_fetch_array($usr)) {
				$id_user = $usracc['id'];
			}
			$total_depositado = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE id_user ='$id_user' AND status = 1 AND FINISH !='TRUE'");

				if ($r=mysqli_affected_rows($con) >= 1) {
					while ($total=mysqli_fetch_array($total_depositado)) {
					$valor = $total['quantidade'];
					$id_deposit = $total['id'];
					echo "<p class='cv text-muted total-deposited-user' style='display: inline-block;'>".number_format($valor, 2, '.', '')."</p> <i class='fa fa-university fa-1x text-muted' aria-hidden='true'></i>";
				}
	
			}else{
				echo "0.00 <i class='fas fa-level-up-alt fa-1x'></i></p>";
			}

		}

	}

	function total_acc_user(){

		include "conn.php"; 
		$email = $_SESSION['email'];
        
		$total_acc_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($r=mysqli_affected_rows($con) >= 1){
			while ($totalacc = mysqli_fetch_array($total_acc_user)) {
				echo "<p class='cv text-muted total-acc-user' style='display: inline-block;'>".number_format($totalacc['total_acc'], 2, ".", ""). "</p> <i class='fa fa-balance-scale fa-1x text-muted' aria-hidden='true'></i>";
			}
		}else{
			echo "0.00";
		}

	}
	
	function total_acc_user_txt(){

		include "conn.php"; 
		$email = $_SESSION['email'];
        
		$total_acc_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($r=mysqli_affected_rows($con) >= 1){
			
			while ($totalacc = mysqli_fetch_array($total_acc_user)) {
				echo number_format($totalacc['total_acc'], 2, ".", "");
			}

		}else{
			echo "0.00";
		}
		
	}

	function ganho_diario(){
		include  "conn.php";
		$email = $_SESSION['email'];

		$earn_day = mysqli_query($con, "SELECT * FROM info");


		if($r=mysqli_affected_rows($con) >= 1){
			while ($day = mysqli_fetch_array($earn_day)) {
				echo "<p class='text-muted' style='display: inline-block;'>".number_format($day['ganho_diario'], 2, ".", ""). "</p>";
			}

		}else{
			echo "0.00";
		}

	}

	function total_retorno(){

		include  "conn.php";
		$email = $_SESSION['email'];
		
			$total_depositado1 = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");

			if ($r=mysqli_affected_rows($con) >= 1) {
				while ($total1=mysqli_fetch_array($total_depositado1)) {
				
				$total_acc = $total1['total_acc']; //total depositado
		
				$total_earn = $total1['total_amount']; //total gerado

				if($total_acc > 0){
					//$retorno_val = ($total_earn / $total_acc) * 100; 
					echo "<p class='cv text-muted total-profit-user' style='display: inline-block;'>". number_format($total_earn, 2, ".", "") ."</p> <i class='fa fa-pie-chart fa-1x text-muted' aria-hidden='true'></i>";
				}else{
					echo "<p class='text-muted' style='display: inline-block;'>0.00</p> <i class='fa fa-pie-chart fa-1x text-muted' aria-hidden='true'></i>";
				}
			}
		}else{
			echo "0.00";
		}
	}

	function user_coin(){

		include  "conn.php";
		$email = $_SESSION['email'];
		
		$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

		if($row_true = mysqli_affected_rows($con) == 1){
			
			$get_user = mysqli_fetch_array($check_id_user);
			$id = $get_user['id'];
			$get_coin = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");
			
			if($row_update = mysqli_affected_rows($con) >= 1){
			
				$get_user = mysqli_fetch_array($get_coin);
				$coin = $get_user['main_coin'];
				
					if($coin == "btc"){
						$coin_img = "<img id='img-c' class='img-action-sm' style='margin-left:9px;' src='images/coins/btc-sm.png' title='bitcoin' width='27px' height='27px' alt='btc coin deposited'>";
					}else if($coin == "usdt" || $coin == "default" || $coin == ""){
						$coin_img = "<img id='img-c'class='img-action-sm' style='margin-left:9px;' src='images/coins/usdt-sm.png' title='tether' width='27px' height='27px' alt='usdt coin deposited'>";
					}else if($coin == "tron"){
						$coin_img = "<img id='img-c' class='img-action-sm' style='margin-left:9px;' src='images/coins/trx-sm.png' title='tron' width='27px' height='27px' alt='tron coin deposited'>";
					}else if($coin == "busd"){
						$coin_img = "<img id='img-c' class='img-action-sm' style='margin-left:9px;' src='images/coins/busd-sm.png' title='binance' width='27px' height='27px' alt='bnb coin deposited'>";
					}else if($coin == "eth"){
						$coin_img = "<img id='img-c' class='img-actions-sm' style='margin-left:9px;' src='images/coins/eth-sm.png' title='ethereum' width='27px' height='27px' alt='eth coin deposited'>";
					}else if($coin == "ltc"){
						$coin_img = "<img id='img-c' class='img-actions-sm' style='margin-left:9px;' src='images/coins/ltc-sm.png' title='litecoin' width='27px' height='27px' alt='ltc coin deposited'>";
					}

					echo "<p>Values in ".$coin_img." <i class='fa fa-toggle-on fa-2x color-theme' aria-hidden='true' style='cursor: pointer;' onclick='toggleddbtn();'></i></p>";
				
			}
		}
	}

	function count_not(){
		
		include "conn.php";

		$email = $_SESSION['email'];
		
		$check_id = mysqli_query($con, "SELECT * FROM notifications WHERE email = '$email' AND action = 0");
		if($count_not = mysqli_affected_rows($con) >= 1){
			$num_rows = mysqli_num_rows($check_id);
			echo "+".$num_rows;
		}

	}

	function idu(){
		
		include "conn.php";
		session_start();
		$email = $_SESSION['email'];
		
		$check_id = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
		if($count_not = mysqli_affected_rows($con) >= 1){
			$ar_idu = mysqli_fetch_array($check_id);
			echo $ar_idu['id'];
		}
	
	}

?> 