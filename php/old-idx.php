<?php
$host =$_SERVER['REQUEST_METHOD'];
  if($host == "POST"){
    exit();
  }

session_start();
include "php/conn.php";
ini_set( 'display_errors', 0);

$ip = base64_encode($_SERVER['REMOTE_ADDR']);
$get_ip = mysqli_query($con, "SELECT * FROM user_config WHERE ipgeo='$ip'");
$ip_sets = mysqli_fetch_array($get_ip);

$date=date_create();
$check_ip_access_time = date_timestamp_get($date) - $ip_sets['last_datatime'];
$last_datatime = date_timestamp_get($date);

if($ip_sets['access_block'] == "true" && $ip_sets['ipgeo'] == $ip){
  
  if($check_ip_access_time >= 0){

    $update_access = mysqli_query($con, "UPDATE user_config SET access=access+1 WHERE ipgeo='$ip'");
    $update_reset_block = mysqli_query($con, "UPDATE user_config SET access_block = '' WHERE ipgeo = '$ip'");
    $update_reset_time = mysqli_query($con, "UPDATE user_config SET last_datatime = '$last_datatime' WHERE ipgeo = '$ip'");
  }else{
    $block_access_time = $ip_sets['last_datatime'] - date_timestamp_get($date);
    echo "<center>Account blocked for ".$block_access_time." seconds<br>reason abusive access on server.</center>";
    mysqli_close($con);
    exit();
  }

}else if($ip_sets['access_block'] == "" && $ip_sets['ipgeo'] == $ip && $ip_sets['access'] < 15 && $check_ip_access_time <= 20){

  $update_access = mysqli_query($con, "UPDATE user_config SET access=access+1 WHERE ipgeo='$ip'");

}else if($ip_sets['access_block'] == "" && $ip_sets['ipgeo'] == $ip && $ip_sets['access'] >= 15 && $check_ip_access_time <= 20){

  $ip_access_time_block = date_timestamp_get($date) + 300; //block for 5 min
  $update_access_block = mysqli_query($con, "UPDATE user_config SET access_block = 'true' WHERE ipgeo = '$ip'");
  $update_reset_access = mysqli_query($con, "UPDATE user_config SET access = 0 WHERE ipgeo = '$ip'");
  $update_reset_time = mysqli_query($con, "UPDATE user_config SET last_datatime = '$ip_access_time_block' WHERE ipgeo = '$ip'");

  echo "<center>Account blocked for 300 seconds<br>reason abusive access on server.</center>";
  mysqli_close($con);
  exit();

}else if($ip_sets['access_block'] == "" && $ip_sets['ipgeo'] == $ip && $ip_sets['access'] <= 15 && $check_ip_access_time > 20){

  $update_access = mysqli_query($con, "UPDATE user_config SET access=0 WHERE ipgeo='$ip'");
  $update_reset_time = mysqli_query($con, "UPDATE user_config SET last_datatime = '$last_datatime' WHERE ipgeo = '$ip'");

}

