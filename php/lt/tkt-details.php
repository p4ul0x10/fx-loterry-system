<?php

	include "../conn.php";

	session_start();
	$id_lt_tkt = $_POST['id'];
	$email = $_SESSION['email'];
	ini_set( 'display_errors', 0);

	$email = $_SESSION['email'];

	$check_id_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$email'");

	if($row_true = mysqli_affected_rows($con) >= 1){
		
		$get_user = mysqli_fetch_array($check_id_user);
		$id = $get_user['id'];
		
		$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");

		if($row_true = mysqli_affected_rows($con) >= 1){
		
			$get_user = mysqli_fetch_array($get_theme);
			
			if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

				$bg = "bg-light";
				$txt = "color-theme";

			}else if($get_user['conf_theme'] == "dark"){
			
				$bg = "bg-dark";
				$txt = "text-light";

			}

		}

	}

	if(is_string($id_lt_tkt)){
		
		$id_post = str_split($id_lt_tkt);
		$str_id_post0 = $id_post[0]."".$id_post[1]."".$id_post[2]."".$id_post[3]."".$id_post[4]."".$id_post[5]."".$id_post[6]."".$id_post[7]."";
		$num_str_id = str_replace($str_id_post0."-","",$id_lt_tkt);

		$total_tkt = 0;
		$count = 0;
		$f = false;
		$ar_num = array();
		
		$get_info_server = mysqli_query($con, "SELECT * FROM info WHERE id = '1'");
		
		$ar_get_info_server = mysqli_fetch_array($get_info_server);
		$lt_current_session = $ar_get_info_server['lt_session'];

		$query_tkts = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE rel_package LIKE '%$str_id_post0%' AND current_session = '$lt_current_session'");
		
		//start order && package details
		if($rorder = mysqli_affected_rows($con) >= 1){

			while($array_tkt_ids = mysqli_fetch_array($query_tkts)){
			 		
				//start all orders by package -> get info
				$id_post1 = str_split($array_tkt_ids['rel_package']);
				$str_id_post1 = $id_post1[0]."".$id_post1[1]."".$id_post1[2]."".$id_post1[3]."".$id_post1[4]."".$id_post1[5]."".$id_post1[6]."".$id_post1[7]."";
				$num_str_id1 = str_replace($str_id_post1."-","",$array_tkt_ids['rel_package']);

				if($str_id_post0 == $str_id_post1){

					$ar_btkt_id = $array_tkt_ids['id_user'];
					$ar_num[$count] = $array_tkt_ids['value'];
					$total_tkt = $total_tkt + $array_tkt_ids['value'];
					$count++;				

					$get_user_data = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$ar_btkt_id'");
					$ar_user_data = mysqli_fetch_array($get_user_data);

					$f_name = $ar_user_data['f_nome'];
					$user_status_on_of = $ar_user_data['status_on_of'];
					
					if($user_status_on_of == "0" || $user_status_on_of == ""){
						$sts_on_of = "bg-danger";
					}else{
						$sts_on_of = "bg-success";
					}
				
				}
				//end

				//start order -> get info
				if($num_str_id == $num_str_id1 && $f == false){
					
					$id_order = $id_lt_tkt;
					$total_order = $array_tkt_ids['value'];
					$data_order = $array_tkt_ids['data'];
					$f = true;

				}
				//end

			}
			//end 

			$max_tkt_l = 500;
			$max_tkt = ($ar_num[$count-1] / $max_tkt_l) * 100;
			$ar_percent = array();

			for ($i=0; $i < $count; $i++) { 
				
				$percent = ($ar_num[$i] / $max_tkt_l) * 100;
				$percent1 = ($percent / $max_tkt) * 100;
				$ar_percent[$i] = $percent1;	
		
			}

		}

	}

	$info_server = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
	$ar_info = mysqli_fetch_array($info_server);

?>
<style type="text/css">
	.modal-tkt-lb { display:block; margin-top:50px; display: flex; }
	.lt-tkt-img { border-radius: 50% 50% 50% 50%; margin: 0px auto !important; }
