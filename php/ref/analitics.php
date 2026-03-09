<?php /*echo "Acesso direto: 10"; ?>
<?php echo "Total usuarios registrados: 10"; ?>
<?php echo "Total usuarios ativos: 10"; ?>
<?php echo "Total depositado: 10"; ?>
<?php echo "Total withdraw: 10"; ?>
<?php echo "Total earn: 10"; */
session_start();

echo "dd".$idu;

$array_direct_id_user = array();
$array_direct_data = array();

$id_user_main = $array_user['id'];
$check_filter_month = mysqli_query($con, "SELECT * FROM sets_ref_analitics WHERE id_user ='$id_user_main'");

if($rows_check = mysqli_affected_rows($con) >= 1){

	$array_sets_analits = mysqli_fetch_array($check_filter_month);
	$month_current = $array_sets_analits['month_current'];
	$year_current = $array_sets_analits['year'];

}else{

	$month_add = date("m");
	$year = date("Y");
	$add_line_sets = mysqli_query($con, "INSERT INTO sets_ref_analitics (id_user,month_current,year) VALUES ('$id_user_main','$month_add','$year')");
	$month_current = $month_add;
	$year_current = $year;

}

$month_current = date("m");

?> 
<script type="text/javascript">

$(document).ready(function(){
	
	$(".max-limit-graph").on("click", function(){

		str = $(this).attr("id");
		str_by = str.charAt(0)+""+str.charAt(1);
		
		if(str_by == "ad"){
			
			idx = parseFloat(str.replace("ad-","")) - parseFloat(1);
			if($(".dl-ad:eq("+idx+")").attr("class") == "dl-ad bg-theme text-light"){
				$(".dl-ad:eq("+idx+")").removeClass("bg-theme");
				$(".dl-ad:eq("+idx+")").removeClass("text-light");
			}else{
				$(".dl-ad:eq("+idx+")").addClass("bg-theme");
				$(".dl-ad:eq("+idx+")").addClass("text-light");
			}

		}else if(str_by == "ua"){
			
			idx = parseFloat(str.replace("ua-","")) - parseFloat(1);
			if($(".dl-ua:eq("+idx+")").attr("class") == "dl-ua bg-theme text-light"){
				$(".dl-ua:eq("+idx+")").removeClass("bg-theme");
				$(".dl-ua:eq("+idx+")").removeClass("text-light");
			}else{
				$(".dl-ua:eq("+idx+")").addClass("bg-theme");
				$(".dl-ua:eq("+idx+")").addClass("text-light");
			}
			
		}else if(str_by == "ur"){
			
			idx = parseFloat(str.replace("ur-","")) - parseFloat(1);
			if($(".dl-ur:eq("+idx+")").attr("class") == "dl-ur bg-theme text-light"){
				$(".dl-ur:eq("+idx+")").removeClass("bg-theme");
				$(".dl-ur:eq("+idx+")").removeClass("text-light");
			}else{
				$(".dl-ur:eq("+idx+")").addClass("bg-theme");
				$(".dl-ur:eq("+idx+")").addClass("text-light");
			}
			
		}else if(str_by == "tw"){

			idx = parseFloat(str.replace("tw-","")) - parseFloat(1);
			if($(".dl-tw:eq("+idx+")").attr("class") == "dl-tw bg-theme text-light"){
				$(".dl-tw:eq("+idx+")").removeClass("bg-theme");
				$(".dl-tw:eq("+idx+")").removeClass("text-light");
			}else{
				$(".dl-tw:eq("+idx+")").addClass("bg-theme");
				$(".dl-tw:eq("+idx+")").addClass("text-light");
			}
		
		}else if(str_by == "td"){

			idx = parseFloat(str.replace("td-","")) - parseFloat(1);
			if($(".dl-td:eq("+idx+")").attr("class") == "dl-td bg-theme text-light"){
				$(".dl-td:eq("+idx+")").removeClass("bg-theme");
				$(".dl-td:eq("+idx+")").removeClass("text-light");
			}else{
				$(".dl-td:eq("+idx+")").addClass("bg-theme");
				$(".dl-td:eq("+idx+")").addClass("text-light");
			}

		}

	});

});


function show_dad(id) {
	
	if($(".dl-ad:eq("+id+")").attr("class") == "dl-ad bg-theme text-light"){
		$(".dl-ad:eq("+id+")").removeClass("bg-theme");
		$(".dl-ad:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-ad:eq("+id+")").addClass("bg-theme");
		$(".dl-ad:eq("+id+")").addClass("text-light");
	}

}

function remove_show_dad(id) {

	if($(".dl-ad:eq("+id+")").attr("class") == "dl-ad bg-theme text-light"){
		$(".dl-ad:eq("+id+")").removeClass("bg-theme");
		$(".dl-ad:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-ad:eq("+id+")").addClass("bg-theme");
		$(".dl-ad:eq("+id+")").addClass("text-light");
	}

}

function show_dua(id) {
	
	if($(".dl-ua:eq("+id+")").attr("class") == "d-ua bg-theme text-light"){
		$(".dl-ua:eq("+id+")").removeClass("bg-theme");
		$(".dl-ua:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-ua:eq("+id+")").addClass("bg-theme");
		$(".dl-ua:eq("+id+")").addClass("text-light");
	}

}