include "php/functions.php";

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/ico" href="images/coins/fxicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
      FX Robot
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- CSS Files -->
    <link link href="css/bootstrap.min.css?v=<?php echo filemtime('css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="css/style-all.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href=":https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <style type="text/css">
      .htl { position: relative; top: 25px; }
      .htl a{ font-size:20px; margin-left: 13px; }
      .htlb { position: relative; clear:both !important; }
      .float-c {margin: 0px auto !important; display:inline flow-root list-item; }
      .space-mb { margin-bottom: 10px !important; }
      .nav-idx-fixed { height:91px; }
      .nav-fixed-box { top:-25px; }
      .nav-idx a, .nav-idx-fixed a{ margin: 0px auto !important; } 
      .nav-mastheadt { display: flex; }
      @media only screen and  (max-device-width : 650px){
      .nav-idx a, .nav-idx-fixed a{ font-size: 5.5vw !important; margin-left: 0px; margin: 0px auto !important; top: 0px !important; } 
      .lfloat-left { float: none; }
      .nav-fixed-box { display: none; top:-29px; }
      .nav-mastheadt { display: none; }
      .fa-bars, .fa-close { display: block !important; }
     }
}
    </style>
     <style> 
      .skiptranslate { display: none !important; }
      body { top: 0px !important; }
    </style>
    <script type="text/javascript">
      setInterval(function(){
        
        scrolltop = window.scrollY;
   
        w = $("body").width();
        if(w < 650){
          $(".htl").addClass("clearb");
          $(".htl").css({"margin": "0px auto","clear": "both","top": "-9px"});
          $(".navbar-hm").removeClass("float-left");
          $(".navbar-hm").addClass("float-c");
          //$(".navbar-hm").css({"margin": "0px auto !important"});
        }else{
          $(".navbar-hm").addClass("float-left");
          $(".navbar-hm").removeClass("float-c");
          $(".htl").removeClass("clearb");
          $(".htl").css({"margin": "0px auto","clear":"inline-end","top":"25px"});
        }   

      }, 1);
    </script>
    <script type="text/javascript">
      $(window).on("load", function(){

        setTimeout(function(){

            // página totalmente carregada (DOM, imagens etc.)
            $(".fix").css("all", "unset");
            $("#loading").remove();
            $.getJSON("https://ipinfo.io/<?php echo $_SERVER['REMOTE_ADDR']; ?>", function(data){
              country = data['country'];
              $("body").attr("id", country);
            }); 

         }, 1000);
      });

      function show_mobile_menu(){
        
        wd = $("body").width();
        
        if(wd < 650){
          $(".nav-mastheadt").toggle();
        }
     
        if($(".nav-mastheadt").css("display") == "block"){
          $(".navm-toggle").removeClass("fa-bars");
          $(".navm-toggle").addClass("fa-close");
        }else{
          $(".navm-toggle").removeClass("fa-close");
          $(".navm-toggle").addClass("fa-bars");
        }    

      }
    </script>
  </head>
  <body class="text-center bg-light" onload="main_change();" onresize="main_change();">
    <div class="fix" style="width: :100%; width: 100%; height: 3000px; position: absolute; z-index: 10000;margin-top: 6%; background: rgba(17,18,36, 1);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
    <div class="fluid-container d-flex w-100 h-100 flex-column">
      <header class="col-md-12 masthead mb-auto bg bg-theme" style="z-index: 1; position: fixed;">
        <div class="inner navheader">
          <nav class="navbar-hm navbar float-left bg-theme" >
            <a href="index.php"><img src="images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="45px"></a>
          </nav>
          <i aria-hidden="true" class="navm-toggle fa fa-bars fa-2x text-light" onclick="show_mobile_menu();" style="top: 24px !important; position: absolute; left: 85%; display: none; top: 23px;"></i>   
        </div>
        <?php if(!isset($_SESSION['email'])){ ?>
          <nav class="nav nav-mastheadt htl htlm" style="margin: 0px auto;">
            <div class="col-md-8 float-left">
            <a class="text-light" href="#plans">Plan</a>
            <a class="text-light" href="#howwork">How work / About us</a>
            <a class="text-light" href="#referrals">Referral program</a>
            <a class="text-light" href="#events">Loterry</a>
            <a class="text-light" href="#info-idx">+ info</a>
            <a class="translate-drop dropdown" href="#translate" id="lang-translate"><img src="images/flags/gb.svg" width="25px" height="25px" alt="translate en"></a>
            </div>
            <div class="col-md-4 float-right">
              <a class="navd text-primary login btn btn-outline-light" href="#">Signin</a>
              <a class="navd text-success btn btn-outline-light" href="registro.php">Signup</a>
            </div>
          </nav>
        <?php }else{ ?>
           <nav class="nav nav-mastheadt htl htlm">
           <div class="col-md-8 float-left">
            <a class="text-light" href="#plans">Plan</a>
            <a class="text-light" href="#howwork">How work / About us</a>
            <a class="text-light" href="#referrals">Referral program</a>
            <a class="text-light" href="#events">Loterry</a>
            <a class="text-light" href="#info-idx">+ info</a>
            <a class="translate-drop dropdown" href="#translate" id="lang-translate"><img src="images/flags/gb.svg" width="25px" height="25px" alt="translate en"></a>
            </div>
            <div class="col-md-4 float-right">
              <a href="backoffice.php" class="text-primary btn btn-outline-light back-enter" href="#">Backoffice</a>
            </div>
          </nav>
        <?php } ?>
        <nav class="nav-header">
      
        </nav>
        <div class="dropdown-menu dropdown-menu-flags float-right dd" aria-labelledby="navbarDropdown">
          <span class="nav-link">Translate in: </span>
          <div class="dropdown-divider"></div>  
          <nav class="nav nav-select-flag">
            <ul class="container-fluid">
              <li class="nav-item choose-lang">
                <a class="nav-link" href="#default" onclick="changeLanguage('Português');"><img class=''src='images/flags/br.svg' title='Brazil' width='30px' height='30px' alt='br flags'></a>
              </li>
              <li class="nav-item choose-lang">
                <a class="nav-link "href="#ru" onclick="changeLanguage('Russo');"><img src='images/flags/ru.svg' title='Russia' width='30px' height='30px' alt='ru flag'></a>
              </li>
               <li class="nav-item choose-lang" onclick="changeLanguage('Inglês');">
                <a class="nav-link "href="#en"><img src='images/flags/gb.svg' title='Inglês' width='30px' height='30px' alt='inglês flag'></a>
              </li>
              <!--<li class="nav-item choose-coin">
                <a class="nav-link" href="#usdt">tether <img class='img-action-sm'src='images/coins/usdt-sm.png' title='usdt' width='22px' height='22px' alt='usdt coin'></a>
              </li>-->
            </ul>
          </nav>
        </div>
      </header>
      <div class="custom-translate" id="google_translate_element" style="display: block;"></div>
      <script type="text/javascript">
      function changeLanguage(lang) {

        count = 0;
        var iframe = document.getElementsByClassName("skiptranslate")[1];
        elmnt = iframe.contentWindow.document.getElementsByTagName("span")[2];
        elmnt.click();
        while(count < 1000){
          var iframe = document.getElementsByClassName("skiptranslate")[4];
          var elmnt = iframe.contentWindow.document.getElementsByTagName("span")[count];
          el = elmnt.innerText;
          if(el==lang){
            elmnt.click();
            count = 1000;
          }
          count++;
        }

        if(lang == "Português"){
          f = "br";
        }else if(lang == "Russo"){
          f = "ru";
        }else if(lang == "Inglês"){
          f = "gb";
        }
        $(".translate-drop img").attr("src","images/flags/"+f+".svg");

        let myReferenceDiv = document.getElementById('goog-gt-tt');
        let next = myReferenceDiv.nextElementSibling;
        next.style.display ="none";
      }
      </script>
      <script type="text/javascript">
        function googleTranslateElementInit() {
          new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: true},'google_translate_element');
        }

          var googleTranslateScript = document.createElement('script');
          googleTranslateScript.type = 'text/javascript';
          googleTranslateScript.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
          document.getElementsByTagName('body')[0].appendChild( googleTranslateScript );
      </script> 
      <!--<div class="fluid-container">
        <div class="float-right">
          <img src="images/img-theme02.png">
        </div>
        <div class="float-left">
          <img src="images/img-theme01.png">
        </div>
      </div>-->
      <div class="modal modal-login text-primary" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-light" align="center">Access you account</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" name="formlogin" class="formlogin">
                <div class="form-group">
                  <label for="formGroupExampleInput2 text-primary">E-mail</label>
                  <input type="email" class="form-control text-primary emaillogin" name="emailogin" id="emaillogin" placeholder="E-mail válido">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput2 text-primary">Password</label>
                  <input type="password" class="form-control text-primary senhalog" name="senhalogin" id="senhalog" placeholder="Password account">
                </div>
                 <div class="return-login"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary fazer-login">Login</button>
              <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
            </div>
          </div>
        </div>
      </div>

      <div class="modal modal-calc text-primary" tabindex="-1" role="dialog" style="margin-top: 10%;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-light" align="center">Calculator</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" name="formlogin" class="formlogin">
                <div class="form-group">
                  <label for="formGroupExampleInput2 text-primary"></label>
                  <div class="box-option col-md-4 float-right">
                    <select>
                      <option title="started" class="text-primary" onclick="selected_op(0);">Starter 4 %</option>
                      <option title="advanced"  class="text-primary" onclick="selected_op(1)">Advanced 5.5 %</option>
                      <option title="premium"  class="text-primary" onclick="selected_op(2)">Premium 7 %</option>
                    </select>
                  </div>
                  <input type="text" name="valor calc" id="valcalc" placeholder="Amount" onkeyup="calcprofit();" class="form-control text-primary valcalc col-md-7 float-left">
                  <i class="fa fa-calculator fa-2x float-left" aria-hidden="true" style="margin-top: -20px !important; margin-left: 8px !important;"></i>
                </div>
              
                 <div class="return-calc float-right"></div>
              </form>
            </div>
           <!-- <div class="modal-footer">
              <button type="button" class="btn btn-primary fazer-login">Entrar</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div> -->
          </div>
        </div>
      </div>
  
      <main role="main" class="fluid-container container main main_off">
        <br>
        <h1 class="cover-heading text-primary" style=" font-size: 45px;"><?php echo titulo(); ?></h1>
        <p class="lead text-center desc text-dark"><?php echo descricao(); ?></p>
        <div class="row center" style="overflow-y: auto; padding: 0px 0px; margin-top:-5%; margin: 80px 0px;">
          <h1 class="text-center" style="position: relative; margin: 0px auto !important;">Plans / Package's</h1>
          <marquee class="text-primary" style="font-size: 19px;">Online lottery with incredible winnings and stable reward plans.</marquee>

          <div class="col-md-4 bg-theme text-light space-mb sp-mg-plan">
            <h2 class="text-primary">Starter</h2>
            <h3>$ 0.5 / 12 hours</h3>
            <p class="text-sm-start" style="font-size: 12px;">
              receive 100 tickets = $ 0.20 each
            </p>
            <p class="text-sm-start" style="font-size: 11px;">
             Entry plan with basic maximum limit, essential to get good rewards on daily lotteries.
            </p>
            <a href="#min-started">Min:</a><span> $ 0.20</span> <a href="#max-started">Max:</a><span> $ 100</span>
            <p class="txtp" style="font-size: 14px;">earnings per referral <i class="fa fa-check-square" aria-hidden="true"></i></p>        
            <p class="txtp" style="font-size: 14px;">week promotion <i class="fa fa-window-close" aria-hidden="true"></i></p>   
            <p class="txtp" style="font-size: 14px;">low rakeback <i class="fa fa-check-square" aria-hidden="true"></i></p> 
            <a href="#fx-loterry-idxa" type="button" class="btn btn-sm btn-outline-light float-right btn-calc bg-theme text-light" id="starter">+ info</a>
          </div>
          <div class="col-md-4 bg-theme text-light space-mb sp-mg-plan" id="plans">
            <h2 class="text-primary">Advanced</h2>
            <h3>$ 1 / 12 hours</h3>
            <p class="text-sm-start" style="font-size: 12px;">
              receive 250 tickets = $ 0.20 each

            </p>
            <p class="text-sm-start " style="font-size: 11px;">
            Ideal for moderate investors who want to have good returns and excellent daily rewards.
            </p>
            <a href="#min-advanced">Min:</a><span> $ 0.20</span> <a href="#max-advanced">Max:</a><span> $ 250</span>
            <p class="txtp" style="font-size: 14px;">earnings per referral <i class="fa fa-check-square" aria-hidden="true"></i></p>   
            <p class="txtp" style="font-size: 14px;">week promotion <i class="fa fa-check-square" aria-hidden="true"></i></p>
            <p class="txtp" style="font-size: 14px;">medium rakeback <i class="fa fa-check-square" aria-hidden="true"></i></p>    
            <a href="#fx-loterry-idxa" class="btn btn-sm btn-outline-light float-right btn-calc bg-theme text-light" id="advanced">+ info</a>
          </div>
          <div class="col-md-4 bg-theme text-light space-mb sp-mg-plan">
            <h2 class="text-primary">Premium</h2>
            <h3>$ 2 / 12 hours</h3>
            <p class="text-sm-start" style="font-size: 12px;">
             receive 500 tickets = $ 0.20 each
            </p>
            <p class="text-sm-start" style="font-size: 11px;">
             Ideal for high-end investors, with a greater number of tickets per lottery, they can generally have a higher winning percentage.
            </p>
            <a href="#min-premium">Min:</a><span> $ 0.20</span> <a href="#max-premium">Max:</a><span> $ 500</span>  
            <p class="txtp" style="font-size: 14px;">earnings per referral <i class="fa fa-check-square" aria-hidden="true"></i></p>   
            <p class="txtp" style="font-size: 14px;">week promotion <i class="fa fa-check-square" aria-hidden="true"></i></p>  
            <p class="txtp" style="font-size: 14px;">high rakeback <i class="fa fa-check-square" aria-hidden="true"></i></p>       
            <a href="#fx-loterry-idxa" class="btn btn-sm btn-outline-light float-right btn-calc bg-theme text-light" id="premium">+ info</a>
          </div>
           <marquee class="text-primary" style="font-size: 19px;">Each plan contains a maximum number of tickets that can be used in lottery rounds.</marquee>

           <div class="col-md-4 float-left" style="margin-top: 3%;">
            <div class="float-left col-md-6"><a href="#login" class="login text-light btn btn-sm bg-primary col-md-12">Sign-in</a></div> 
            <div class="float-right col-md-6"><a href="registro.php" class="text-light btn btn-sm bg-success col-md-12">Sign-up</a></div> 
           </div>
            <div class="col-md-4 float-right bg-light" style="margin-top: 3%;">
             
           </div>
           <div class="col-md-4 float-right bg-light" style="margin-top: 3%;">
             Enjoy now !
           </div>
        </div>
        <div style="height: 2px; width:100%" class="bg-theme"></div>

        <div class="col-md-12" style="height: 150px; margin-top: 5%;">
          <!--<p class="text-light float-left" style="margin-top: 2.5%;">Accepted:</p> -->
          <div class="coins-valid float-right"><img src="images/coins/btc-sm.png" height="40px"></div>
          <div class="coins-valid float-right"><img src="images/coins/busd-sm.png" height="40px"></div>
          <div class="coins-valid float-right"><img src="images/coins/eth-sm.png" height="40px"></div>
          <div class="coins-valid float-right"><img src="images/coins/usdt-sm.png" height="40px"></div>
          <div class="coins-valid float-right"><img src="images/coins/trx-sm.png" height="40px"></div>
          <div class="coins-valid float-right"><img src="images/coins/pix.png" height="40px"></div>
          <div class="coins-valid float-right">
            <p class="text-primary float-left">Accepted:</p>
          </div>
        </div>
        <h1 class="text-primary" style="border-bottom: 2px solid #111224;" id="howwork">About us - How work</h1>
        <div class="about-more container" style="background-size: 100% 100% !important; height: 500px;">
          <div class="col-md-6 float-left" style="min-height: 250px"><i aria-hidden="true" class="fa fa-globe fa-5x float-left" style="position: relative !important; float:left !important; margin-top: 70px; margin-left: 202px !important;"></i></div>
          <div class="col-md-6 float-right bg-theme" style="min-height: 250px;">
           <p class='text-light text-justify' style="padding: 10px;"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi. Curabitur placerat ipsum ac fringilla ultricies. Fusce porttitor justo mauris, sit amet vulputate quam volutpat et. Vestibulum vel fringilla neque. Quisque ultrices viverra varius. Vivamus egestas mauris at turpis interdum facilisis. Praesent tristique eget nulla et imperdiet. Etiam congue, nulla ac viverra imperdiet, mauris urna gravida neque, quis dignissim mi dui ut erat. Nulla sit amet feugiat lacus. Etiam ac dapibus urna. Integer ultrices tincidunt magna.</p>
          </div>
          <div class="fix-clear-box" style="clear: both !important;"></div>
          <div class="col-md-6 float-right" style="min-height: 250px; float: right !important;"><i class="fa fa-cogs fa-5x" aria-hidden="true" style="position: relative !important; float: right !important; margin-top: 70px; margin-right: 202px !important;"></i>
          </div>
          <div class="col-md-6 float-left bg-theme" style="position:relative; min-height: 250px;">
           <p class='text-light text-justify' style="padding: 10px;"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi. Curabitur placerat ipsum ac fringilla ultricies. Fusce porttitor justo mauris, sit amet vulputate quam volutpat et. Vestibulum vel fringilla neque. Quisque ultrices viverra varius. Vivamus egestas mauris at turpis interdum facilisis. Praesent tristique eget nulla et imperdiet. Etiam congue, nulla ac viverra imperdiet, mauris urna gravida neque, quis dignissim mi dui ut erat. Nulla sit amet feugiat lacus. Etiam ac dapibus urna. Integer ultrices tincidunt magna.</p>
          </div>
        </div>
          <div class="space-fix-idx" style="height: 80px;"></div>
          <h1 class="text-primary" style="border-bottom: 2px solid #111224;" id="referrals">Referral program</h1>
        <div class="referral-program container bg-light" style="">
          <div class="col-md-6 float-left" style="height: 250px"><i class="fa fa-sitemap fa-5x" aria-hidden="true" style="position: relative !important; float: left !important; margin-top: 70px; margin-left: 202px !important;"></i>
          </div>
          <div class="col-md-6 float-right bg-theme" style="min-height: 250px;">
           <div class="col-md-12" style="font-size: 20px; padding: 10px;">
              <p class="text-light">3 Network levels</p>
              <a href="#">4 % earn direct referral</a><br>
              <a href="#">2° level 2.5 % earn </a><br>
              <a href="#">1° level 1% earn </a>
              <br><br>
              <p class="text-light small">I earn for each package purchased, which can be one or more per account.</p>
            </div>
          </div>
        </div> 
        <div class="space-fix-idx"></div>
          <div id="fx-loterry-idxa" class="banner-lt">
           <img src="images/banners/banner-idx-desktop.png" width="700px" height="80px">
          </div>
           <div class="space-fix-idx"></div>
          <div class="col-md-12" id="events" style="height: 400px">
          <div id="fx-loterry-idxa" class="fx-loterry-idx col-md-4 float-left bg-theme" style="padding: 10px; max-height: 400px; overflow-y: auto;">
            <h4 class="text-light">Daily FX Loterry <small class="text-primary">Exclusive promo</small></h4>
            <hr>
            <h5 class="text-primary">How earn</h5>
            <span class="text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat.</span>
            <h5 class="text-primary">Terms</h5>
            <span class="text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat.</span>
            <h5 class="text-primary">Requeriments</h5>
            <small class="text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat.</small>
            <br><a class="btn btn-sm btn-outline-light" href="registro.php" target="_new" style="clear: both;">Join us</a>
          </div>
          <div class="space-fix-m"></div>
          <div class="col-md-8 float-right">
            <?php 
            $last_lt_winners = mysqli_query($con, "SELECT * FROM loterry_session WHERE id > 0 AND loterry_session > 0 ORDER BY id DESC LIMIT 1");
            $array_last_session_lt = mysqli_fetch_array($last_lt_winners);
            $last_session_lt = $array_last_session_lt['id'];
            ?>
            <h4 class="text-light bg-theme">Last winners - <small><?php echo $array_last_session_lt['data']; ?></small></h4>
            <div class="daily-winners container">
              <!-- <table class="table table-striped">
                <thead>
                  <th>#</th>
                  <th>Name</th>
                  <th>Tickets</th>
                  <th>Earn</th>
                  <th>Parcial</th>
                </thead>
                <tbody> -->
                  <?php 
                  $get_last_lt_win = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id >= 1");
                  $count_last_win_lt = 1;  
                  while($array_last_win_lt = mysqli_fetch_array($get_last_lt_win)){
                    $id_user_win = $array_last_win_lt['id_user'];
                    $get_user_name_win = mysqli_query($con, "SELECT * FROM usuarios WHERE id ='$id_user_win'");
                    $array_name_win = mysqli_fetch_array($get_user_name_win);
                    $user_name_w = $array_name_win['f_nome'];
                  ?>
                  <div class="cardb bg-light" style="border-bottom:1px solid #111224;">
                    
                    <div class="card-body">
                      <div class="" style="width: 80px;height: 80px;float: left;">
                        <img class="rounded-circle float-right" title="Paulo" width="75" height="75" src="php/imagesperfil/7.jpg" alt="Last winners img" style="float: left;">
                        <small class="color-theme"><?php echo $count_last_win_lt; ?>° st <?php echo $user_name_w; ?></small>
                      </div>
                    </div>

                    <div class="row fluid-container">
                      <div class="col-md-4">Total ickets: <a href="#"><?php echo $array_last_win_lt['total_ticket']; ?></a> <i class="fa fa-cubes fa-1x" aria-hidden="true"></i>
                      </div>
                      <div class="col-md-4">Total earn: <a href="#"><?php echo "$ ".$array_last_win_lt['total_earn']; ?></a> <i class="fa fa-trophy fa-1x" aria-hidden="true"></i>
                      </div>
                      <div class="col-md-4">Parcial: <a href="#"><?php echo $array_last_win_lt['parcial']." %"; ?></a>
                      </div>
                    </div>
                    <div class="card-body">
                      <!--<a href="#" class="card-link">Link do card</a>
                      <a href="#" class="card-link">Outro link</a>-->
                      <div class="col">
                        <img src="images/coins/usdt-sm.png" title="usdt" width="25" height="25" alt="busd coin" style="opacity: 0.60;">
                        <img src="images/coins/btc-sm.png" title="Paid in btc" width="25" height="25" alt="coin selected">
                        <img src="images/coins/eth-sm.png" title="ethereum" width="25" height="25" alt="coin selected" style="opacity: 0.60;"> 
                        <img src="images/coins/busd-sm.png" title="busd" width="25" height="25" alt="coin selected" style="opacity: 0.60;">
                        <img src="images/coins/ltc-sm.png" title="ltc" width="25" height="25" alt="coin selected" style="opacity: 0.60;">
                        <img src="images/coins/trx-sm.png" title="trx" width="25" height="25" alt="coin selected" style="opacity: 0.60;">
                        <img src="images/coins/pix.png" title="pix" width="25" height="25" alt="coin selected" style="opacity: 0.60;"><br>
                        <small class="text-muted">#lt<?php echo $last_session_lt; ?></small>
                        <small class="text-muted"><?php echo $array_last_win_lt['data']; ?></small>
                      </div>
                    </div>
                  </div>
                  <!--<tr class="">
                    <td class="<?php if($count_last_win_lt % 2 != 0){ echo "bg-striped-lt"; }else{ echo "bg-light"; } ?> <?php if($count_last_win_lt % 2 != 0){ echo "color-theme"; }else{ echo "color-theme"; } ?>"><?php echo $count_last_win_lt; ?>° st</td>
                    <td class="<?php if($count_last_win_lt % 2 != 0){ echo "bg-striped-lt"; }else{ echo "bg-light"; } ?> <?php if($count_last_win_lt % 2 != 0){ echo "color-theme"; }else{ echo "color-theme"; } ?>"><i class="fa fa-user fa-1x" aria-hidden="true"></i> <?php echo $array_last_win_lt['nick']; ?></td>
                    <td class="<?php if($count_last_win_lt % 2 != 0){ echo "bg-striped-lt"; }else{ echo "bg-light"; } ?> <?php if($count_last_win_lt % 2 != 0){ echo "color-theme"; }else{ echo "color-theme"; } ?>"><?php echo $array_last_win_lt['total_ticket']; ?> <i class="fa fa-cubes fa-1x" aria-hidden="true"></i></td>
                    <td class="<?php if($count_last_win_lt % 2 != 0){ echo "bg-striped-lt"; }else{ echo "bg-light"; } ?> <?php if($count_last_win_lt % 2 != 0){ echo "color-theme"; }else{ echo "color-theme"; } ?>"><?php echo "$ ".$array_last_win_lt['total_earn']; ?> <i class="fa fa-trophy fa-1x" aria-hidden="true"></i></td>
                    <td class="<?php if($count_last_win_lt % 2 != 0){ echo "bg-striped-lt"; }else{ echo "bg-light"; } ?> <?php if($count_last_win_lt % 2 != 0){ echo "color-theme"; }else{ echo "color-theme"; } ?>"><?php echo $array_last_win_lt['parcial']." %"; ?></td>
                  </tr>-->
                  <?php $count_last_win_lt++; } ?>
                  <!--
                  <tr class="color-striped">
                    <td>2° st</td>
                    <td>l00p4</td>
                    <td>2</td>
                    <td>$ 30</td>
                    <td>04.30.24</td>
                  </tr> -->
                <!-- </tbody>
              </table> -->
            <nav>
              <ul>
                <li>Total investors: <a href="#">50</a></li>
                <li>Total tickets: <a href="#">240</a></li>
                <li>Total winners: <a href="#">3</a></li>
                <li>Total paid: <a href="#">$ 120</a></li>
              </ul>
            </nav>
            <small style="position: relative; float: left; margin-top:10px;">In total 50% of participants will receive part of 80% of the total value of the daily draw. There is 20% left for the system to carry out the activities. <b>*</b> Note that 50% of participants is a ratio to the number of lottery participants, if the total number of participants is not divisible by 2, whose total division is exact, the system will round up the total prizes to - 1 winner in the round.<br><b>E.g. 55 participants is not divisible by 2, so 54 drawn will win.</b></small><br>
            <!-- <img src="images/daily-promo.png" width="600px" height="80px"> -->
            Text daily promo<i class="fa fa-gift fa-2x" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <div class="space-fix-idx-2"></div>
        <div class="container float-left" style="margin-top: 10%;"> 
          <h2>Current Loterry <?php echo date('m/d/y - h:i:s'); ?> <i class="fa fa-calendar fa-2x" aria-hidden="true"></i></h2>
          <div class="current-loterry-container container col-md-12 bg-theme">
            <nav class="col-md">
              <ul>
                <li>Total participants: <a href="#">10</a> <i class="fa fa-users fa-1x" aria-hidden="true"></i></li>
                <li>Total reward: <a href="#">100</a> <i class="fa fa-cubes fa-1x" aria-hidden="true"></i></li>
                <li>Total winners: <a href="#">3 </a> <i class="fa fa-trophy fa-1x" aria-hidden="true"></i></li>
              </ul>

              <?php $get_seconds = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
              $arfx = mysqli_fetch_array($get_seconds);
              $seconds_rest = $arfx['fx_loterry_time']; ?>
              <?php 
              if($seconds_rest >= 3600){
              
                $convert_time = $seconds_rest / 3600;
                $convert_time_h = substr($convert_time, 0, 2);
                
                if(substr($convert_time_h, 1) == "."){
                  $convert_time_h = substr($convert_time_h, 0, 1);
                }

                $get_min = substr($convert_time, 3);
                $min = floor(($seconds_rest - (number_format($convert_time, 16, ',', '') * 3600)) / 60);
                $seg = floor($seconds_rest % 60);
            
              }
              ?>
               <h5 class="lt-time ltime-b text-primary">Time end in:<br><br><i class="fa fa-clock-o" aria-hidden="true"></i><span class="span-h">&nbsp<?php echo $convert_time_h; ?></span> hs: <span class="span-m"><?php echo $min; ?></span> min: <span class="span-s"><?php echo $seg; ?></span> seg</h5>
            </nav>
            <br><small class="text-primary">Reset each 12 hs.</small>
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

                }, 1000);
              })
            </script>
            <h4 class="text-light">Last tickets sold</h4>
              <marquee style="height: 30px; width: 100%;">  
                <nav class="nav-last-buy-tkt" style="top: 0px; margin: 0px; padding: 0px;">
                  <ul>
                    <li style="color: #fff; font-size: 20px;">
                       <img src="php/imagesperfil/7.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#">buy 10 tickets</a>
                    </li>
                    <li style="color: #fff; font-size: 20px;">
                       <img src="php/imagesperfil/57.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#">buy 10 tickets</a>
                    </li>
                    <li style="color: #fff; font-size: 20px;">
                       <img src="php/imagesperfil/10.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#">buy 10 tickets</a>
                    </li>
                    <li style="color: #fff; font-size: 20px;">
                       <img src="php/imagesperfil/43.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#">buy 10 tickets</a>
                    </li>
                  </ul>
                </nav>
              </marquee>
              <style type="text/css">
                .nav-last-buy-tkt ul li { display:inline !important; margin-left: 10px; font-size: 12px !important; }
                .depo-user:hover { display: inline-block; color: #fff !important; background: rgba(17, 18, 36, 0.9); cursor: pointer; }
              </style>
          </div>
        </div>
        <div class="col-md-12 bg-light" id="info-idx" style="height: 400px; display: none;">
          
        </div>
        <div class="space-fix-idx"></div>
        <div class="binance-api">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5120 1024" class="header-logo" width="150px" height="50px" fill="currentColor"><path d="M230.997333 512L116.053333 626.986667 0 512l116.010667-116.010667L230.997333 512zM512 230.997333l197.973333 197.973334 116.053334-115.968L512 0 197.973333 314.026667l116.053334 115.968L512 230.997333z m395.989333 164.992L793.002667 512l116.010666 116.010667L1024.981333 512l-116.992-116.010667zM512 793.002667l-197.973333-198.997334-116.053334 116.010667L512 1024l314.026667-314.026667-116.053334-115.968L512 793.002667z m0-165.973334l116.010667-116.053333L512 396.032 395.989333 512 512 626.986667z m1220.010667 11.946667v-1.962667c0-75.008-40.021333-113.024-105.002667-138.026666 39.978667-21.973333 73.984-58.026667 73.984-121.002667v-1.962667c0-88.021333-70.997333-145.024-185.002667-145.024h-260.992v561.024h267.008c126.976 0.981333 210.005333-51.029333 210.005334-153.002666z m-154.026667-239.957333c0 41.984-34.005333 58.965333-89.002667 58.965333h-113.962666V338.986667h121.984c52.010667 0 80.981333 20.992 80.981333 58.026666v2.005334z m31.018667 224c0 41.984-32.981333 61.013333-87.04 61.013333h-146.944v-123.050667h142.976c63.018667 0 91.008 23.04 91.008 61.013334v1.024z m381.994666 169.984V230.997333h-123.989333v561.024h123.989333v0.981334z m664.021334 0V230.997333h-122.026667v346.026667l-262.997333-346.026667h-114.005334v561.024h122.026667v-356.010666l272 356.992h104.96z m683.946666 0L3098.026667 228.010667h-113.962667l-241.024 564.992h127.018667l50.986666-125.994667h237.013334l50.986666 125.994667h130.005334z m-224.981333-235.008h-148.992l75.008-181.973334 73.984 181.973334z m814.037333 235.008V230.997333h-122.026666v346.026667l-262.997334-346.026667h-114.005333v561.024h122.026667v-356.010666l272 356.992h104.96z m636.970667-91.008l-78.976-78.976c-44.032 39.978667-83.029333 65.962667-148.010667 65.962666-96 0-162.986667-80-162.986666-176v-2.986666c0-96 67.968-174.976 162.986666-174.976 55.978667 0 100.010667 23.978667 144 62.976l78.976-91.008c-51.968-50.986667-114.986667-86.997333-220.970666-86.997334-171.989333 0-292.992 130.986667-292.992 290.005334V512c0 160.981333 122.965333 288.981333 288 288.981333 107.989333 1.024 171.989333-36.992 229.973333-98.986666z m527.018667 91.008v-109.994667h-305.024v-118.016h265.002666v-109.994667h-265.002666V340.992h301.013333V230.997333h-422.997333v561.024h427.008v0.981334z" p-id="2935"></path></svg>
           <p>Integrated</p>
        </div>
        <!--<div class="box-newslatter col-md float-right bg-theme float-right">
          <h5>Do you want to receive news?</h5>
          <form>
            <input class="news-email bg-theme text-light" placeholder="Put your email">
            <button>Send</button>
          </form>
        </div>-->
        <div class="fluid-container col-md-12 dep-user-container" style="height: 350px !important; float: left; position: relative;">
          <h2>Feedback's</h2>
          <div style="height: 30px;"></div>
          <div class="depo-user" style="display: inline-block;">
            <img src="php/imagesperfil/7.jpg" width="100" height="100" alt="user feedback" class="rounded-circle">
            <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #28a745 !important;"></div>Paulo</small>
          </div>
          <div class="depo-user" style="display: inline-block;">
            <img src="php/imagesperfil/43.jpg" width="100" height="100" alt="user feedback" class="rounded-circle">
            <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #28a745 !important;"></div>fx</small>
          </div>
          <div class="depo-user" style="display: inline-block;">
            <img src="php/imagesperfil/57.jpg" width="100" height="100" alt="user feedback" class="rounded-circle">
            <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #ccc;"></div>akmedis</small>
          </div>
          <div class="depo-user" style="display: inline-block;">
            <img src="php/imagesperfil/45.jpg" width="100" height="100" alt="user feedback" class="rounded-circle">
            <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #ccc;"></div>fxadm</small>
          </div>
          <div class="depo-user" style="display: inline-block;">
            <img src="php/imagesperfil/10.jpg" width="100" height="100" alt="user feedback" class="rounded-circle">
            <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #28a745 !important;"></div>bitsler</small>
          </div>
          <div class="col-md-12 color-theme" style="height: 110px;">
            <div class="return-depoiment col-md-10" style="margin: 25px auto !important">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat.</p>
            </div> 
          </div>
          <script type="text/javascript">

            //init show dep
            $(".depo-user:eq(0)").addClass("depo-user-selected");
            $(".depo-user:eq(0)").addClass("align-depo-user-1");
            setInterval(function(){

              qtd_feedback = $(".depo-user").length;
            
              for (var i = qtd_feedback - 1; i >= 0; i--) {
            
                if($(".depo-user:eq("+i+")").attr("class") == "depo-user depo-user-selected align-depo-user-1"){
            
                  $(".depo-user:eq("+i+")").removeClass("depo-user-selected");
                  $(".depo-user:eq("+i+")").removeClass("align-depo-user-1");
                  $(".depo-user:eq("+i+")").addClass("align-depo-user-0");
                  next = i+1;
                
                }
                
                if(i == 0){

                  max_units = qtd_feedback - 1;
                  
                  if(next > max_units){
                    next = 0;
                  }

                  $(".depo-user:eq("+next+")").removeClass("align-depo-user-0");
                  $(".depo-user:eq("+next+")").addClass("depo-user-selected");
                  $(".depo-user:eq("+next+")").addClass("align-depo-user-1");
                  
                  name = $(".depo-user:eq("+next+") small").text();

                  $.post("php/profile/show_depoiment.php",{"user":name}, function(data){
                    $(".return-depoiment").text(data);
                  });

                } 
              
              }
              
            }, 3000);
            //init show dep 
          </script>
        </div>
      </main>
      <footer class="bg-theme" style="">
        <div class="container" style="height: 25px;"></div>
        <div class="col text-light mg-footer">
          <div class="col-md-4 float-left inim" style="height: 40px; top: 10% !important; position: relative; margin-top: 2.8% !important;">
            <p class="f">Investe FX Robot @ <a href="https://getbootstrap.com/">Trader center</a>,  <a href="https://twitter.com/mdo">2024</a>.</p>     
          </div>
          <div class="col-md-4 float-left inim">
            <div class="col-md-12" style="margin: 0px auto !important;">
              <nav class="nav-footer-idx float-left">
                <ul>
                  <li>
                     <a href="#">Login</a>
                  </li>
                  <li>
                     <a href="#">Register</a>
                  </li>
                  <li>
                     <a href="#">Faq</a>
                  </li>
                  <li>
                     <a href="#">Terms</a>
                  </li>
                </ul>
              </nav> 
               <nav class="nav-footer-idx float-left">
                <ul>
                  <li>
                     <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-telegram" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                  </li>

                </ul>
              </nav> 
               <nav class="nav-footer-idx float-left">
                <ul>
                  <li>
                     <a href="#">Login</a>
                  </li>
                  <li>
                     <a href="#">Register</a>
                  </li>
                  <li>
                     <a href="#">Faq</a>
                  </li>
                  <li>
                     <a href="#">Terms</a>
                  </li>
                </ul>
              </nav> 
            </div>
          </div>
          <div class="col-md-4 float-right inim" style="height: 40px; top: 10% !important; position: relative; margin-top: 2.8% !important;">
             <a href="https://www.infinityfree.com" target="_new">Sponsored By:
            <img src="https://vpassets.infinityfree.net/welcome2017/logo.png" alt="InfinityFree" height="40px">
          </a>
          </div>
        </div>
      </footer>
    </div>
    <!--<footer class="col-md-12 footer ff float-left bg-theme" style="height: auto">
      <div class="container" style="height: 25px;"></div>
      <div class="col text-light mg-footer">
        <div class="col-md-4 float-left inim" style="height: 40px">
          <p class="f">Investe FX Robot @ <a href="https://getbootstrap.com/">Trader center</a>,  <a href="https://twitter.com/mdo">2024</a>.</p>     
        </div>
        <div class="col-md-4 float-left inim">
          <div class="col-md-12" style="margin: 0px auto !important;">
            <nav class="nav-footer-idx float-left">
              <ul>
                <li>
                   <a href="#">Login</a>
                </li>
                <li>
                   <a href="#">Register</a>
                </li>
                <li>
                   <a href="#">Faq</a>
                </li>
                <li>
                   <a href="#">Terms</a>
                </li>
              </ul>
            </nav> 
             <nav class="nav-footer-idx float-left">
              <ul>
                <li>
                   <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li>
                   <a href="#"><i class="fa fa-telegram" aria-hidden="true"></i></a>
                </li>
                <li>
                   <a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a>
                </li>

              </ul>
            </nav> 
             <nav class="nav-footer-idx float-left">
              <ul>
                <li>
                   <a href="#">Login</a>
                </li>
                <li>
                   <a href="#">Register</a>
                </li>
                <li>
                   <a href="#">Faq</a>
                </li>
                <li>
                   <a href="#">Terms</a>
                </li>
              </ul>
            </nav> 
          </div>
        </div>
        <div class="col-md-4 float-right inim" style="height: 40px;">
           <a href="https://www.infinityfree.com" target="_new">Sponsored By:
          <img src="https://vpassets.infinityfree.net/welcome2017/logo.png" alt="InfinityFree" height="40px">
        </a>
        </div>
      </div>
    </footer>-->
     <!-- <script type="text/javascript">
       $(document).ready(function(){

          smh = window.innerHeight;
          smw = window.innerWidth;
          if(smw < 950){
            document.getElementsByClassName("ff")[0].style.marginTop=smh+"px";
            document.getElementsByClassName("ff")[0].style.position="absolute";
            document.getElementsByClassName("ff")[0].style.width="100%";
          }

        });
    </script>-->
    <script src="js/calc.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/translate.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
