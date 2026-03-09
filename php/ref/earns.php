<?php include $_SERVER['REQUEST_URI']."/php/functions.php"; ?>
<?php
	if($_GET['earns_ref']){ echo "<script>$(document).ready(function() { $('.modal-earns-ref').toggle(); });</script>"; }
?>
<div class="modal modal-earns-ref text-primary" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-tables" role="document">
    <div class="modal-content">
      <div class="modal-header bg-theme">
        <h5 class="modal-title text-light" align="center">Referral earns</h5>
        <i class="fa-with-exclamation fa fa-info" aria-hidden="true"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
      	<div class="card <?php bg_theme(); ?>" style="width: 100%;">
          <?php 
          $user = $_GET['earns_ref'];
          if(isset($user)){
                       
            $get_ref_on = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$user' AND sponsor = '$leader_nome'");
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
           
            $img_t = 'php/imagesperfil'.$idr.'jpg';
            if($idr >= 0 && isset($img_idr) > 0){
              echo '<img id="profileimg" src="php/imagesperfil/'.$idr.'.jpg" width="140px" height="140px" style="margin-left: 0px !important; border-radius: 50% 50% 50% 50%; margin: 0px auto !important;"/>';
            }else{
              echo '<i class="fa fa-user-circle fa-5x" aria-hidden="true" style="margin: 0px auto !important; border-radius: 50% 50% 50% 50%; margin: 0px auto !important;"/></i>';
            }
            echo '<span>'.$user.' '.$status_ref_pro.'<br>'.$active_pro.'</span>';
          
          }
          ?>
		  		<div class="card-body" style="padding-top: 0px !important;">
	         <h4 style="margin-bottom: 25px;">Deposits added</h4>
          <?php

          $get_info_percent = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
          $array_info = mysqli_fetch_array($get_info_percent);

          $get_deposits=mysqli_query($con, "SELECT * FROM deposits WHERE id_user ='$idr' ");

          $num_deps = mysqli_affected_rows($con);
          if($num_deps >= 1){

            $count_active_dep = 0;
            //$count_active = 0;
            while ($rows_dep_att = mysqli_fetch_array($get_deposits)) {
              
              $dep_plan = $rows_dep_att['type_dep'];
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

              $id_dep = $rows_dep_att['id'];
              $get_rel_dep = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep ='$id_dep'");
              $array_rel = mysqli_fetch_array($get_rel_dep);
              $count_active_dep++;

              $coin = $array_rel['coin'];
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
              }

              echo "<div class='container col-md-10 card bg-theme mb-1 col-tkt".$count_active_dep."'>";
              echo "<div class='col-md-12'><p class='text-card-earn float-left text-light'>Id: <a href='#' class='text-muted'>".$array_rel['id_charnum']."</a>&nbsp;&nbsp;&nbsp; Plan: <a href='#' class='text-muted'>".$array_rel['plan']."</a>&nbsp;&nbsp;&nbsp; Paid: <a href='#' class='text-muted'>".$array_rel['data']."</a>&nbsp;&nbsp;&nbsp; Value: <a href='#' class='text-muted'>$".$array_rel['value']."</a> in ".$coin_img."&nbsp;&nbsp;&nbsp; Type: <a href='#' class='text-muted'>Package</a></p>";
              $get_id_rel = $array_rel['id_charnum'];
              $select_tkt_by_dep = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_dep ='$get_id_rel'");
              $init_count = 0;
              
              if($r_tkt = mysqli_affected_rows($con) >= 1){

                $dep_id_user = $rows_dep_att['id_user'];
                $get_val = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$dep_id_user'");
                $dep_found = 0;

                if($r_val = mysqli_affected_rows($con) >= 1){
                  
                  while($array_tkt_buyed = mysqli_fetch_array($get_val)){

                    $ar_str = str_split($array_tkt_buyed['rel_package']);
                    $str_p = strpos($array_tkt_buyed['rel_package'],"-");
                          
                    $c = 0;
                    $id = array();

                    while($c < $str_p){

                      $id[$c] = $ar_str[$c];
                  
                        $c++;
                    }

                    $id_im = implode("",$id);

                    if($get_id_rel == $id_im && $dep_found == 0){
                      echo "<a href='#'><i id='ext_rel".$count_active_dep."' class='fa fa-dep-tkt fa-sort-desc text-light' aria-hidden='true' onclick='show_tkt_buyed(".$count_active_dep.")'></i></a>";
                      $dep_found = 1;
                    }

                  }
                  
                }

                $count_active = 1;
              }else{
                $count_active = 0;
              }
              echo "</div>";
              echo "<div class='col-md-12 row-tkt".$count_active_dep."' style='display:none;'>";

              if($count_active != $init_count){
                
                while ($array_tkt_bydep = mysqli_fetch_array($select_tkt_by_dep)) {

                  $id_rel_user = $array_tkt_bydep['id_user'];

                  $get_val = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user ='$id_rel_user'");
                  while($array_tkt_buyed = mysqli_fetch_array($get_val)){
                    
                    $id_im = $array_tkt_bydep['id_dep']."-".$count_active;
              
                    if($id_im == $array_tkt_buyed['rel_package']){

                    echo "<div class='tkt".$count_active." tkt-earns ".$id_im."'><small class=' float-left text-light'>Tickets buyed => &nbsp;&nbsp;&nbsp; Paid: <a href='#'>".$array_tkt_buyed['data']."</a>&nbsp;&nbsp;&nbsp; Value: <a href='#'>$".$array_tkt_buyed['value']."</a>&nbsp;&nbsp;&nbsp; Type: <a href='#'>Loterry</a></small>&nbsp;";
                    echo "</div>";
                      $count_active++;

                    }

                  }
            
                }
                 
              }
              echo "</div>";
              echo "</div>";
            }

          }
          ?>
		  		</div>

				</div>
    	</div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function show_tkt_buyed(id) {

    $(".row-tkt"+id).each(function(){

      if($(this).attr("style") == "display:none;" || $(this).attr("style") == "display: none;"){
       
        $(this).show();
        $("#ext_rel"+id).removeClass("fa-sort-desc");
        $("#ext_rel"+id).addClass("fa-sort-asc");
     
     }else{

        $(this).hide();
        $("#ext_rel"+id).removeClass("fa-sort-asc");
        $("#ext_rel"+id).addClass("fa-sort-desc");

      }

    });

    /*if($("#ext_rel"+id).attr("class") == "fa fa-dep-tkt fa-sort-desc text-light" || $("#ext_rel"+id).attr("class")  == "fa fa-dep-tkt text-light fa-sort-desc"){
      $("#ext_rel"+id).removeClass("fa-sort-desc");
      $("#ext_rel"+id).addClass("fa-sort-asc");
      $("#tkt"+id).show();
    }else{
      $("#ext_rel"+id).removeClass("fa-sort-asc");
      $("#ext_rel"+id).addClass("fa-sort-desc");
      $("#tkt"+id).hide();
    }*/


  }
</script>