function remove_show_dua(id) {

	if($(".dl-ua:eq("+id+")").attr("class") == "dl-ua bg-theme text-light"){
		$(".dl-ua:eq("+id+")").removeClass("bg-theme");
		$(".dl-ua:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-ua:eq("+id+")").addClass("bg-theme");
		$(".dl-ua:eq("+id+")").addClass("text-light");
	}

}

function show_dur(id) {
	
	if($(".dl-ur:eq("+id+")").attr("class") == "dl-ur bg-theme text-light"){
		$(".dl-ur:eq("+id+")").removeClass("bg-theme");
		$(".dl-ur:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-ur:eq("+id+")").addClass("bg-theme");
		$(".dl-ur:eq("+id+")").addClass("text-light");
	}

}

function remove_show_dur(id) {

	if($(".dl-ur:eq("+id+")").attr("class") == "dl-ur bg-theme text-light"){
		$(".dl-ur:eq("+id+")").removeClass("bg-theme");
		$(".dl-ur:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-ur:eq("+id+")").addClass("bg-theme");
		$(".dl-ur:eq("+id+")").addClass("text-light");
	}

}

function show_dtw(id) {
	
	if($(".dl-tw:eq("+id+")").attr("class") == "dl-tw bg-theme text-light"){
		$(".dl-tw:eq("+id+")").removeClass("bg-theme");
		$(".dl-tw:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-tw:eq("+id+")").addClass("bg-theme");
		$(".dl-tw:eq("+id+")").addClass("text-light");
	}

}

function remove_show_dtw(id) {

	if($(".dl-tw:eq("+id+")").attr("class") == "dl-tw bg-theme text-light"){
		$(".dl-tw:eq("+id+")").removeClass("bg-theme");
		$(".dl-tw:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-tw:eq("+id+")").addClass("bg-theme");
		$(".dl-tw:eq("+id+")").addClass("text-light");
	}

}

function show_dtd(id) {
	
	if($(".dl-td:eq("+id+")").attr("class") == "dl-td bg-theme text-light"){
		$(".dl-td:eq("+id+")").removeClass("bg-theme");
		$(".dl-td:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-td:eq("+id+")").addClass("bg-theme");
		$(".dl-td:eq("+id+")").addClass("text-light");
	}

}

function remove_show_dtd(id) {

	if($(".dl-td:eq("+id+")").attr("class") == "dl-td bg-theme text-light"){
		$(".dl-td:eq("+id+")").removeClass("bg-theme");
		$(".dl-td:eq("+id+")").removeClass("text-light");
	}else{
		$(".dl-td:eq("+id+")").addClass("bg-theme");
		$(".dl-td:eq("+id+")").addClass("text-light");
	}

}

function att_pg(filter) {
	
	str_filter = ""+filter+"";
	str_month = str_filter.substr(2, 3);
	str_method = str_filter.substr(0, 2);
	analitics = str_filter.substr(0, 1);

	$.post('php/ref/att_analitics.php', {"analitics":analitics,"filter":str_method,"month":str_month}, function(data){
			
		filter = str_method+""+str_month;
		str_method1 = filter.substr(1, 1);
		
		if(str_method1 == 1){

			new_value = str_month;

			if(str_month < 10 && str_month >= 2){
				new_value = filter.substr(3, 3);
			}

			add_value = parseFloat(new_value) - parseFloat(1);
			
			if(add_value < 10){
				new_value = "0"+add_value;
			}
		
			add_new_id = str_method+""+new_value;

		}else{

			new_value = str_month;

			if(str_month < 10){
				new_value = filter.substr(3, 3);
			}

			add_value = parseFloat(new_value) + parseFloat(1);
			
			if(add_value < 10){
				new_value = "0"+add_value;
			}

			add_new_id = str_method+""+new_value;

		}
		
		today = new Date();
		dd = today.getDate();
		//yyyy = today.getFullYear();

		current_filter = filter.charAt(0);
		current_year = $("#d"+current_filter).text();
		
		str_cy3 = current_year.charAt(3);
		str_cy4 = current_year.charAt(4);
		str_cy5 = current_year.charAt(5);
		str_cy6 = current_year.charAt(6);

		str_cy = str_cy3+""+str_cy4+""+str_cy5+""+str_cy6;
	
		if(filter.charAt(1) == current_filter){ //dec

			att_cy = parseFloat(str_cy) - parseFloat(1);
		
		}else{ //inc
		
			att_cy = parseFloat(str_cy) + parseFloat(1);
		
		}
	
		$("#f"+analitics).html("");
		$("#f"+analitics).html(data);
		$("#f"+analitics).attr("id", "f"+analitics);
		$("#d"+analitics).text(new_value+"/"+att_cy);

	});
	
	$("#box-menu").addClass("bg-theme");
	ajust_display();

}

