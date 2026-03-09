<?php 
include $_SERVER['DOCUMENT_ROOT']."/php/lt/pgs-functions.php";

//
include "../conn.php";

session_start();
$user = $_SESSION['email'];

$get_info = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$user'");
$get_user = mysqli_fetch_array($get_info);

$user_id = $get_user['id'];

$get_user_config = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$user_id'");
  
$array_user_config = mysqli_fetch_array($get_user_config);
$en_data_lwin = base64_encode($array_user_config['dt_w']);

$get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id > 0 AND data = '$en_data_lwin' ORDER BY id DESC LIMIT 1");

$get_last_session = mysqli_fetch_array($get_last_winners);
$last_session_lt = $get_last_session['session_id'];

$dt_de_ls = base64_decode($get_last_session['data']);

 $dt = $dt_de_ls[0]."".$dt_de_ls[1]."".$dt_de_ls[2]."".$dt_de_ls[3]."".$dt_de_ls[4]."".$dt_de_ls[5]."".$dt_de_ls[6]."".$dt_de_ls[7]."".$dt_de_ls[8]."".$dt_de_ls[9];

if($last_session_lt % 2 == 0){

  $dt_sec_current = $dt_de_ls." 12:00 pm";
  $ls_str = "pm";

}else{

  $dt_sec_current = $dt_de_ls." 0:00 am";
  $ls_str = "am";

}
//

$array_id_lt = array();
$array_value_lt = array();

$lot = 0;
$wcount = 0; 

$npv = $array_user_config['lt_wipg'];
$pg = $array_user_config['pgw'];

$max_ipg_x_pg = $npv * $pg;

if($pg == 1){
  $max_ipg = 0;
}else{
  $max_ipg = $npv * ($pg - 1);
}

$dt_en_ls = base64_encode($dt_de_ls);

$all_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1 AND data = '$dt_en_ls' ORDER BY id ASC LIMIT $max_ipg_x_pg");

$count_pg = 1;
$gd = 0;

while ($array_last_win = mysqli_fetch_array($all_last_winners)) { ?>

<?php   

  if($count_pg > $max_ipg && $array_last_win['session_id'] == $last_session_lt){ 
  
    //start add val ini lot end lot 
    $ar_lot = lot_ini_end($gd, $last_session_lt);
    $lot_ini = $ar_lot[0];
    $lot_end = $ar_lot[1];
    //end

?>                     
<div class="col-xl-3 col-md-6" id="<?php echo $count."-".$ls_str.""."-dt-".$dt; ?>">
  <div class="card bg-theme text-white mb-1">
      <div class="card-body" id="dt-<?php echo $count; ?>">
        <div>
          <p style="float: left;padding: 0px;margin: 0px;"><?php echo $array_last_win['nick']; ?></p>
          <p class="text-light" style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a href="#" class="text-light"><a href="#" class="text-muted"><?php echo $lot_ini." - ".$lot_end; ?></a> <i aria-hidden="true" class="fa fa-cubes fa-1x text-light"></i></p>
        </div>
      </div>

      <div class="card-footer d-flex align-items-center justify-content-between" style="padding: 0px 0px;">
        <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Tickets: <a href="#" class="text-muted" style="margin: 0px 4px;position: absolute;display: inline;"><?php echo $array_last_win['total_ticket']; ?></a></p>
        <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Earns: <a href="#" class="text-muted">$<?php echo $array_last_win['total_earn']; ?></a></p>
        <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Rate: <a href="#" class="text-muted"><?php echo $array_last_win['parcial']; ?>%</a></p>
        <div class="small text-white">
          <svg class="svg-inline--fa fa-angle-right" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg="">
            <path fill="currentColor" d="M246.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L178.7 256 41.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path>
          </svg>
        </div>
      </div>
  </div> 
</div>
<?php $wcount++; $gd++; } $count_pg++; } 

$all_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1 AND session_id = '$last_session_lt'");
$wa = mysqli_num_rows($all_last_winners);

?>