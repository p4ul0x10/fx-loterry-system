<?php //include $_SERVER['DOCUMENT_ROOT']."/php/functions.php"; ?>
<?php
	if($_GET['ref_name']){ echo "<script>$(document).ready(function() { $('.modal-profile-ref').toggle(); });</script>"; }
?>
<div class="modal modal-profile-ref text-primary" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-tables" role="document">
    <div class="modal-content">
      <div class="modal-header bg-theme">
        <h5 class="modal-title text-light" align="center">Profile</h5>
        <i class="fa-with-exclamation fa fa-info" aria-hidden="true"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
      <div class="card <?php bg_theme(); ?>" style="width: 100%;">
		<?php

	  	$user = $_GET['ref_name'];
	  	$email = $_SESSION['email'];
	  	$get_nome_leader = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
 			$array_leader = mysqli_fetch_array($get_nome_leader);
			
			$user_leader = $array_leader['f_nome'];
			$user_id = $array_leader['id'];
		
			$get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$user_leader'");
			if($row=mysqli_affected_rows($con) >= 1){

				if($row_ref = mysqli_affected_rows($con) >= 1){

					$count_ref_pro = 0;
					$get_ref_pro = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$user'");
		 			$array_net = mysqli_fetch_array($get_ref_pro);
		 			$user_pro_ref = $array_net['f_nome'];
		 			$count_ref_pro = $count_ref_pro + mysqli_num_rows($get_ref_pro);	
		 			$array_ref = mysqli_fetch_array($get_ref_on);

		 			$id = $array_ref['id'];
		 			$get_ip_ref = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id' AND ipgeo != ''");

					$get_perfil = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$user' and photo > '1'");
					$member_sets = mysqli_fetch_array($get_perfil);				

		 			$get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' AND status = '1'");
		 			$count_dep_pro = mysqli_num_rows($get_deps_pro);
		 			
		 			$get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$user_pro_ref'");
			 		$get_ref_pro = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$user_pro_ref'");
			 		if($row_ref == mysqli_affected_rows($con) >= 1){

			 			$array_net = mysqli_fetch_array($get_ref_pro);
			 			$user_pro_ref = $array_net['f_nome'];
			 			$count_ref_pro = $count_ref_pro + mysqli_num_rows($get_ref_pro);
			 			
			 			$array_ref = mysqli_fetch_array($get_ref_on);
			 			$id = $array_ref['id'];
			 			$get_ip_ref = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id' AND ipgeo != ''");

						$get_perfil = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$user' and photo > '1'");
						
			 			$get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' AND status = '1'");
			 			$count_dep_pro = mysqli_num_rows($get_deps_pro);
		 				
		 				$get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$user_pro_ref'");
			 			$get_ref_pro = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$user_pro_ref'");
				 		if($row_ref == mysqli_affected_rows($con) >= 1){

				 			$nome_leader = mysqli_fetch_array($get_ref_pro);
				 			$count_ref_pro = $count_ref_pro + mysqli_num_rows($get_ref_pro);
				 			$array_ref = mysqli_fetch_array($get_ref_on);
				 			$id = $array_ref['id'];
				 			$get_ip_ref = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id' AND ipgeo != ''");

							$get_perfil = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$user' and photo > '1'");
							
				 			$get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' AND status = '1'");
				 			$count_dep_pro = mysqli_num_rows($get_deps_pro);
				 		}
			 		}
		 		}

				if(isset($user)){

					  $get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$user_leader'");
            $array_ref = mysqli_fetch_array($get_ref_on);

            $idr = $array_ref['id'];
            $img_idr = $array_ref['photo'];
            $get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$idr' AND status = '1'");
            $count_dep_pro = mysqli_num_rows($get_deps_pro);
            
            if($count_dep_pro >= 1){
              $active_pro = "<p class='text-success'>Active plans</p>";
               $status_ref_pro = '<a class="bg-success" style="width:5px; height: 5px; border-radius: 50% 50% 50% 50%; position: relative; position: absolute; margin: 10px 5px;"></a>';
            }else{
              $active_pro = "<p class='text-danger'>No active plans</p>";
              $status_ref_pro = '<a class="bg-danger" style="width:5px; height: 5px; border-radius: 50% 50% 50% 50%; position: relative; position: absolute; margin: 10px 5px;"></a>';
            }
         
            $img_t = 'php/imagesperfil/'.$idr.'.jpg';
           
            if($idr >= 0){
              echo '<img id="profileimg" src="'.$img_t.'" width="140px" height="140px" style="margin-left: 0px !important; border-radius: 50% 50% 50% 50%; margin: 0px auto !important;"/>';
            }else{
              echo '<i class="fa fa-user-circle fa-5x" aria-hidden="true" style="margin: 0px auto !important; border-radius: 50% 50% 50% 50%; margin: 0px auto !important;"/></i>';
            }
            echo '<span>'.$user.' '.$status_ref_pro.'<br>'.$active_pro.'</span>';

				}

			}else{

				$get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user'");
				if($row_ref = mysqli_affected_rows($con) >= 1){

					$count_ref_pro = 0;
					$get_ref_pro = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$user'");
		 			$array_net = mysqli_fetch_array($get_ref_pro);
		 			$user_pro_ref = $array_net['f_nome'];
		 			$count_ref_pro = $count_ref_pro + mysqli_num_rows($get_ref_pro);	
		 			$array_ref = mysqli_fetch_array($get_ref_on);

		 			$id = $array_ref['id'];
		 			$get_ip_ref = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id' AND ipgeo != ''");
					
		 			$get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' AND status = '1'");
				 	$count_dep_pro = mysqli_num_rows($get_deps_pro);
		 			
		 			$get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$user_pro_ref'");
			 		$get_ref_pro = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$user_pro_ref'");
			 		if($row_ref == mysqli_affected_rows($con) >= 1){

			 			$array_net = mysqli_fetch_array($get_ref_pro);
			 			$user_pro_ref = $array_net['f_nome'];
			 			$count_ref_pro = $count_ref_pro + mysqli_num_rows($get_ref_pro);
			 			
			 			$array_ref = mysqli_fetch_array($get_ref_on);
			 			$id = $array_ref['id'];
			 			$get_ip_ref = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id' AND ipgeo != ''");

						$get_perfil = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$user' and photo > '1'");
				
		 				$get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' AND status = '1'");
				 		$count_dep_pro = mysqli_num_rows($get_deps_pro);
		 				
		 				$get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$user_pro_ref'");
			 			$get_ref_pro = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$user_pro_ref'");
				 		if($row_ref == mysqli_affected_rows($con) >= 1){

				 			$nome_leader = mysqli_fetch_array($get_ref_pro);
				 			$count_ref_pro = $count_ref_pro + mysqli_num_rows($get_ref_pro);
				 			$array_ref = mysqli_fetch_array($get_ref_on);
				 			$id = $array_ref['id'];
				 			$get_ip_ref = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id' AND ipgeo != ''");

							$get_perfil = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome='$user' and photo > '1'");
						
				 			$get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id' AND status = '1'");
				 			$count_dep_pro = mysqli_num_rows($get_deps_pro);
				 		}
			 		}

		 			if(isset($user)){

					  $get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$user_leader'");
            $array_ref = mysqli_fetch_array($get_ref_on);

            $idr = $array_ref['id'];
            $img_idr = $array_ref['photo'];
           
            $get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$idr' AND status = '1'");
            $count_dep_pro = mysqli_num_rows($get_deps_pro);
            
            if($count_dep_pro >= 1){
              $active_pro = "<p class='text-success'>Active plans</p>";
               $status_ref_pro = '<a class="bg-success" style="width:5px; height: 5px; border-radius: 50% 50% 50% 50%; position: relative; position: absolute; margin: 10px 5px;"></a>';
            }else{
              $active_pro = "<p class='text-danger'>No active plans</p>";
              $status_ref_pro = '<a class="bg-danger" style="width:5px; height: 5px; border-radius: 50% 50% 50% 50%; position: relative; position: absolute; margin: 10px 5px;"></a>';
            }
            
            $img_t = 'php/imagesperfil/'.$idr.'.jpg';

            if($idr >= 0){
            	echo '<img id="profileimg" src="'.$img_t.'" width="140px" height="140px" style="margin-left: 0px !important; border-radius: 50% 50% 50% 50%; margin: 0px auto !important;"/>';
            }else{
            	echo '<i class="fa fa-user-circle fa-5x" aria-hidden="true" style="margin: 0px auto !important; border-radius: 50% 50% 50% 50%; margin: 0px auto !important;"/></i>';
            }
            echo '<span>'.$user.' '.$status_ref_pro.'<br>'.$active_pro.'</span>';

					}

		 		}
		 		
			}
			
		 ?>
		 <?php

		 $nome_leader = $array_leader['f_nome'];

		 $check_ref_true = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user'");

		 if($check_c = mysqli_affected_rows($con) >= 1){
		 	
		 	$user_array_pro = mysqli_fetch_array($check_ref_true);
		 	$id_ref_pro = $user_array_pro['id'];
		 	$user_pro_ref = $user_array_pro['f_nome'];
			$get_deps_pro = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id_ref_pro' AND status = '1'");
			$get_with_pro = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id_ref_pro' AND status = '1'");
			$get_user_pro = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_ref_pro' AND f_nome = '$user'");

			$count_dep_pro = mysqli_num_rows($get_deps_pro);
			$count_with_pro = mysqli_num_rows($get_with_pro);
		
			$member_since_pro = $user_array_pro['data'];
			$count_earns_pro = $user_array_pro['total_bonus'];
		 
		 	$get_lts = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$idr'");

		 	$session_count = 0;
		 	$last_session = 0;

		 	while($array_lt_tkt_session = mysqli_fetch_array($get_lts)){
		 	
		 		if($last_session != $array_lt_tkt_session['current_session']){
		 			$last_session = $array_lt_tkt_session['current_session'];
		 			$session_count++;
		 		}
		 		
		 	}

		 }
		 ?>
	  <div class="card-body">
	    <h5 class="card-title">Activities</h5>
	    <div class="container col-md-10"><p class="card-text">Deposits: <a href='#' class="text-muted"><?php echo $count_dep_pro; ?></a></p>
	    <p class="card-text">Withdraws: <a href='#' class="text-muted"><?php echo $count_with_pro; ?></a></p>
	   	<p class="card-text">Loterrys: <a href="#" class="text-muted"><?php echo $session_count; ?></a></p>
	    <p class="card-text">Referrals: <a href='#' class="text-muted"><?php echo $count_ref_pro; ?></a></p>
	    <p class="card-text">Referral earns: <a href='#' class="cv text-muted"> <?php echo number_format($count_earns_pro, 2, '.', ''); ?></a></p>
	    <p class="card-text">Member since: <a href="#" class="text-muted"><?php echo $member_since_pro; ?></a></p></div>
	  </div>
		  <?php 
		  /*
	<div class="activits_profile '.$text_color.'">Deposits: <a href="#" class="text-muted">'.$rows_dep.'</a></div>
	  <div class="activits_profile '.$text_color.'">Withdraws: <a href="#" class="text-muted">'.$rows_with.'</a></div>
	  <div class="activits_profile '.$text_color.'">Loterrys: <a href="#" class="text-muted">12</a></div>
	  <div class="activits_profile '.$text_color.'">Referrals: <a href="#" class="text-muted">'.$rows_referral.'</a></div>
	  <div class="activits_profile '.$text_color.'">IP: <a href="#" id="ip" class="text-muted">'.base64_decode($ipgeo).'</a></div>
	  <div class="activits_profile '.$text_color.'">> Total deposits <a href="#" class="text-muted">100</a></div>
	  <div class="activits_profile '.$text_color.'">< Total withdraw <a href="#" class="text-muted">170</a></div>
	</div>';
		  */
		  ?>
		  <!--<a class="container col-md-10 card-text btn bg-theme text-light" href="#" class="btn btn-primary">Send messenger</a>-->
		</div>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>