function ajust_display() {

	setTimeout(function(){

		wd = $(".ref-analitics-top").width();

		if(wd < 850){
			
			$("#box-country").css({"width":wd+"px !important"});
		
			$(".fa-angle-right").each(function(){
		
				if($(this).attr("class") == "r1fa max-limit-graph fa fa-angle-right float-right" || $(this).attr("class") == "max-limit-graph fa fa-angle-right float-right"){

					$(this).css({"cursor":"pointer","position":"absolute","float":"right !important","top":"0px"});
		
				}
		
			});

			for (var i = 0; i < 6; i++) {

				idx = parseFloat(i) + parseFloat(1);
				$("#f"+idx+"").attr("class", "col align-graph");
		
				if(i != 1){
		
					for (var ii = 0; ii < 32; ii++) {
						
						$("#f"+idx+" .max-limit-graph:eq("+ii+")").css({"width":"120px", "height":"16px"});	
						d = $("#f"+idx+" .max-limit-graph:eq("+ii+") .percent-col").attr("style");
					
						if(d){

							wd1=d.charAt(49);
							wd2=d.charAt(50);
							if(d.charAt(51) != " " && d.charAt(51) != "" && d.charAt(51) != "%"){
								wd3=d.charAt(51);	
							}else{
								wd3 = "";
							}
							wd_ajust = wd1+""+wd2+""+wd3;
							$("#f"+idx+" .max-limit-graph:eq("+ii+") .percent-col").css({"width":wd_ajust+"%"});
							$("#f"+idx+" .max-limit-graph:eq("+ii+") .percent-col").css({"top":"-15px","left":"60%","height":"90%"});

						}
					
					}	
				
				}
			
			}
		
		}

		$("#box-menu").removeClass("bg-theme");
		
	},500);

}

$("#box-menu").addClass("bg-theme");
ajust_display();

</script>

