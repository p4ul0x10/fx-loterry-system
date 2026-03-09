<?php session_start();
ini_set( 'display_errors', 0);

include "php/conn.php";
include "php/functions.php";
include "php/theme-mod/mode_class.php";
//include "php/loterry/loterry-gen.php";

if (!isset($_SESSION['email'])) {
  echo "<script>setTimeout(function(){
  location.href='index.php';
 }, 1);</script>";
 session_destroy();
 exit();
}else{
  
}

//sponsor_bonus();
reset_searchs();
numdays();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/ico" href="images/coins/fxicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="google-translate-customization" content="e6d65bc1aa004329-813ae7b5623659e0-g8b1cf8bac64e7822-16"></meta>
    <title>Investe FX Robot - BACKOFFICE</title>
    <!-- Bootstrap & custom core CSS -->
    <link link href="css/bootstrap.min.css?v=<?php echo filemtime('css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="css/style-all.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- end -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
      $(window).on("load", function(){
        
        $.getJSON("https://ipinfo.io/<?php echo $_SERVER['REMOTE_ADDR']; ?>", function(data){
          country = data['country'];
          $("body").attr("id", country);
        });

        $(".fix").css("all", "unset");
        $("#loading").remove();
        //document.getElementsByTagName("header")[0].style.zIndex='10000';
        $("#box-menu").load("php/ref/return_net_table.php");
      });

      $(".mf").attr("id", "mf0");
    </script>
    <style> 
      .skiptranslate { display: none !important; }
      body { top: 0px !important; }
      .close-vals { padding-top:1rem !important; padding-right:1rem !important;  padding-bottom:1rem !important;}
      .close-vals span{ float:right; }
      #box-menu { overflow-x: auto !important; }
      .mgl-center { margin: 0px auto !important; }
      .btn-c-pending { right: 0px; position: absolute; top: 0px; }

      @media (max-device-width: 650){
        .row-d-bd { margin: 10px auto !important; }
      }
    </style>
  </head>
  <body class="text-center <?php bg_color(); ?>" onload="main_change();" onresize="main_change();">
    <?php include "php/ref/profile-modals.php"; ?>
    <div id="mf0" class="fluid-container w-100 mf" style="height: 800px;">
      <div class="fix" style="float: left; top:80px; padding:0px; width: 100%; height: 3000px; position: absolute; z-index: 10000;background: rgba(17,18,36, 1);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
      <?php include "theme-parts/header.php"; ?>
      <div role="main" class="col-md-12">
        <main role="main" class="resize-main fluid-container mt-d padding-0">
          <!--<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
              <h1 class="dashboard h2 color-theme">Dashboard</h1>
             <div class="row user-block">
                <?php //echo user(); ?>
             </div>
            </div>-->
            <script>
              function tdep(type){
            
                if(type == "dep" || type == "with"){

                  wd = $("body").width();

                  if(type == "dep"){

                    obj = $("#show-pending-deps").text();
                    cl = "onclick=tdep('dep-close')";
                    id_type = "show-pending-deps";
                    html_type = "show-pending-dep";
                    pg = "php/dep/show-pending-dep";
                    title_type = "Deposits";

                  }

                  if(type == "with"){
                  
                    obj = $("#show-pending-withs").text();
                    cl = "onclick=tdep('with-close')";
                    id_type = "show-pending-withs";
                    html_type = "show-pending-with";
                    pg = "php/with/show-pending-with";
                    title_type = "Withdraws";
   
                  }

                  lights = $(".lights").attr("id");

                  if(lights == "#light"){
                    bg_color = "bg-light";
                  }else{
                    bg_color = "bg-dark";
                  }

                  div_add0 = "<div class='columns columns-right btn-group float-left mb-3 mt-3 ml-3' style='height: 38px;'><h2 class='win-resources float-left h4 color-theme mt-1'>"+title_type+" pending</h2><button type='button' class='close close-vals btn-c-pending mt-2 mr-3' data-dismiss='modal' aria-label='Close' "+cl+"><span aria-hidden='true' class='color-theme btn-c-pending'>×</span></button></div>";

                  if(obj == "undefined" || obj == ""){

                    $(".resume-acc:eq(0)").after("<div id='"+id_type+"' class='col-md-12 float-left card "+bg_color+"' style='padding:0px;'>"+div_add0+"<div class='"+html_type+"' style='overflow-y: auto; max-height: 330px;'></div></div>");
                  
                  }else{

                    if(id_type == "show-pending-deps"){
                      $("#show-pending-deps").remove();
                    }else{
                      $("#show-pending-withs").remove();
                    }

                  }
                  
                  $.post(pg+'.php',{"wd":wd}, function(data){
                    $("."+html_type).html(data);
                  });

                }else if(type == "dep-close"){
                  $("#show-pending-deps").remove();
                }else if(type == "with-close"){
                  $("#show-pending-withs").remove();
                }
              
              }

            </script>
            <div class="main-container fluid-container" style="width: 98%;margin: 0px auto !important;">
              <h3 class="text-center card bg-theme text-bold <?php nav_link(); ?> resume-acc">Resume account</h3>
              <div class="col-info-sys col-md-6 float-left card <?php bg_theme(); ?> pdg-bo-info">
                <strong class="txt <?php text_color(); ?> ini-top">Total deposited: <a href="#"><?php total_depositado_user(); ?></a><a href="#tdep" class="mg-bo"> <p class="dc text-success float-right acc-amount-d" onclick="tdep('dep');"> <i class="fa fa-angle-up" aria-hidden="true"></i> <?php 
                $email = $_SESSION['email'];
                $get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
                $array_user = mysqli_fetch_array($get_user);
                $user_id = $array_user['id'];
                $get_dep_unconfirmed = mysqli_query($con, "SELECT sum(quantidade)qtd FROM deposits WHERE id_user = '$user_id' AND status != 1");
                $array_dep = mysqli_fetch_array($get_dep_unconfirmed);
                echo "$".number_format($array_dep['qtd'], 2, ".", "")." pending"; ?>
                </p></a></strong>
                <strong class="txt <?php text_color(); ?> ini-top">Total account: <a href="#"><?php total_acc_user(); ?></a><a href="#" class="mg-bo"> <p class="wc text-danger float-right acc-mount-t" onclick="tdep('with');"> <i class="fa fa-angle-down" aria-hidden="true"></i>
                <?php 
                $email = $_SESSION['email'];
                $get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
                $array_user = mysqli_fetch_array($get_user);
                $user_id = $array_user['id'];
                //
                $get_dep_unconfirmed = mysqli_query($con, "SELECT sum(quantidade)qtd FROM saque WHERE id_user = '$user_id' AND status != 1");
                $array_dep = mysqli_fetch_array($get_dep_unconfirmed);
                //
                $get_ltwin_unconfirmed = mysqli_query($con, "SELECT sum(total_earn)earn FROM loterry_winners WHERE id_user = '$user_id' AND status != '1'");
                $array_win_lt = mysqli_fetch_array($get_ltwin_unconfirmed);
                $total_acc_unconfirmed = number_format($array_dep['qtd'], 2, ".", "");
                echo "$".$total_acc_unconfirmed." pending"; ?><!--$20 pending--></p></a></strong>
                <div class="col-12">
                  <div class="pr-1">
                    <button type="button" class="col-6 btn float-left bg-theme text-light c-deposito-f btncc wd">Deposit founds</button>
                  </div>
                  <div class="pl-1">
                    <button type="button" class="col-6 btn float-right bg-theme text-light c-deposito btncc wd">Buy packages</button>
                  </div>
                </div>
              </div>
              <div class="col-info-sys col-md-6 col-md-6-m3 float-right card <?php bg_theme(); ?> pdg-bo-info">
                <strong class="txt <?php text_color(); ?> ini-top" style="height: 41.5px;"><!--Ganho diário:  <a href="#">--><?php //ganho_diario(); ?> <!--%</a><a href="#">--><?php user_coin(); ?><!--</a>--></strong>
                <strong class="txt <?php text_color(); ?>">Total return / earns: <a href="#"><?php total_retorno(); ?> </a></strong>
                <button type="button" class="btn bg-theme text-light btnc btnsaque wd float-center">Withdraw</button>
              </div>
              <div class="space-fix-c"></div>
              <h3 id="tkts-line" class="text-center card bg-theme text-bold <?php nav_link(); ?>">FX loterry<i class="fa-fx-question fa fa-question float-right ico-question" aria-hidden="true"></i></h3>
              <div class="col-info-sys col-md-12 float-left card <?php bg_theme(); ?>" style="overflow-y: auto !important; overflow-x: hidden !important;">
                <h4 class="color-theme mt-3">Current</h4>
                <?php $get_seconds = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
                $arfx = mysqli_fetch_array($get_seconds);
                $seconds_rest = $arfx['fx_loterry_time']; ?>
                <?php 
                if($seconds_rest >= 1){
                
                  $convert_time = $seconds_rest / 3600;
                  $convert_time_h = substr($convert_time, 0, 2);
                  
                  if($seconds_rest > 3600){

                    $hms_in_minsec = $seconds_rest % 3600;
                    $min = number_format($hms_in_minsec / 60, 0, ',', '');
                    
                    if($hms_in_minsec == 0){
                      $min = 59;
                    }

                  }else{

                    $min = number_format($seconds_rest / 60, 0, ',', '');

                    if($min < 1){
                      $min = 0;
                    }

                    $h = 0;

                  }

                  $seg = floor($seconds_rest % 60);
                
                }
                ?>
                <div style="float: left; width: 100%; height: 10px;"></div>
                <div class="fluid-container">
                  <div class="col-10 align-mg-lt">
                    <div class="pr-1">
                      <div type="button" class="col-6 btn float-left bg-theme text-light tkt-buy btncc wd">Buy tickets</div>
                    </div>
                    <div class="pl-1">
                      <div type="button" id="lt-d-1" class="col-6 btn float-right bg-theme text-light lt-details">Details</div>
                    </div>
                  </div>
                </div>
                <!--<button type="button" class="btn bg-theme text-light tkt-buy btncc wd">Buy tickets</button>-->
                <?php 
                  //start find info's current lt
                  $t_entrys = 0;
                  $t_tickets = 0; 
                  
                  $ar_users_lt = array();
                  $ci = 0;

                  $get_info_lt = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id > 0");
                
                  while($info_lt = mysqli_fetch_array($get_info_lt)){
                
                    $t_entrys++;
                    $t_tickets = $t_tickets + $info_lt['value'];
                    $ar_users_lt[$ci] = $info_lt['id_user'];
                    $ci++;

                  }
                  //end

                  //start check valid num of the participants
                  $t_users_lt = 0;

                  for ($i = 0; $i < $ci; $i++) { 
                    
                    for ($ii = $ci; $ii >= 0; $ii--) { 
                        
                      if($i != $ii && $ar_users_lt[$i] == $ar_users_lt[$ii]){
                        
                        $ar_users_lt[$ii] = 0;
                        $t_users_lt++;
                      
                      } 

                    }
                  
                  }
                  
                  $t_participants = 0;

                  for ($i = 0; $i < $ci; $i++) { 
                    
                    if($ar_users_lt[$i] != 0){
                      $t_participants++;
                    }
                  
                  }
                  //end

                  //start max winners
                  $tt_participants = $t_participants % 2;
                  
                  if($tt_participants == 0){
                    $max_winners = $t_participants / 2;
                  }else{
                    $max_winners = ($t_participants - 1) / 2;
                  }
                  //end

                  //start max rewards 
                  $t_amount_lt = $t_tickets * 0.20;
                  $p_amount_lt = (80 * $t_amount_lt) / 100;
                  $max_rewards = $p_amount_lt;
                  //end
                ?>
                <h5 class="color-theme mt-3 mb-3">Current loterry resume</h5>
                <div class="lt-ys row fluid-container">
                  <span class="text-lt <?php text_color(); ?>">Total participants: 
                    <a href="#" class="text-muted t-participants"><?php echo $t_participants; ?></a> 
                    <img src="open-iconic-master/png/people-3x.png" width="20" height="20">
                  </span>
                  <span class="text-lt <?php text_color(); ?> ">Total entrys: 
                    <a href="#" class="text-muted t-entrys"><?php echo $t_entrys; ?></a> 
                    <img src="open-iconic-master/png/pie-chart-3x.png" width="20" height="20">
                  </span>
                  <span class="text-lt <?php text_color(); ?>">Total tickets: 
                    <a href="#" class="text-muted t-tickets"><?php echo $t_tickets; ?></a> 
                    <img src="open-iconic-master/png/tag-3x.png" width="20" height="20">
                  </span>
                  <span class="text-lt <?php text_color(); ?>">Max winners: 
                    <a href="#" class="text-muted t-max-winners"><?php echo $max_winners; ?></a> 
                    <img src="open-iconic-master/png/people-3x.png" width="20" height="20">
                  </span>
                  <span class="text-lt <?php text_color(); ?>">Total rewards: 
                    <a href="#" class="text-muted t-rewards"><?php echo $max_rewards; ?></a> 
                    <img src="open-iconic-master/png/dollar-3x.png" width="20" height="20">
                  </span>
                </div>
                <style type="text/css">
                  div.lt-ys span{ margin: 0px auto !important; }
                </style>
                <h5 class="lt-timeb color-theme mt-3">Raffle in:<br><img src="open-iconic-master/png/timer-3x.png" width="20" height="20"></span><a class="span-h color-theme">&nbsp<?php echo $convert_time_h; ?></a> hs: <a class="span-m color-theme"><?php echo $min; ?></a> min: <a class="span-s color-theme"><?php echo $seg; ?></a> seg <i aria-hidden="true" class="fa-lt-exclamation fa fa-info color-theme ml-2"></i></h5>
                <div id="lt-tkt-box" class="fluid-container mt-3 mb-3">
                  <div class="col-11 mt-4 lt-tkt-box align-mg-lt" style="height:55px; overflow: hidden;">
                    <div class="box-overflow-xltb" style="position: absolute; float: left; overflow-x: auto;">
                      <div style="width: 1109px; height: 37px;">
                        <ul style="position: absolute;width: 1409px;">
                          <?php 
                          $lt = 1;
                          $query_tkt_b = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE current_session = '1' ORDER BY id DESC");
                          while ($last_buyed = mysqli_fetch_array($query_tkt_b)){
                          
                          ?>
                         <li class="box-l btn float-left bg-success text-light ml-1 mr-1 mb-1">
                            <a href="#tkts-line" id="<?php echo $last_buyed['rel_package']; ?>" class="lt-tkt-box-b" onclick="modal_lt_d(id);">+ <?php echo $last_buyed['value']; ?> <img src="open-iconic-master/png/tag-3x.png" width="10px" height="10px">
                            </a> 
                          </li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="space-fix-cc"></div>
              <?php 
                $last_lt_winners = mysqli_query($con, "SELECT * FROM loterry_session WHERE loterry_session > 0 ORDER BY id DESC LIMIT 1");

                $array_last_session_lt = mysqli_fetch_array($last_lt_winners);

                $get_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id > 1 ORDER BY id DESC LIMIT 1");

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

              ?> 
              <h3 class="text-center card bg-theme text-bold text-light">Last lotteries<i class="fa-lastw-question fa fa-question float-right ico-question" aria-hidden="true"></i></h3>
              <div class="col-info-sys col-md-12 float-right card <?php bg_theme(); ?>" style="overflow-x: auto !important;">
              <div class="fixed-table-toolbar mt-3">
                <div class="columns columns-right btn-group float-left mb-3" style="height: 38px;">                  
                  <h2 class="win-resources float-left h2 color-theme">Winners</h2>
                  <small class="lt_date ml-1 color-theme float-left mt-3" id="<?php echo $dt_sec_current; ?>" style="display:flex; position: relative;">
                  - <?php echo $dt_sec_current; ?>
                  </small>
                  <ul class="pagination ml-3">
                    <li class="page-item page-pre">
                      <a class="ppage-nnw-d page-link bg-theme bc-theme text-light" aria-label="previous page" href="javascript:void(0)" id="w-prev-w-d" onclick="inif(id)">‹
                      </a>
                    </li>   
                    <li class="page-item page-next">
                      <a class="npage-nnw-d page-link bg-theme bc-theme text-light" aria-label="next page" href="javascript:void(0)" id="w-next-w-d" onclick="inif(id)">›</a>
                    </li>
                  </ul>
                </div>
                  <div style="" class="columns columns-right btn-group float-right mb-3">
                    <div class="bs-bars float-right">
                      <div id="toolbar-n">
                        <select class="form-control select-w">
                          <option value="fw-name">Name</option>
                          <option value="fw-lot">Lot</option>
                          <option value="fw-tickets">Tickets</option>
                      </select>
                    </div>
                  </div>
                  <div class="float-right search btn-group ml-1">
                    <input class="form-control search-input-w sw" id="search-w" type="search" aria-label="Search" placeholder="Choose a Name" autocomplete="off" disabled>
                  </div>
                </div>
              </div>
              <div class="row show-last-lt" style="clear: both; overflow-y: auto; height: 361px;">
              <?php 
                
                $get_tkt_buy_list = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE current_session = '$last_session_lt'");

                $rc = 0;
                $num_rows = mysqli_num_rows($get_tkt_buy_list);
                
                $array_id_lt = array();
                $array_value_lt = array();

                $lot = 0;
                $wcount = 0; 

                while ($r = mysqli_fetch_array($get_tkt_buy_list)) {
                
                  $old_lot = $lot;
                  $lot = $old_lot + $r['value'];
                  
                  $array_id_lt[$rc] = $r['rel_package'];
                  $array_value_lt[$rc] = $lot;  
                  $rc++;

                }

                if($row_lw = mysqli_affected_rows($con) >= 1){
                  
                  mysqli_query($con, "UPDATE user_config SET dt_w = '' WHERE id_user = '$user_id'");

                  $get_user_config = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$user_id'");
                  
                  $array_user_config = mysqli_fetch_array($get_user_config);
                  $npv = $array_user_config['lt_wipg'];
                  
                  $dt_en_ls = base64_encode($dt_de_ls);
                  
                  $all_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1 AND data = '$dt_en_ls'");
                  $count_wld = mysqli_num_rows($all_last_winners);

                  $all_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1 AND data = '$dt_en_ls' ORDER BY id ASC LIMIT $npv");
                  
                  while ($array_last_win = mysqli_fetch_array($all_last_winners)) { 

                    if($array_last_win['session_id'] == $last_session_lt){ 
                    
                    $gd = 0;

                    while($gd < $rc){

                      if($array_last_win['rel_tickets'] == $array_id_lt[$gd]){

                        if($gd == 0){
                          $lot = $array_value_lt[$gd];
                        }else{
                          $lot = $array_value_lt[$gd] + 1;
                        }
                        
                        if($gd > 0){
                          $ini_lot = $array_value_lt[$gd-1] + 1;
                        }else{
                          $ini_lot = 1;
                        }
                      
                      }

                      $gd++;

                    } 

                  ?>                     
                  <div class="col-xl-3 col-md-6" id="<?php echo $wcount."-".$ls_str.""."-dt-".$dt; ?>">
                    <div class="card bg-theme text-white mb-1">
                      <div class="card-body" style="">
                        <div>
                            <p style="float: left;padding: 0px;margin: 0px;"><?php echo $array_last_win['nick'];  ?></p>
                            <p class="text-light" style="float: right;padding: 0px;margin: 0px; font-size: 12px;">Prize lot: <a href="#" class="text-muted"><?php echo $ini_lot." - ".$lot; ?></a> <i aria-hidden="true" class="fa fa-cubes fa-1x text-light"></i></p>
                          </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between" style="padding: 0px 0px;">
                          <p class="text-light col-md-4 mt-2 mb-2 small text-white stretched-link" style="margin: 0px;padding: 0px;">Tickets: <a href="#" class="text-muted"><?php echo $array_last_win['total_ticket']; ?></a></p>
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
                  <?php $wcount++; } } } 

                  $all_last_winners = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1 AND session_id = '$last_session_lt'");
                  $wa = mysqli_num_rows($all_last_winners);

                  ?>   
                </div>
                <div class="col-md-12 card card-lt-wf <?php bg_theme(); ?>" style="border: none;">
                  <div class="fixed-table-pagination" style="">
                    <div class="float-left pagination-detail">
                      <div class="page-list color-theme">Showing in 
                        <div class="btn-group dropdown dropup">
                          <button class="btn btn-secondary dropdown-toggle bg-theme" type="button" data-bs-toggle="dropdown" id="wdd" onclick="inif(id);">
                            <span class="page-size page-size-w"><?php echo $array_user_config['lt_wipg']; ?></span>
                          <span class="caret"></span>
                          </button>
                          <div class="dropdown-menu dropdown-menu-pg-w">
                            <div class="dropdown-item page-nw" id="w12" onclick="inif(id)">12</div>
                            <div class="dropdown-item page-nw" id="w24" onclick="inif(id)">24</div>
                            <div class="dropdown-item page-nw" id="w48" onclick="inif(id)">48</div>
                            <div class="dropdown-item page-nw" id="wa<?php echo $wa; ?>" onclick="inif(id)">All</div>
                          </div>
                        </div> rows per page</div>
                      </div>
                      <div class="pg-w float-right pagination">
                        <ul class="pagination">
                          <?php 
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

                          mysqli_query($con, "UPDATE user_config SET dt_w = '$dt_de_ls' WHERE id_user = '$user_id'");

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
                            <a id ="w<?php echo $ii; ?>" class="page-nnw page-link bc-theme color-theme <?php bg_theme(); ?>" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "w".$ii; ?>')"><?php echo $ii; ?></a>
                            <?php }else{ ?>
                            <a id ="w<?php echo $ii; ?>" class="page-nnw page-link bg-theme bc-theme text-light" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "w".$ii; ?>')"><?php echo $ii; ?></a>
                            <?php } ?>
                          </li>  
                          <?php } 
                          if($div_nv_tw_no_exactly){ $ii += 1; //rest div / page limit ?>
                          <li class="page-item">
                            <a id ="w<?php echo $ii; ?>" class="page-nnw page-link bg-theme bc-theme text-light" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "w".$ii; ?>')"><?php echo $ii; ?></a>
                          </li>
                          <?php } if($div_nv_tw_no_exactly){ $end_pg = $div_nv_tw + 1; }else{ $end_pg = $div_nv_tw; } ?>
                          <?php mysqli_query($con, "UPDATE user_config SET i_pg_w = '1', e_pg_w = '$end_pg' WHERE id_user='$user_id'"); ?>
                          <li class="page-item page-next">
                           <a class="npage-nnw page-link bg-theme bc-theme text-light" aria-label="next page" href="javascript:void(0)" id="w-next-w" onclick="pgs(id)">›</a>
                          </li> 
                        </ul>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <script type="text/javascript">

              $(document).ready(function(){

                setInterval(function(){
                  
                    seconds = $(".span-s").text();
                    minuts = $(".span-m").text();
                    hours = $(".span-h").text();

                    if(seconds >= 0){

                      dec_seg = seconds - 1;
                      if(dec_seg == -1){
                        dec_seg = 59;
                      }

                      $(".span-s").text(dec_seg);
                      if(dec_seg == 0){
                      
                        dec_min = minuts - 1;
                        if(dec_min == -1){
                      
                          dec_min = 59;
                          $(".span-s").text("59");
                          dec_hours = hours - 1;
                          $(".span-h").text(" "+dec_hours);
                      
                        }
                      
                        $(".span-m").text(dec_min);
                      
                      }
                  }

                  if($(".span-h").text() < 1 && $(".span-m").text() < 1 && $(".span-s").text() < 2){
                    location.reload();
                  }

                }, 1000);
              
              });

              function show_lt_session(mode) {
                
                if(mode == 1){
                  mode_selected = "prev";
                }else{
                  mode_selected = "next";
                }
                
                lt_date = $(".lt_date").text();
                
                if(lt_date.charAt(4) == "/"){
                  lt_date = lt_date.charAt(3);
                }else{
                  lt_date1 = lt_date.charAt(3);
                  lt_date2 = lt_date.charAt(4);
                  lt_date = lt_date1+lt_date2;
                }
                alert(lt_date);
               /* $.post("php/att_sesssion_lt.php",{"mode":mode_selected, "last_showed": lt_date}, function(data){

                });*/
              }

              $(".select-w").click(function() {

                $(".search-input-w").prop("disabled", false); 
  
                if($(this).val() == "fw-name"){
                  $("#search-w").attr("placeholder", "Choose a Name");
                }else if($(this).val() == "fw-lot"){
                  $("#search-w").attr("placeholder", "Lot eg: 2 - 10");
                }else if($(this).val() == "fw-tickets"){
                  $("#search-w").attr("placeholder", "Amount of the tickets");
                }

              });
            
              $("#search-w").keyup(function(){
  
                search = $(this).val(); 
                search_type = $(this).attr("class");
                mode_search = $(".select-w").val();
                status = 0;

                if(search != ""){ //return winners by filter

                  $.post("php/search/search.php", {"search":search, "search_type":search_type, "mode_search":mode_search}, function(data){

                    $(".show-last-lt").children().remove();
                    $(".show-last-lt").html(data);

                  });

                  status = 1;
                
                }else{ //return last winners
                  
                  $.post("php/search/return_last_winners.php", {}, function(data){

                    $(".show-last-lt").html(data);

                  });

                  status = 2;
                
                }

                //start
                if(status > 0){
                  
                  pg_mode = "w";
                  
                  if($(".lights").attr("id") == "#light"){
  
                    theme_type = "l";
                    bg_theme = "bg-light";
                  
                  }else{
                  
                    theme_type = "d";
                    bg_theme = "bg-dark";
                  
                  }

                  if(status == 1){
                    
                    f_t = $(".select-w").val();
                    f_v = $(".search-input-w").val();
              
                    pgiv = $(".page-size-w").text();

                  }else{
          
                    f_t = 0;
                    f_v = 0;
                    pgiv = 0;
              
                  }
                  
                  console.log(pg_mode+" "+status+" "+f_t+" "+f_v+" "+bg_theme);

                  //start att num pages default or filter
                  $.post("php/att/att_pgs.php", {"pg_mode":pg_mode, "status":status, "f_t":f_t, "f_v":f_v, "bg_theme":bg_theme, "pgiv":pgiv}, function(data){

                    if(pg_mode == "w"){
                      $(".pg-w ul").html(data);
                    }
                
                    if(pg_mode == "n"){
                      $(".pg-n ul").html(data);
                    }

                  });
                  //end 

                }
                //end

              });

              </script>
              <div id="network" class="space-fix-cc"></div>
              <h3 class="text-center card bg-theme text-bold text-light">Network resources</h3>
              <div class="col-md-12 card <?php bg_theme(); ?>">
                <strong class="text-center <?php text_color(); ?> mb-3 mt-3">Referral link: <a href='#' target='_new' title='Link de indicação'><?php referencia(); ?></a><i aria-hidden="true" id="copy_link" class="fa fa-files-o fa-1x float-right" onclick="copy_link();" style="position: absolute;margin-top: 4px;margin-left: 8px;"></i>
                  </strong>
                <strong class="color-theme mb-3">Network / referrals</strong>
                <div class="container">
                  <strong class="col-md-4 txt color-theme">Network:  
                    <a href="#"><?php qtd_users_ref(); ?></a> members(s)
                  </strong>
                  <strong class="col-md-4 txt color-theme">Referral earns: 
                    <a href="#"><?php qtd_bonus_ref(); ?></a>
                  </strong>
                </div>
                  <?php 
                    if($_GET['referral'] == "network"){ 
                      $network_page = "Resume";
                    }else if($_GET['referral'] == "analitics"){
                      $network_page = "Analitics";
                    }else if($_GET['referral'] == "banners"){
                      $network_page = "Banners";
                    }else if(!isset($_GET['referral'])){
                      $network_page = "Resume";
                    } 
                  ?>
                <div class="fluid-container" style="padding: 0px; margin: 0px auto !important;">
                  <a href="/backoffice.php" class="btn-resources bg-theme btn mb-3 text-light">Network</a>
                  <a href="?referral=analitics" class="btn-resources bg-theme btn mb-3 text-light">Analitics</a>
                  <a href="?referral=banners" class="btn-resources bg-theme btn mb-3 text-light">Banners</a>
                </div>
                <div class="fluid-container" style="max-height: 1000px; overflow-y: auto;">
                <?php

                  $email = $_SESSION['email'];
                  $get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
                  $array_user = mysqli_fetch_array($get_user);
                  $leader_nome = $array_user['f_nome']; 
                    
                ?>
                </div>
              </div>
              <div class="space-fix-cc"></div>
              <div id="box-menu" class="col-md-12 card <?php bg_theme(); ?>">
              <?php 
              if(!isset($_GET['referral']) || isset($_GET['referral']) && $_GET['referral'] != "banners-promo" && $_GET['referral'] != "analitics"){
                
               // include "php/ref/return_net_table.php";
              } 
              ?>
              </div>
            </div>           
          </div>
          <!-- start footer here -->
          <?php include "theme-parts/footer.php"; ?>
          <!-- end footer here -->
        </main>
      </div>

      <?php 
          
      $email = $_SESSION['email'];

      $get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
      $array_user = mysqli_fetch_array($get_usr);
      $idu = $array_user['id'];

      $get_deps = mysqli_query($con, "SELECT * FROM deposits WHERE id_user ='$idu'");
      $get_with = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$idu'");
      $get_nots = mysqli_query($con, "SELECT * FROM notifications WHERE email = '$email'");
      $get_dep_active = mysqli_query($con, "SELECT * FROM rel_deposits WHERE status = '1'");
      $get_rel_tkt_dep = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_user = '$idu'");
      $rows_dep = mysqli_num_rows($get_deps);
      $rows_with = mysqli_num_rows($get_with);
      $rows_nots = mysqli_num_rows($get_nots);
      $rows_rel_dep = mysqli_num_rows($get_dep_active);
      $rows_rl = mysqli_num_rows($get_rel_tkt_dep);

      ?>

      <?php include "php/with/modal-with.php"; ?>
      <?php include "php/dep/modal-dep.php"; ?>
      <?php include "php/ref/modal-ref.php"; ?>
      <?php include "php/not/modal-not.php"; ?>
      <?php include "php/lt/modal-lt.php"; ?>
      <?php if(isset($_GET['ref_name'])){ include "php/profile/show_users_profile.php"; } ?>
      <?php if(isset($_GET['earns_ref'])){ include "php/ref/earns.php"; } ?>

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/scripts.js"></script>
      <script type="text/javascript" src="js/lt-box.js"></script>
      <script type="text/javascript" src="js/help-box.js"></script>
      <script type="text/javascript" src="js/calc.js"></script>
      <script type="text/javascript" src="js/translate.js"></script>
      <!--<script src="js/popper.min.js"></script>--> 
  </body>
</html>
