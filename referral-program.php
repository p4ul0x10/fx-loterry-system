<?php

$host =$_SERVER['REQUEST_METHOD'];
  if($host == "POST"){
    exit();
  }

session_start();
include "php/conn.php";
ini_set( 'display_errors', 0);
//QN266254774BR
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
      FX Loterry - Referral program
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        
    <!-- CSS Files -->
    <link link href="css/bootstrap.min.css?v=<?php echo filemtime('css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="css/style-all.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
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
    .navbar-toggler-icon { color:#fff !important; }
    .last-win-block-img small { float: left; margin: 0px 78px; margin-left: 110px; top: 0px; margin-top: -42px; display: block ruby; }
    .main .row { margin-top: 20px; margin-bottom: 50px; }
    .referral-program .col-sitemap { height: 250px; }
    .referral-program .row .col { display: block ruby; }
    .col-sitemap { border: 1px solid #111224; }
    .fa-sitemap { margin: 0px auto !important; }
    .net-ico { margin-top: 42px; }
    .login:hover { border-radius: 0.25em !important; border: 1px solid #fff !important; }
    .lg { margin-right: 7px; }
    .dropdown img { vertical-align: bottom !important; }
    @media only screen and  (max-device-width : 650px){
    .form-inline a, .back-enter{ margin: 0px auto !important; }
    }
    </style>
    <style> 
    .skiptranslate { display: none !important; }
    body { top: 0px !important; }
    </style>
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
            document.getElementsByTagName("header")[0].style.zIndex='10000';
        
         }, 1000);

        h = window.innerHeight;

        if(h > 906){

          ajust_footer = parseFloat(h) - parseFloat(906);
          mg_footer = parseFloat(200) + parseFloat(ajust_footer);
        
          //document.getElementsByClassName("footer")[0].style.top = mg_footer+"px";
        
        }

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
    <div class="fix" style="width: 100%; height: 3000px; position: absolute; z-index: 10000;margin-top: 6%; background: rgba(17,18,36, 1);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
    <div class="fluid-container">
      <!-- start header here -->
      <?php include "theme-parts/header.php"; ?>
      <!-- end header here -->
       <script type="text/javascript">
        function getBrowserName(userAgent) {

          // The order matters here, and this may report false positives for unlisted browsers.

          if(userAgent.includes("Firefox")){
            // "Mozilla/5.0 (X11; Linux i686; rv:104.0) Gecko/20100101 Firefox/104.0"
            return "Mozilla Firefox";
          }else if (userAgent.includes("SamsungBrowser")){
            // "Mozilla/5.0 (Linux; Android 9; SAMSUNG SM-G955F Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/9.4 Chrome/67.0.3396.87 Mobile Safari/537.36"
            return "Samsung Internet";
          }else if (userAgent.includes("Opera") || userAgent.includes("OPR")){
            // "Mozilla/5.0 (Macintosh; Intel Mac OS X 12_5_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 OPR/90.0.4480.54"
            return "Opera";
          }else if (userAgent.includes("Edge")){
            // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299"
            return "Microsoft Edge (Legacy)";
          }else if (userAgent.includes("Edg")){
            // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 Edg/104.0.1293.70"
            return "Microsoft Edge (Chromium)";
          }else if (userAgent.includes("Chrome")){
            // "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36"
            return "Google Chrome or Chromium";
          }else if (userAgent.includes("Safari")){
            // "Mozilla/5.0 (iPhone; CPU iPhone OS 15_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6 Mobile/15E148 Safari/604.1"
            return "Apple Safari";
          }else{
            return "unknown";
          }

        }
            
        function changeLanguage(lang) {
          
          const browserName = getBrowserName(navigator.userAgent);
          nav = browserName;
      
          if(nav == "Mozilla Firefox"){

             var iframe1 = document.getElementsByClassName("skiptranslate")[1];
             
             if(lang != "Inglês"){
             
              count = 0;
              elmnt = iframe1.contentWindow.document.getElementsByTagName("span")[2];
              console.log(elmnt);
              elmnt.click();
              
              while(count < 1000){
              
                var iframe = document.getElementsByClassName("skiptranslate")[4];
                var elmnt = iframe.contentWindow.document.getElementsByTagName("span")[count];
                el = elmnt.innerText;
              
                if(el == lang){
                  
                  elmnt.click();
                  elmntt = iframe1.contentWindow.document.getElementsByTagName("button")[0];
                  elmntt.click();
                  count = 1000;
                }
              
                count++;
              }

             }else{
            
               elmntt = iframe1.contentWindow.document.getElementsByTagName("button")[3];
               elmntt.click();
             } 

           }else{

              if(lang == "Português (Brasil)"){
                lang_adapt = "›Português (Brasil)";
              }else if(lang == "Russo"){
                lang_adapt = "›Russo";
              }else{
                lang_adapt = "›Inglês";
              }
             
              if($(".translate-drop img").attr("src") == "images/flags/br.svg" || $(".translate-drop img").attr("src") == "images/flags/ru.svg" && document.getElementsByTagName("iframe").lenght > 2){
                var iframe = document.getElementsByTagName("iframe")[2];
              }else{
                var iframe = document.getElementsByTagName("iframe")[1];
              }

              if(lang != "Inglês"){
              
                $(".goog-te-gadget-simple").click();
                
                count_max = iframe.contentWindow.document.getElementsByTagName("a").length;
                count = 0;
              
                while(count < count_max){
              
                  var elmnt = iframe.contentWindow.document.getElementsByTagName("a")[count];
                  el = elmnt.innerText;
                  
                  if(el == lang_adapt){
                    
                    elmnt.click();
                    break;

                  }
                  
                  count++;
                }

              }else{

                $(".goog-te-gadget-simple").click();
                count = 0;
                var iframe = document.getElementsByTagName("iframe")[0];
                
                while(count < 2){
                  
                  elmntt = iframe.contentWindow.document.getElementsByTagName("button")[count];
                  elmntt.click();
                  count++;

                }

              }

           }
           
          if(lang == "Português (Brasil)"){
            f = "br";
          }else if(lang == "Russo"){
            f = "ru";
          }else if(lang == "Inglês"){
            f = "gb";
          }
         
          $(".translate-drop img").attr("src","images/flags/"+f+".svg");
          $(".dropdown-menu-flags").toggle();

          setTimeout(function(){
            
            myReferenceDiv = document.getElementById('goog-gt-tt');
            next = myReferenceDiv.nextElementSibling;
            next.style.display = "none";
            myReferenceDivh = $(".main-container h3").text();
            
            if(myReferenceDivh != "Resume accountFX Loterry"){  
              svg_len = document.getElementsByTagName("svg").length;
              
              for (var i = 0; i < svg_len; i++) {
                svg = document.getElementsByTagName("svg")[i].getAttribute("class");
                class_svg = "";
               
                if(document.getElementsByTagName("svg")[i].getAttribute("class") != "" && document.getElementsByTagName("svg")[i].getAttribute("class") != null && svg.charAt(0) != "f" && svg.charAt(1) != "e" && svg.charAt(2) != "a" && svg.charAt(3) != "t" && svg.charAt(4) != "h" && svg.charAt(5) != "e" && svg.charAt(6) != "r"){
                  svgc=svg;

                  $("svg:eq("+i+")").remove();
                  document.getElementsByTagName("header")[0].style.zIndex='10000';

                }
              
              }

            }

        }, 3000);
        
       }
      </script> 
      <div id="google_translate_element"></div>
      <script type="text/javascript">
        function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: true},'google_translate_element');
        }

        var googleTranslateScript = document.createElement('script');
        googleTranslateScript.type = 'text/javascript';
        googleTranslateScript.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
        document.getElementsByTagName('body')[0].appendChild( googleTranslateScript );
      </script>
  	  <main class="col padding-0" style="width: 100%; top:150px !important;">
  	  	<div class="row bg-light">
  	  		<h3 class="cover-heading color-theme" style="margin:0px auto;">Referral program</h3>
  	  	</div>
  	  	<div class="col-12 mt-pg" style="overflow-y:auto;">
  	  		<div class="referral-program container bg-light">
            <!--<div style="padding: 0px;" class="col float-left">
              <a class="nav-link translate-drop dropdown" href="#translate" id="lang-translate" style="float: left;padding: 0px;"
                <img src="images/flags/gb.svg" width="25px" height="25px" alt="translate en"></a>
            </div>-->
	          <div class="col-md-6 float-left col-sitemap">
              <div class="col net-ico">
                <i class="fa fa-sitemap fa-5x" aria-hidden="true"></i>
	            </div>
              <div class="col">
                  <h4 class="text-muted mt-5">Especial method</h4>
              </div>
            </div>
	          <div class="col-md-6 float-right bg-theme col-porcent" style="min-height: 250px;">
	            <div class="col-md-12" style="font-size: 20px; padding: 10px;">
	              <p class="text-light">3 Network levels</p>
	              <a href="#" class="text-muted">1° level 3 %</a><br>
	              <a href="#" class="text-muted">2° level 2 %</a><br>
	              <a href="#" class="text-muted">3° level 1 %</a>
	              <br><br>
	              <p class="text-light small">I earn for each package purchased, which can be one or more per account.</p>
	           </div>
	         </div>
	         <div class="row">
              <div class="col-12 mt-5">
                <p>1 - User participates in the daily lottery session.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mt-2">
                <p>2 - It can be awarded among one of the winners of the daily session.</p>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mt-2">
                <p>3 - Leader receives part of the amount received by the referral.</p>
              </div>
            </div>
          </div>
          <div class="col-md" style="width: 100%;">
            <p class="color-theme mt-5">The referral bonus is added to the account as soon as the referral is awarded (drawn) in one of the daily sessions.</p>
          </div>
        </div>
        <!-- start footer here -->
        <?php include "theme-parts/footer.php"; ?>
        <!-- end footer here -->        
  	  </main>
    </div>
    <script src="js/calc.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/translate.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