<div class="fluid-container ref-analitics-top" style="height: 400px;">
	
	<div class="gp-col-6 col-md-12 float-left">
		
		<h3 class="<?php text_color(); ?>">Acesso direto f</h3>
		<small id="d1" class="float-right"><?php echo $month_current."/".$year_current; ?></small>
		<!--<div class="align-prev-next">
			<i id="l" class="fa fa-angle-left float-left" aria-hidden="true"></i>
       		<i id="r" class="fa fa-angle-right float-right" aria-hidden="true"></i>
		</div>-->
		<div id="f1" class="row align-graph">
	
			<?php 

			$count_rows = 0;
			$array_direct_country = array();

			$get_direct_link = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome ='$leader_nome'");
			
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
				$max_access_day = 0;
				$array_max_access_day = array();
				$array_country_access = array();
				$array_country = array();
				$access = 1;

				while($count_data <= $count_rows){
					
					$str = $array_direct_data[$count_data][3];
					$array_m = $array_direct_data[$count_data][0]."".$array_direct_data[$count_data][1];
					$array_country_access[$count_data] = 0;
					
					if($month == $array_m && $array_direct_data[$count_data][3] > $array_direct_data[$count_data+1][3]){

						//$month 
					}

					//check if days == || !=
					if($array_direct_data[$count_data][3+1] == ","){ //check nums < 10

						if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3]){
						
							$array_max_access_day[$max_access_day] = $access; //add +1 access per day
							$array_day[$max_access_day] = $array_direct_data[$count_data][3];

							$access++;
							
						}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3]){
					
							$access = 1;		

							if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3]){
								
								$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
								
							}
							
							if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3]){
								$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
							}

							$array_day[$max_access_day] = $array_direct_data[$count_data][3];

							$max_access_day++; //new count +1 day

						}
					
					}else{ //check nums >= 10

						if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3] && $array_direct_data[$count_data][4] == $array_direct_data[$count_data+1][4]){
						
							$array_max_access_day[$max_access_day] = $access; //add +1 access per day
							$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
					
							$access++;
				
						}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3] || $month == $array_m && $array_direct_data[$count_data][4] != $array_direct_data[$count_data+1][4]){
					
							$access = 1;		

						if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3] && $array_direct_data[$count_data][4] != $array_direct_data[$count_data-1][4]){

							$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
							
						}
						
						if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3] && $array_direct_data[$count_data-1][4] == $array_direct_data[$count_data][4]){

							$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
						}

						$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
						$max_access_day++; //new count +1 day

						}
					}
					
					$count_data++;
				}
				
				$max = 0;
				$max_day = 0;
				while($max < $max_access_day){
					
					if($array_max_access_day[$max+1] >= 1){

						if($max == 0 && $array_max_access_day[$max] >= $array_max_access_day[$max+1]){
							$max_day = $array_max_access_day[$max];
						}else if($max > 0 && $max_day < $array_max_access_day[$max+1]){
							$max_day = $array_max_access_day[$max+1];
						}
					
					}					

					$max++;
				}
			
			}
		
			?>
			<?php 

			$loop_month = 1;
			$max_limit_loop = 31;
			$graph_p_count = 0;
			$run_loop = true;
			$added_day = 0;

			while($loop_month <= $max_limit_loop) {
				
				if($loop_month == 1){
					echo '<i id="l" class="l1fa max-limit-graph fa fa-angle-left float-left" aria-hidden="true" onclick="att_pg(11'.$month.');"></i>';
				}
				if($array_max_access_day[$graph_p_count] > 0 && $array_day[$added_day] == $loop_month){

					$graph_percent_show = ($array_max_access_day[$graph_p_count] / $max_day) * 100;
					if($graph_percent_show > 100){
						$graph_percent_show = 100;
					}
					$top = 100 - $graph_percent_show + 3;
					$day_added = $array_day[$added_day];
					$loop_monthidx = $loop_month - 1;
					echo '<div class="bd max-limit-graph" id="ad-'.$loop_month.'" onmouseenter="show_dad('.$loop_monthidx.');" onmouseout="remove_show_dad('.$loop_monthidx.');">'.$loop_month.'<div class="bg-theme percent-col" title='.$array_max_access_day[$graph_p_count].' style="position: relative; top:'.$top.'%; width: 100%; height: '.$graph_percent_show.'%; "></div>
					</div>';

					$added_day++;
					$graph_p_count++;

				}else{

					echo '<div class="bd max-limit-graph">'.$loop_month.'</div>';

				}
				if($loop_month == 31){
					echo '<i id="r" class="r1fa max-limit-graph fa fa-angle-right float-right" aria-hidden="true" onclick="att_pg(12'.$month.');"></i>';
				}
				$loop_month++;
			}

			for ($i=0; $i < $count_data; $i++) { 
				$array_direct_id_user[$i] = 0;
				$array_direct_data[$i] = 0;
			}
			?>
			
			<div class="row row-d-bd">
				<nav class="nav-access">
					<ul>
					<?php 

					$loop_month = 1;
					$max_limit_loop = 30;
					$access_p_day = 0;
					$added_day = 0;

					while ($loop_month <= $max_limit_loop) {
						
						if($array_max_access_day[$access_p_day] > 0 && $array_day[$added_day] == $loop_month){

							$days = $array_max_access_day[$access_p_day];
							$added_day++;
							$access_p_day++;

						}else{

							$days = 0;

						}
						
											
						echo '<li class="dl-ad">'.$loop_month.': <a href="#"></a> '.$days.' </li>';
						

						$loop_month++;
					}
					?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<div class="gp-col-6 col-md-12 float-right">
		<h3 class="<?php text_color(); ?>">Access by country</h3>
		<small id="d2" class="float-right"><?php echo $month_current."/".$year_current; ?></small>
		<nav id="f2" class="nav-flags-analitics nav nav-country align-graph" style="max-height: 210px;">
			
			<?php 

			echo '<div id="box-country" style="float: left !important; width: 700px;height: 30px;" class="col-12"><i id="l" aria-hidden="true" onclick="att_pg(21'.$month_current.');" class="col-2 fa fa-angle-left float-left"></i><i id="r" aria-hidden="true" onclick="att_pg(22'.$month_current.');" style="float: right !important;" class="col-2 fa fa-angle-right float-right"></i></div>';
			?>
			
			<?php
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

			$get_direct_link = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome ='$leader_nome'");
				
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

				//start show country list
				echo "<ul>";
				while ($num_rows_flag <= $add_access) {
				
					$array_m = $array_direct_data[$num_rows_flag][0]."".$array_direct_data[$num_rows_flag][1];
					if($array_country[$num_rows_flag] != ""){
					
						$flag = strtolower($array_country[$num_rows_flag]);
						$access_per_country = $array_country_access[$num_rows_flag];
						echo '<li class="nav-item"><a href="#"><img src="images/flags/'.$flag.'.svg" width="20" height="20"></a>&nbsp '.$access_per_country.'</li>';	
						
					}
					
					$num_rows_end = $num_rows_flag % 7;

					if($num_rows_flag != $add_access && $num_rows_flag > 0 && $num_rows_end == 0 || $num_rows_flag == $add_access && $num_rows_flag != $add_access) {
						echo "</ul><ul>"; 
					}

					if($num_rows_flag == $add_access){
						echo "<ul>";
					}

					$num_rows_flag++;

				}
				//end show country list
			}
			?>	
		</nav>
	</div>
	<div class="gp-col-6 col-md-12 float-right">
		<h3 class="<?php text_color(); ?>">Usuarios registrados</h3>
		<small id="d3" class="float-right"><?php echo $month_current."/".$year_current; ?></small>
		<div id="f3" class="row align-graph">
		<?php

		$count_rows = 0;
		
		$get_direct_user_sponsor = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor ='$leader_nome'");
		
		$count_ar_id = 0;
		if($rows_user = mysqli_affected_rows($con) >= 1){

			while($array_direct_user_sponsor = mysqli_fetch_array($get_direct_user_sponsor)){

				$array_direct_id_user[$count_ar_id] = $array_direct_id_user[$count_ar_id] + 1;
				$array_direct_data[$count_ar_id] = $array_direct_user_sponsor['data'];
				$count_ar_id++;
				
			}
		}

		$count_data = 0;
		$num_day = 0;
		$month = $month_current;
		$day = date("j");
		$array_day = array();
		$max_access_day = 0;
		$array_max_access_day = array();
		$array_country_access = array();
		$array_country = array();
		$access = 1;

		while($count_data <= $count_ar_id){
			
			$str = $array_direct_data[$count_data][3];
			$array_m = $array_direct_data[$count_data][0]."".$array_direct_data[$count_data][1];
			$array_country_access[$count_data] = 0;
			
			if($month == $array_m && $array_direct_data[$count_data][3] > $array_direct_data[$count_data+1][3]){

				//$month 
			}
	
			//check if days == || !=
			if($array_direct_data[$count_data][3+1] == ","){ //check nums < 10
			
				if($count_ar_id < 2 && $month == $array_m){
					
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];
					$max_access_day++;

				}else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$access++;
					
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3]){
			
					$access = 1;		

					if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3]){
						
						$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
						
					}
					
					if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3]){
						$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
					}

					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$max_access_day++; //new count +1 day

				}
			
			}else{ //check nums >= 10

				if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3] && $array_direct_data[$count_data][4] == $array_direct_data[$count_data+1][4]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
			
					$access++;
		
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3] || $month == $array_m && $array_direct_data[$count_data][4] != $array_direct_data[$count_data+1][4]){
			
					$access = 1;		

				if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3] && $array_direct_data[$count_data][4] != $array_direct_data[$count_data-1][4]){

					$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
					
				}
				
				if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3] && $array_direct_data[$count_data-1][4] == $array_direct_data[$count_data][4]){

					$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
				}

				$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
				$max_access_day++; //new count +1 day

				}
			}
			
			$count_data++;
		}
		
		$max = 0;
		$max_day = 0;
		while($max < $max_access_day){
			
			if($max == 0 && $array_max_access_day[$max] >= $array_max_access_day[$max+1]){
				$max_day = $array_max_access_day[$max];
			}else if($max == 0 && $array_max_access_day[$max] < $array_max_access_day[$max+1]){
				$max_day = $array_max_access_day[$max+1];
			}else if($max > 0 && $max_day < $array_max_access_day[$max+1]){
				$max_day = $array_max_access_day[$max+1];
			}

			$max++;
		}		
		
		?>
		<?php 

		$loop_month = 1;
		$max_limit_loop = 31;
		$graph_p_count = 0;
		$run_loop = true;
		$added_day = 0;

		while($loop_month <= $max_limit_loop) {
			
			if($loop_month == 1){
				echo '<i id="l" class="max-limit-graph fa fa-angle-left float-left" aria-hidden="true"  onclick="att_pg(31'.$month.');"></i>';
			}

			if($array_max_access_day[$graph_p_count] > 0 && $array_day[$added_day] == $loop_month){

				$graph_percent_show = ($array_max_access_day[$graph_p_count] / $max_day) * 100;
				if($graph_percent_show > 100){
					$graph_percent_show = 100;
				}
				$top = 100 - $graph_percent_show + 3;
				$day_added = $array_day[$added_day];
				$loop_monthidx = $loop_month - 1;
				echo '<div class="bd max-limit-graph" id="ur-'.$loop_month.'" onmouseenter="show_dur('.$loop_monthidx.');" onmouseout="remove_show_dur('.$loop_monthidx.');">'.$loop_month.'<div class="bg-theme percent-col" title='.$array_max_access_day[$graph_p_count].' style="position: relative; top:'.$top.'%; width: 100%; height: '.$graph_percent_show.'%; "></div>
				</div>';

				$added_day++;
				$graph_p_count++;

			}else{

				echo '<div class="bd max-limit-graph">'.$loop_month.'</div>';

			}
			if($loop_month == 31){

				echo '<i id="r" class="max-limit-graph fa fa-angle-right float-right" aria-hidden="true" onclick="att_pg(32'.$month.');"></i>';
			}
			$loop_month++;
		}

		for ($i=0; $i < $count_data; $i++) { 
				$array_direct_id_user[$i] = 0;
				$array_direct_data[$i] = 0;
			}
		?>			

			<div class="row row-d-bd">
				<nav>
					<ul>
					<?php 

					$loop_month = 1;
					$max_limit_loop = 30;
					$access_p_day = 0;
					$added_day = 0;

					while ($loop_month <= $max_limit_loop) {
						
						if($array_max_access_day[$access_p_day] > 0 && $array_day[$added_day] == $loop_month){

							$days = $array_max_access_day[$access_p_day];
							$added_day++;
							$access_p_day++;

						}else{

							$days = 0;

						}
												
						echo '<li class="dl-ur">'.$loop_month.': <a href="#"></a> '.$days.' </li>';

						$loop_month++;
					}
					?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<div class="gp-col-6 col-md-12 float-left">
		<h3 class="<?php text_color(); ?>">Usuarios ativos</h3>
		<small id="d4" class="float-right"><?php echo $month_current."/".$year_current; ?></small>
		<div id="f4" class="row align-graph">		
		<?php

		$count_rows = 0;
		
		$get_direct_dep_id = mysqli_query($con, "SELECT * FROM data_dep_pay WHERE id > 0");
		
		$count_ar_id = 0;
		while($array_direct_user_id = mysqli_fetch_array($get_direct_dep_id)){

			$id_charnum = $array_direct_user_id['id_charnum'];

			$cmp_id = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_charnum'");
		
			$array_id_user = mysqli_fetch_array($cmp_id);

			$id_charnum_user = $array_id_user['id_dep'];
		
			$cmp_dep_id = mysqli_query($con, "SELECT * FROM deposits WHERE id = '$id_charnum_user'");
			$array_dep_user = mysqli_fetch_array($cmp_dep_id);
			$id_dep_user = $array_dep_user['id_user'];

			$cmp_user = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_dep_user' AND sponsor = '$leader_nome'");

			if($rows_user = mysqli_affected_rows($con) >= 1){

				$array_user_data = mysqli_fetch_array($cmp_user);
				$array_direct_id_user[$count_ar_id] = $array_direct_id_user[$count_ar_id] + 1;
				$array_direct_data[$count_ar_id] = $array_user_data['data'];
				$count_ar_id++;
			}
			
		}

		$count_data = 0;
		$num_day = 0;
		$month = $month_current;
		$day = date("j");
		$array_day = array();
		$max_access_day = 0;
		$array_max_access_day = array();
		$array_country_access = array();
		$array_country = array();
		$access = 1;

		while($count_data <= $count_ar_id){
			
			$str = $array_direct_data[$count_data][3];
			$array_m = $array_direct_data[$count_data][0]."".$array_direct_data[$count_data][1];
			$array_country_access[$count_data] = 0;
			
			if($month == $array_m && $array_direct_data[$count_data][3] > $array_direct_data[$count_data+1][3]){

				//$month 
			}
	
			//check if days == || !=
			if($array_direct_data[$count_data][3+1] == ","){ //check nums < 10
			
				if($count_ar_id < 2 && $month == $array_m){
					
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];
					$max_access_day++;

				}else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$access++;
					
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3]){
			
					$access = 1;		

					if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3]){
						
						$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
						
					}
					
					if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3]){
						$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
					}

					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$max_access_day++; //new count +1 day

				}
			
			}else{ //check nums >= 10

				if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3] && $array_direct_data[$count_data][4] == $array_direct_data[$count_data+1][4]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
			
					$access++;
		
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3] || $month == $array_m && $array_direct_data[$count_data][4] != $array_direct_data[$count_data+1][4]){
			
					$access = 1;		

				if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3] && $array_direct_data[$count_data][4] != $array_direct_data[$count_data-1][4]){

					$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
					
				}
				
				if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3] && $array_direct_data[$count_data-1][4] == $array_direct_data[$count_data][4]){

					$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
				}

				$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
				$max_access_day++; //new count +1 day

				}
			}
			
			$count_data++;
		}
		
		$max = 0;
		$max_day = 0;
		while($max < $max_access_day){
			
			if($array_max_access_day[$max+1] >= 1){

				if($array_max_access_day[$max] >= $array_max_access_day[$max+1]){
					$max_day = $array_max_access_day[$max];
				}else{
					$max_day = $array_max_access_day[$max+1];
				}
		
			}else{
		
				$max_day = 1;
			}						

			$max++;
		}		
		
		?>
		<?php 

		$loop_month = 1;
		$max_limit_loop = 31;
		$graph_p_count = 0;
		$run_loop = true;
		$added_day = 0;

		while($loop_month <= $max_limit_loop) {
		
			if($loop_month == 1){
				echo '<i id="l" class="max-limit-graph fa fa-angle-left float-left" aria-hidden="true"  onclick="att_pg(41'.$month.');"></i>';
			}
			if($array_max_access_day[$graph_p_count] > 0 && $array_day[$added_day] == $loop_month){

				$graph_percent_show = ($array_max_access_day[$graph_p_count] / $max_day) * 100;
				if($graph_percent_show > 100){
					$graph_percent_show = 100;
				}
				$top = 100 - $graph_percent_show + 3;
				$day_added = $array_day[$added_day];
				$loop_monthidx = $loop_month - 1;
				echo '<div class="bd max-limit-graph" id="ua-'.$loop_month.'" onmouseenter="show_dua('.$loop_monthidx.');" onmouseout="remove_show_dua('.$loop_monthidx.');">'.$loop_month.'<div class="bg-theme percent-col" title='.$array_max_access_day[$graph_p_count].' style="position: relative; top:'.$top.'%; width: 100%; height: '.$graph_percent_show.'%; "></div>
				</div>';

				$added_day++;
				$graph_p_count++;

			}else{

				echo '<div class="bd max-limit-graph">'.$loop_month.'</div>';

			}
			if($loop_month == 31){
				echo '<i id="r" class="max-limit-graph fa fa-angle-right float-right" aria-hidden="true" onclick="att_pg(42'.$month.');"></i>';
			}
			$loop_month++;
		}

		?>

			<div class="row row-d-bd">
			<nav>
				<ul>
				<?php 

				$loop_month = 1;
				$max_limit_loop = 30;
				$access_p_day = 0;
				$added_day = 0;

				while ($loop_month <= $max_limit_loop) {
					
					if($array_max_access_day[$access_p_day] > 0 && $array_day[$added_day] == $loop_month){

						$days = $array_max_access_day[$access_p_day];
						$added_day++;
						$access_p_day++;

					}else{

						$days = 0;

					}
											
					echo '<li class="dl-ua">'.$loop_month.': <a href="#"></a> '.$days.' </li>';

					$loop_month++;
				}
				?>
				</ul>
			</nav>
			</div>
		</div>
	</div>
	<div class="gp-col-6 col-md-12 float-right">
		<h3 class="<?php text_color(); ?>">Total withdraw</h3>
		<small id="d5" class="float-right"><?php echo $month_current."/".$year_current; ?></small>
		<?php

		$count_rows = 0;
		
		$get_direct_saque_id = mysqli_query($con, "SELECT * FROM saque WHERE id > 0");
		
		$count_ar_id = 0;
		while($array_direct_saque_id = mysqli_fetch_array($get_direct_saque_id)){

			if($array_direct_saque_id['status'] == "1"){

				$id_charnum = $array_direct_saque_id['id_user'];
			
				$cmp_user = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_charnum' AND sponsor = '$leader_nome'");

				if($rows_user = mysqli_affected_rows($con) >= 1){

					$array_direct_id_user[$count_ar_id] = $array_direct_id_user[$count_ar_id] + 1;
					$array_direct_data[$count_ar_id] = $array_direct_saque_id['data'];
					$count_ar_id++;
				}
			}
		}

		$count_data = 0;
		$num_day = 0;
		$month = $month_current;
		$day = date("j");
		$array_day = array();
		$max_access_day = 0;
		$array_max_access_day = array();
		$array_country_access = array();
		$array_country = array();
		$access = 1;

		while($count_data <= $count_ar_id){
			
			$str = $array_direct_data[$count_data][3];
			$array_m = $array_direct_data[$count_data][0]."".$array_direct_data[$count_data][1];
			$array_country_access[$count_data] = 0;
			
			if($month == $array_m && $array_direct_data[$count_data][3] > $array_direct_data[$count_data+1][3]){

				//$month 
			}
	
			//check if days == || !=
			if($array_direct_data[$count_data][3+1] == ","){ //check nums < 10
			
				if($count_ar_id < 2 && $month == $array_m){
					
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];
					$max_access_day++;

				}else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$access++;
					
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3]){
			
					$access = 1;		

					if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3]){
						
						$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
						
					}
					
					if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3]){
						$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
					}

					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$max_access_day++; //new count +1 day

				}
			
			}else{ //check nums >= 10

				if($count_ar_id < 2 && $month == $array_m){
					
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
					$max_access_day++;

				}else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3] && $array_direct_data[$count_data][4] == $array_direct_data[$count_data+1][4]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
			
					$access++;
		
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3] || $month == $array_m && $array_direct_data[$count_data][4] != $array_direct_data[$count_data+1][4]){
			
					$access = 1;		

				if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3] && $array_direct_data[$count_data][4] != $array_direct_data[$count_data-1][4]){

					$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
					
				}
				
				if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3] && $array_direct_data[$count_data-1][4] == $array_direct_data[$count_data][4]){

					$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
				}

				$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
				$max_access_day++; //new count +1 day

				}
			}
			
			$count_data++;
		}
		
		$max = 0;
		$max_day = 0;
		while($max < $max_access_day){
			
			if($array_max_access_day[$max+1] >= 1){

				if($array_max_access_day[$max] >= $array_max_access_day[$max+1]){
					$max_day = $array_max_access_day[$max];
				}else{
					$max_day = $array_max_access_day[$max+1];
				}
		
			}else{
		
				$max_day = 1;
			}						

			$max++;
		}		
		
		?>
		<div id="f5" class="row align-graph">
			
			<?php 

			$loop_month = 1;
			$max_limit_loop = 31;
			$graph_p_count = 0;
			$run_loop = true;
			$added_day = 0;

			while($loop_month <= $max_limit_loop) {
				
				if($loop_month == 1){
					echo '<i id="l" class="max-limit-graph fa fa-angle-left float-left" aria-hidden="true" onclick="att_pg(51'.$month.');"></i>';
				}
				if($array_max_access_day[$graph_p_count] > 0 && $array_day[$added_day] == $loop_month){

					$graph_percent_show = ($array_max_access_day[$graph_p_count] / $max_day) * 100;
					if($graph_percent_show > 100){
						$graph_percent_show = 100;
					}
					$top = 100 - $graph_percent_show + 3;
					$day_added = $array_day[$added_day];
					$loop_monthidx = $loop_month - 1;
					echo '<div class="bd max-limit-graph" id="tw-'.$loop_month.'" onmouseenter="show_dtw('.$loop_monthidx.');" onmouseout="remove_show_dtw('.$loop_monthidx.');">'.$loop_month.'<div class="bg-theme percent-col" title='.$array_max_access_day[$graph_p_count].' style="position: relative; top:'.$top.'%; width: 100%; height: '.$graph_percent_show.'%; "></div>
					</div>';

					$added_day++;
					$graph_p_count++;

				}else{

					echo '<div class="bd max-limit-graph">'.$loop_month.'</div>';

				}
				if($loop_month == 31){
					echo '<i id="r" class="max-limit-graph fa fa-angle-right float-right" aria-hidden="true" onclick="att_pg(52'.$month.');"></i>';
				}
				$loop_month++;
			}

			?>
			
			<div class="row row-d-bd">
				<nav>
					<ul>
					<?php 

					$loop_month = 1;
					$max_limit_loop = 30;
					$access_p_day = 0;
					$added_day = 0;

					while ($loop_month <= $max_limit_loop) {
						
						if($array_max_access_day[$access_p_day] > 0 && $array_day[$added_day] == $loop_month){

							$days = $array_max_access_day[$access_p_day];
							$added_day++;
							$access_p_day++;

						}else{

							$days = 0;

						}
												
						echo '<li class="dl-tw">'.$loop_month.': <a href="#"></a> '.$days.' </li>';
						
						$loop_month++;
					}

					?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<div class="gp-col-6 col-md-12 float-left">
		<h3 class="<?php text_color(); ?>">Total deposit</h3>
		<small id="d6" class="float-right"><?php echo $month_current."/".$year_current; ?></small>
		<?php

		$count_rows = 0;
		
		$get_direct_deposit_id = mysqli_query($con, "SELECT * FROM deposits WHERE id > 0");
		
		$count_ar_id = 0;
		while($array_direct_deposit_id = mysqli_fetch_array($get_direct_deposit_id)){

			if($array_direct_deposit_id['status'] == "1"){

				$id_charnum = $array_direct_deposit_id['id_user'];
			
				$cmp_user = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_charnum' AND sponsor = '$leader_nome'");

				if($rows_user = mysqli_affected_rows($con) >= 1){

					$array_direct_id_user[$count_ar_id] = $array_direct_id_user[$count_ar_id] + 1;
					$array_direct_data[$count_ar_id] = $array_direct_deposit_id['data'];
					$count_ar_id++;
				}
			}
		}

		$count_data = 0;
		$num_day = 0;
		$month = $month_current;
		$day = date("j");
		$array_day = array();
		$max_access_day = 0;
		$array_max_access_day = array();
		$array_country_access = array();
		$array_country = array();
		$access = 1;

		while($count_data <= $count_ar_id){
			
			$str = $array_direct_data[$count_data][3];
			$array_m = $array_direct_data[$count_data][0]."".$array_direct_data[$count_data][1];
			$array_country_access[$count_data] = 0;
			
			if($month == $array_m && $array_direct_data[$count_data][3] > $array_direct_data[$count_data+1][3]){

				//$month 
			}
	
			//check if days == || !=
			if($array_direct_data[$count_data][3+1] == ","){ //check nums < 10
			
				if($count_ar_id < 2 && $month == $array_m){
					
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];
					$max_access_day++;

				}else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$access++;
					
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3]){
			
					$access = 1;		

					if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3]){
						
						$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
						
					}
					
					if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3]){
						$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
					}

					$array_day[$max_access_day] = $array_direct_data[$count_data][3];

					$max_access_day++; //new count +1 day

				}
			
			}else{ //check nums >= 10

				if($count_ar_id < 2 && $month == $array_m){
					
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
					$max_access_day++;

				}else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3] && $array_direct_data[$count_data][4] == $array_direct_data[$count_data+1][4]){
				
					$array_max_access_day[$max_access_day] = $access; //add +1 access per day
					$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
			
					$access++;
		
				}else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3] || $month == $array_m && $array_direct_data[$count_data][4] != $array_direct_data[$count_data+1][4]){
			
					$access = 1;		

				if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3] && $array_direct_data[$count_data][4] != $array_direct_data[$count_data-1][4]){

					$array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
					
				}
				
				if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3] && $array_direct_data[$count_data-1][4] == $array_direct_data[$count_data][4]){

					$array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
				}

				$array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
				$max_access_day++; //new count +1 day

				}
			}
			
			$count_data++;
		}
		
		$max = 0;
		$max_day = 0;
		while($max < $max_access_day){
			
			if($array_max_access_day[$max+1] >= 1){

				if($array_max_access_day[$max] >= $array_max_access_day[$max+1]){
					$max_day = $array_max_access_day[$max];
				}else{
					$max_day = $array_max_access_day[$max+1];
				}
		
			}else{
		
				$max_day = 1;
			}						

			$max++;
		}		
		
		?>
		<div id="f6" class="row align-graph">
			
			<?php 

			$loop_month = 1;
			$max_limit_loop = 31;
			$graph_p_count = 0;
			$run_loop = true;
			$added_day = 0;

			while($loop_month <= $max_limit_loop) {

				if($loop_month == 1){
					echo '<i id="l" class="max-limit-graph fa fa-angle-left float-left" aria-hidden="true" onclick="att_pg(61'.$month.');"></i>';
				}	
				if($array_max_access_day[$graph_p_count] > 0 && $array_day[$added_day] == $loop_month){

					$graph_percent_show = ($array_max_access_day[$graph_p_count] / $max_day) * 100;
					if($graph_percent_show > 100){
						$graph_percent_show = 100;
					}
					$top = 100 - $graph_percent_show + 3;
					$day_added = $array_day[$added_day];
					$loop_monthidx = $loop_month - 1;
					echo '<div class="bd max-limit-graph" id="td-'.$loop_month.'" onmouseenter="show_dtd('.$loop_monthidx.');" onmouseout="remove_show_dtd('.$loop_monthidx.');">'.$loop_month.'<div class="bg-theme percent-col" title='.$array_max_access_day[$graph_p_count].' style="position: relative; top:'.$top.'%; width: 100%; height: '.$graph_percent_show.'%; "></div>
					</div>';

					$added_day++;
					$graph_p_count++;

				}else{

					echo '<div class="bd max-limit-graph">'.$loop_month.'</div>';

				}
				if($loop_month == 31){
					echo '<i id="r" class="max-limit-graph fa fa-angle-right float-right" aria-hidden="true" onclick="att_pg(62'.$month.');"></i>';
				}
				$loop_month++;
			}

			?>
		
			<div class="row row-d-bd">
				<nav>
					<ul>
					<?php 

					$loop_month = 1;
					$max_limit_loop = 30;
					$access_p_day = 0;
					$added_day = 0;

					while ($loop_month <= $max_limit_loop) {
						
						if($array_max_access_day[$access_p_day] > 0 && $array_day[$added_day] == $loop_month){

							$days = $array_max_access_day[$access_p_day];
							$added_day++;
							$access_p_day++;

						}else{

							$days = 0;

						}
												
						echo '<li class="dl-td">'.$loop_month.': <a href="#"></a> '.$days.' </li>';

						$loop_month++;
					}

					?>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<!--<div class="gp-col-6 col-md-12 float-left" style="height: 250px;">
		<h3 class="<?php text_color(); ?>">Total earn</h3>

		<div class="row align-graph">
			<div class="bd max-limit-graph">
				1<div class="bg-theme percent-col" title="20" style="position: relative; top:80%; width: 100%; height: 20%; ">20</div>
			</div>
			<div class="row row-d-bd">
				<nav>
					<ul>
						<li>1:<a href="#"></a> 10</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>-->
</div>