</style>
<div class="modal modal-tkt-lb" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header text-light">
	    <h5 class="modal-title">#<?php echo $id_lt_tkt; ?></h5>
	    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="modal-body">
	    <div class="card <?php echo $bg; ?>" style="width: 100%;"> 		  
			<div class="card-body col-12">
				<div class="col-5 float-left lt-modal-padding">
					<img id="profileimg" class="lt-tkt-img" src="php/getImagem.php?user=<?php echo $ar_btkt_id; ?>&ref_name=null" width="100px" height="100px"/>
					<div class="container float-left" style="padding: 0px;">
						<span class="<?php echo $txt; ?>" style="position: relative; left: -5px;"><?php echo $f_name; ?> 
						</span>
						<a class="<?php echo $sts_on_of; ?> user-status" href="#"></a>
					</div>
				</div>	
				<div class="col-5 float-right lt-modal-padding">	
					<p class="<?php echo $txt; ?> font-weight-bold">Loterry bet info<?php /*echo $id_order;*/ ?></p>
				    <div class="fluid-container">
				    	<p class="text-success" style="padding: 0px; margin: 0px;">Tickets: + <?php echo $total_order; ?> <img src="open-iconic-master/png/tag-3x.png" width="13" height="13"></p>
				    	<small class="<?php echo "text-muted"; ?> mg-0"><?php echo $data_order; ?></small>				
				    	<p class="text-success mt-2" style="padding: 0px; margin: 0px;">Total: <?php echo $total_tkt; ?> <img src="open-iconic-master/png/tag-3x.png" width="13" height="13"></p>
							<style type="text/css">
								.gp-t{ float: left; display:block; margin: 0px 2px; }
							</style>
				    </div>
				</div>
				<div class="container float-left mt-5">
					<p class="<?php echo $txt; ?> font-weight-bold">Tickets by package</p>
					<div class="col" style="display: flex;">
						<div style="margin: 0px auto;">
							<ul>
							<?php
				
								for ($i = $count-1; $i >= 0; $i--) { 
									echo '<li class="box-l btn btn-sm float-left bg-success ml-1 mr-1 mb-1">
	               <a href="#tkts-line" id="'.$str_id_post0.'" class="lt-tkt-box-b text-light">+ '.$ar_num[$i].'<img src="open-iconic-master/png/tag-3x.png" width="10px" height="10px"></a></li>';
								}
					
							?>
							</ul>
						</div>
					</div>
					<small class="<?php echo "text-muted"; ?> mg-0">Current data time: <?php echo date("m,j,Y g:i a"); ?></small>
				</div>
				</div>
	  	</div>
	</div>
	</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    
    $(".close").click(function(){
      $(".modal-tkt-lb").remove();
    });

    len_num_t = $(".num-tkt-g").length;

    for (var i = 0; i < len_num_t; i++) {
    	
    	/*w = $(".num-tkt-g:eq("+i+")").width();
    	
    	sw = parseFloat(30) - parseFloat(w);
    	dw = parseFloat(sw) / parseFloat(2);*/

    	num1 = $(".num-tkt-g:eq("+i+")").text().charAt(0);
    	num2 = $(".num-tkt-g:eq("+i+")").text().charAt(1);
    	num3 = $(".num-tkt-g:eq("+i+")").text().charAt(2);
    
    	if(num3 == "" || num3 == "undefined"){
    		sw = parseFloat(30) - (14.61);
    		dw = parseFloat(sw) / parseFloat(2);
    	}else{
    		sw = parseFloat(30) - (21.91);
    		dw = parseFloat(sw) / parseFloat(2);
    	}

    	$(".num-tkt-g:eq("+i+")").css({"position":"absolute", "font-size":"13px", "left":dw+"px"});
    
    }

  });

  if($(".lights").attr("id") == "#light"){
  			
		$(".modal-content").removeClass("bg-dark");
		$(".modal-content").addClass("bg-light");
		$(".modal-content").removeClass("text-light");
		$(".modal-content").addClass("color-theme");

		$(".modal-tkt-lb .modal-header").addClass("bg-theme");
		$(".modal-tkt-lb .modal-title").addClass("text-light");
	
	}else{

		$(".modal-content").removeClass("bg-light");
		$(".modal-content").addClass("bg-dark");
		$(".modal-content").removeClass("color-theme");
		$(".modal-content").addClass("text-light");

		$(".modal-tkt-lb .modal-header").addClass("bg-theme");
		$(".modal-tkt-lb .modal-title").addClass("text-light");
	
	}

</script>
