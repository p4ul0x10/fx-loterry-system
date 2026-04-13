<?php
$host =$_SERVER['REQUEST_METHOD'];
if($host == "POST"){
  exit();
}

session_start();
include "php/conn.php";
ini_set( 'display_errors', 1);

include "php/functions.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Fx-Loterry">
    <meta name="author" content="p4ul0x10">
    <link rel="icon" type="image/ico" href="images/coins/fxicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>FX Loterry</title>
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
    .plan-display { display: inline-block; }
    .navbar-toggler-icon { color:#fff !important; }
    .last-win-block-img small { float: left; margin: 0px 78px; margin-left: 110px; top: 0px; margin-top: -42px; display: block ruby; }
    .read-more-idx { margin-top: 0px; }
    .dsp-flex-root { display: flow-root; }
    .dv-clear { clear: both; }
    .btn-p:hover { color: #111224 !important; background: #fff !important; }
    .login:hover { border-radius: 0.25em !important; border: 1px solid #fff !important; }
    .lg { margin-right: 7px; }
    #events { margin: 100px 0px 50px 0px !important; }
    .net-ico { margin-top: 42px; }

    @media only screen and  (max-device-width : 650px){
    .nav-idx a, .nav-idx-fixed a{ font-size: 5.5vw !important; margin-left: 0px; margin: 0px auto !important; top: 0px !important; } 
    .lfloat-left { float: none; }
    .nav-fixed-box { display: none; top:-29px; }
    .form-inline a, .back-enter{ margin: 0px auto !important; }
    .last-win-block-img small { float: left; margin: 19px 78px; margin-left: 11px; top: 0px; margin-top: 8px;display: block ruby; }
    .lt-user-name { left: 0px !important; }
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

          h = $(".col-fa-text").height();
          div2 = h / 2;
          porcent_h = parseFloat(div2) - parseFloat(40);
          w = $(".col-fa-text").width();
          div2 = w / 2;
          porcent_w = parseFloat(div2) - parseFloat(40);
        
          $(".col-fa-align .fa-globe").css({"margin-top": "80px"});
          $(".col-fa-align .fa-globe").css({"margin-left": porcent_w+"px"}); 
          $(".col-fa-align .fa-cogs").css({"margin-top": "80px"});
          $(".col-fa-align .fa-cogs").css({"margin-right": porcent_w+"px"});
          
          //start ajust fa's in center device
          for (var i = 2; i >= 0; i--) {
            
            h = $(".col-fa-text:eq("+i+")").height();
            div2 = h / 2;
            porcent_h = parseFloat(div2) - parseFloat(40);
          
            w = $(".col-fa-text:eq("+i+")").width();
            div2 = w / 2;
            porcent_w = parseFloat(div2) - parseFloat(40);
          
            if(i == 0){
              
              $(".col-fa-align .fa-globe").css({"margin-top": porcent_h+"px"});
              $(".col-fa-align .fa-globe").css({"margin-left": porcent_w+"px"}); 
            
            }else{
            
              $(".col-fa-align .fa-cogs").css({"margin-top": porcent_h+"px"});
              $(".col-fa-align .fa-cogs").css({"margin-right": porcent_w+"px"});
            
            }
          
          }
          //end

        }else{
        
          $(".navbar-hm").addClass("float-left");
          $(".navbar-hm").removeClass("float-c");
          $(".htl").removeClass("clearb");
          $(".htl").css({"margin": "0px auto","clear":"inline-end","top":"25px"});

          //start ajust fa's in center device
          for (var i = 2; i >= 0; i--) {
            
            h = $(".col-fa-text:eq("+i+")").height();
            div2 = h / 2;
            porcent_h = parseFloat(div2) - parseFloat(40);
          
            w = $(".col-fa-text:eq("+i+")").width();
            div2 = w / 2;
            porcent_w = parseFloat(div2) - parseFloat(40);
          
            if(i == 0){
              
              $(".col-fa-align .fa-globe").css({"margin-top": porcent_h+"px"});
              $(".col-fa-align .fa-globe").css({"margin-left": porcent_w+"px"}); 
            
            }else{
            
              $(".col-fa-align .fa-cogs").css({"margin-top": porcent_h+"px"});
              $(".col-fa-align .fa-cogs").css({"margin-right": porcent_w+"px"});
            
            }
          
          }
          //end

        }   
        
      }, 1);
    </script>
  </head>
  <body class="text-center bg-light" onload="main_change();" onresize="main_change();" style="overflow-y: hidden;">
    <div class="fix" style="width: 100%; position: absolute; z-index: 10000;margin-top: 6%; background: rgba(17,18,36, 1);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
    <div class="fluid-container w-100 h-100 flex-column">
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
      <div class="modal modal-login text-primary" tabindex="-1" role="dialog" style="top: 40px;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-theme">
              <h5 class="modal-title text-light" align="center">Access you account</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" name="formlogin" class="formlogin">
                <div class="form-group">
                  <label for="formGroupExampleInput2" class="color-theme">E-mail</label>
                  <input type="email" class="form-control text-muted emaillogin" name="emailogin" id="emaillogin" placeholder="E-mail válido">
                </div>
                <div class="form-group">
                  <label for="formGroupExampleInput2" class="color-theme">Password</label>
                  <input type="password" class="form-control text-muted senhalog" name="senhalogin" id="senhalog" placeholder="Password account">
                </div>
                 <div class="return-login"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn bg-theme text-light fazer-login">Login</button>
              <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
            </div>
          </div>
        </div>
      </div>
      <main role="main" class="fluid-container main main_off padding-0" style="margin-bottom: 4%;">
        <div class="col-10" style="margin: 0px auto;">
          <h1 class="cover-heading color-theme" style="font-size: 45px;"><?php echo titulo(); ?></h1>
          <p id="packages" class="lead text-center desc text-dark"><?php echo descricao(); ?></p>
        </div>
        <div class="container row box-plans" style="overflow-y: auto; margin: 40px auto;">
          <h1 class="text-center" style="position: relative; margin: 0px auto !important;">Plans / Package's</h1>
          <marquee class="text-dark mt-5" style="font-size: 19px;">Online lottery with incredible winnings and stable reward plans.</marquee>

          <div id="plans" class="col-md-4 bg-theme text-light space-mb sp-mg-plan">
            <h2 class="text-light">Starter</h2>
            <h3>$ 0.5 / 12 hours</h3>
            <p class="text-sm-start" style="font-size: 12px;">
              receive 100 tickets = $ 0.20 each
            </p>
            <p class="text-sm-start col-10" style="font-size: 11px; margin: 16px auto;">
             Entry plan with basic maximum limit, essential to get good rewards on daily lotteries.
            </p>
            <a href="#min-started" class="text-muted">Min:</a><span> $ 0.20</span> <a href="#max-started" class="text-muted">Max:</a><span> $ 100</span>
            <p class="txtp" style="font-size: 14px;">earnings per referral <i class="fa fa-check-square" aria-hidden="true"></i></p>        
            <p class="txtp" style="font-size: 14px;">week promotion <i class="fa fa-window-close" aria-hidden="true"></i></p>   
            <p class="txtp" style="font-size: 14px;">low rakeback <i class="fa fa-check-square" aria-hidden="true"></i></p> 
            <a href="#fx-loterry-idxa" type="button" class="btn btn-sm btn-outline-light float-right btn-p bg-theme mb-2" id="starter">+ info</a>
          </div>
          <div class="col-md-4 bg-theme text-light space-mb sp-mg-plan" id="plans">
            <h2 class="text-light">Advanced</h2>
            <h3>$ 1 / 12 hours</h3>
            <p class="text-sm-start" style="font-size: 12px;">
              receive 250 tickets = $ 0.20 each
            </p>
            <p class="text-sm-start col-10" style="font-size: 11px; margin: 16px auto;">
            Ideal for moderate investors who want to have good returns and excellent daily rewards.
            </p>
            <a href="#min-advanced" class="text-muted">Min:</a><span> $ 0.20</span> <a href="#max-advanced" class="text-muted">Max:</a><span> $ 250</span>
            <p class="txtp" style="font-size: 14px;">earnings per referral <i class="fa fa-check-square" aria-hidden="true"></i></p>   
            <p class="txtp" style="font-size: 14px;">week promotion <i class="fa fa-check-square" aria-hidden="true"></i></p>
            <p class="txtp" style="font-size: 14px;">medium rakeback <i class="fa fa-check-square" aria-hidden="true"></i></p>    
            <a href="#fx-loterry-idxa" class="btn btn-sm btn-outline-light float-right btn-p bg-theme mb-2" id="advanced">+ info</a>
          </div>
          <div class="col-md-4 bg-theme text-light space-mb sp-mg-plan">
            <h2 class="text-light">Premium</h2>
            <h3>$ 2 / 12 hours</h3>
            <p class="text-sm-start" style="font-size: 12px;">
             receive 500 tickets = $ 0.20 each
            </p>
            <p class="text-sm-start col-10" style="font-size: 11px; margin: 16px auto;">
             Ideal for high-end investors, with a greater number of tickets per lottery, they can generally have a higher winning percentage.
            </p>
            <a href="#min-premium" class="text-muted">Min:</a><span> $ 0.20</span> <a href="#max-premium" class="text-muted">Max:</a><span> $ 500</span>  
            <p class="txtp" style="font-size: 14px;">earnings per referral <i class="fa fa-check-square" aria-hidden="true"></i></p>   
            <p class="txtp" style="font-size: 14px;">week promotion <i class="fa fa-check-square" aria-hidden="true"></i></p>  
            <p class="txtp" style="font-size: 14px;">high rakeback <i class="fa fa-check-square" aria-hidden="true"></i></p>       
            <a href="#fx-loterry-idxa" class="btn btn-sm btn-outline-light float-right btn-p bg-theme mb-2" id="premium">+ info</a>
          </div>
          <marquee class="text-dark" style="font-size: 19px;">Each plan contains a maximum number of tickets that can be used in lottery rounds.</marquee>

          <div class="col-md-5 float-left" style="margin-top: 3%;">
            <div class="float-left col-md-6 mobile-sep"><a href="#login" class="login text-light btn btn-sm bg-primary col-md-12">Sign-in</a></div> 
            <div class="float-right col-md-6 mobile-sep"><a href="registro.php" class="text-light btn btn-sm bg-success col-md-12">Sign-up</a></div> 
          </div>
          <div class="col-md-3 float-right bg-light" style="margin-top: 3%;">
             
          </div>
          <div class="col-md-4 float-right bg-light" style="margin-top: 3%;">
            Enjoy now !
          </div>
        </div>
        <div class="col-md-12" style="height: 110px; margin-top: 5%;">
          <div class="coins-valid">
            <div>
              <p class="text-valided" style="margin: 14px 0px !important;">Accepted: </p>
            </div>
          </div>
          <div class="row" style="margin: 0px auto !important;display: inline-block;">
            <div class="coins-valid float-right"><img src="images/coins/btc-sm.png" height="40px"></div>
            <div class="coins-valid float-right"><img src="images/coins/busd-sm.png" height="40px"></div>
            <div class="coins-valid float-right"><img src="images/coins/eth-sm.png" height="40px"></div>
            <div class="coins-valid float-right"><img src="images/coins/usdt-sm.png" height="40px"></div>
            <div class="coins-valid float-right"><img src="images/coins/trx-sm.png" height="40px"></div>
            <div class="coins-valid float-right"><img src="images/coins/pix.png" height="40px"></div>
          </div>
        </div>
        <div class="space-fix-idx-2"></div>
        <!--<div class="space-fix-idx-2"></div>-->
        <h1 class="color-theme mb-5 mb-0" id="howwork">About us - How work</h1>
        <div class="about-more container dsp-flex-root">
          <div class="col-md-6 float-left col-fa-align" style="min-height: 250px"><i aria-hidden="true" class="fa fa-globe fa-5x float-left" style="position: relative !important; float:left !important;"></i></div>
          <div class="col-md-6 float-right bg-theme col-fa-text" style="min-height: 250px;">
           <h3 class="text-success">A loterry</h3><p class='text-light text-justify' style="padding: 10px;">
           It is a bonus system, focused on creating a stable network of participants that can generate 
         good amounts on your spins. Created based on the idea that every investment is a risk and seeking a pleasant environment that provides a good opportunity for group gains, with 1 being more prizes per round. Fair and clean play without traps everyone has the opportunity to win taking into account the <a href="#plans" class="text-muted">plans</a> and <a href="#" class="text-muted">rules.</a></p>
          </div>
          <div class="fix-clear-box" style="clear: both !important;"></div>
          <div class="col-md-6 float-right col-fa-align" style="min-height: 250px; float: right !important;"><i class="fa fa-cogs fa-5x" aria-hidden="true" style="position: relative !important; float: right !important; z-index: 1000;"></i>
          </div>
          <div class="col-md-6 float-left bg-theme col-fa-text" style="position:relative; min-height: 250px; z-index: 1000;">
            <h3 class="text-success">How work</h3>
           <p class='text-light text-justify' style="padding: 10px;"> Just like a lottery, where participants have a number of points, the more points the more chances of winning, these points are tickets that vary in quantity depending on the participant's lottery plan, this quantity is aimed at balancing the platform, establishing a maximum for all, resulting in the same percentage of gain. Part of the package value is returned in the form of rakeback every week. Find out more about the lottery by following the information below.</p>
          </div>
        </div>
        <div class="container dv-clear mt-5 mb-0">
          <p class="m-0" style="text-indent: justify !important;">
            Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado. Se popularizou na década de 60, quando a Letraset lançou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editoração eletrônica como Aldus PageMaker.
          </p>
        </div>
        <div id="network-referrals"></div>
        <div id="referral-program-idx" class="fluid-container mt-5">
          <div class="row bg-light dv-clear">
            <h1 class="cover-heading color-theme" style="margin:0px auto;">Referral program</h1>
          </div>
          <div class="container mt-5" style="overflow-y:auto;">
            <div class="referral-program container bg-light">
              <div class="col-md-6 float-left col-sitemap">
                <div class="col net-ico">
                  <i class="fa fa-sitemap fa-5x" aria-hidden="true"></i>
                  <h4 id="referral-program-a" class="mt-5">Especial method</h4>
                </div>
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
          </div>
          <div id="net-ref-ext" class="container">
            <div class="col">
              <div class="col-12 mt-5">
                <p>1 - User participates in the daily lottery session.</p>
              </div>
            </div>
            <div class="col">
              <div class="col-12 mt-2">
                <p>2 - It can be awarded among one of the winners of the daily session.</p>
              </div>
            </div>
            <div class="col">
              <div class="col-12 mt-2">
                <p>3 - Leader receives part of the amount received by the referral.</p>
              </div>
            </div>
            <div class="col-md" style="width: 100%;">
              <p class="color-theme mt-5 mb-0">The referral bonus is added to the account as soon as the referral is awarded (drawn) in one of the daily sessions.</p>
            </div>
          </div>
        </div>
        <!--<div class="space-fix-idx-2"></div>
        <div class="space-fix-idx-2"></div>-->
        <div class="container mt-5">
          <div id="fx-loterry-idxa" class="fx-loterry-idx col-md-12 bg-theme" style="padding: 10px; overflow-y: auto;">
            <h4 class="text-light">Daily FX Loterry <small class="text-muted">Exclusive promo</small></h4>
            <hr>
            <!--<h5 class="text-primary">How earn</h5>-->
            <span class="text-light">Every day 2 draws are held every 12 hours, some of the participants in the round are awarded a value in cryptocurrency or pix.</span>
            <h5 class="text-muted">Terms</h5>
            <span class="text-light">Being within the system's rules, respecting the basic principles, misconduct on and off the platform are anti-norms, and it is possible to be penalized leading to account blocking.</span>
            <h5 class="text-muted">Requeriments</h5>
            <small class="text-light">
            1 active account, with verified email.<br>
            1 active plan with at least 1 ticket per round.<br>
            It is also necessary attention to notions about cryptocurrencies. <a href="#" class="text-muted" target="_new" title="find out more"><b> Read more</b></a>
            </small>
            <br><a class="btn btn-sm btn-outline-light" href="registro.php" target="_new" style="clear: both;">Join us</a>
          </div>
        </div>
        <div id="fx-loterry-idxa" style="margin: 0px;clear: both;" class="banner-lt row">
          <div class="container mt-5 mb-5">
            <img width="100%" height="80px" style="margin: 0px auto !important;padding: 0px;position: relative;" src="images/banners/banner-idx-desktop.png" class="">
          </div>
        </div>
        <div class="container" style="overflow-y: auto !important;">
          <?php 
          
          $get_sv_info = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
          $arfx = mysqli_fetch_array($get_sv_info);

          $last_session_lt_session = $arfx['lt_session'];

          $last_lt_winners = mysqli_query($con, "SELECT * FROM loterry_session WHERE id > 0 AND loterry_session > 0 ORDER BY id DESC LIMIT 1");
          $array_last_session_lt = mysqli_fetch_array($last_lt_winners);
          $last_session_lt = $array_last_session_lt['id'];
          
          ?>
          <h1 class="color-theme">Last winners -</h1>
          <small><?php echo $array_last_session_lt['data']; ?></small>
          <div class="daily-winners fluid-container mt-5" style="width: 90%; margin: 0px auto;">
            <?php 
            
            $get_last_lt_win = mysqli_query($con, "SELECT * FROM loterry_winners WHERE session_id = '$last_session_lt_session'");
            $count_last_win_lt = 1;  
            
            while($array_last_win_lt = mysqli_fetch_array($get_last_lt_win)){

              $id_user_win = $array_last_win_lt['id_user'];
              $user_name_w = $array_last_win_lt['nick'];
              $id_win_charnum = $array_last_win_lt['rel_tickets'];

              $str_id_win_charnum = str_split($id_win_charnum);

              $rel_win_charnum = $str_id_win_charnum[0]."".$str_id_win_charnum[1]."".$str_id_win_charnum[2]."".$str_id_win_charnum[3]."".$str_id_win_charnum[4]."".$str_id_win_charnum[5]."".$str_id_win_charnum[6]."".$str_id_win_charnum[7];

              //
              $get_coin_dep_win_rel = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$rel_win_charnum'"); 
              $array_win_rel_dep = mysqli_fetch_array($get_coin_dep_win_rel);

              $coin_win_rel_dep = $array_win_rel_dep['coin'];
              //

              //
              $get_rest_dep_win_rel = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_dep = '$rel_win_charnum'");
              $array_rest_rel_dep = mysqli_fetch_array($get_rest_dep_win_rel);

              $rest_win_rel_dep = $array_rest_rel_dep['total_tickets'] - $array_rest_rel_dep['total_rest_tkt'];
              $total_rest_win_rel_dep = 0.20 * $rest_win_rel_dep; 
              //

              //
              $get_entrys_dep_win_rel = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id_user_win' AND current_session = '$last_session_lt_session'");
              $rows_entrys_rel_dep = mysqli_num_rows($get_entrys_dep_win_rel);

              $entrys_win_rel_dep = $rows_entrys_rel_dep;
              //
            ?>
            <div class="cardb bg-light">
              <div class="card-body"> 
                <div class="last-win-block-img" style="width: 90px;height: 90px;float: left; position: relative; top: 5px; left: 0px;">

                  <img class="rounded-circle float-right" title="<?php echo $user_name_w; ?>" width="90" height="90" src="php/imagesperfil/<?php echo $id_user_win; ?>.jpg" alt="Last winners img" style="float: left;">
                  <div style="margin-left: 10px; margin-top: 92px; width: 4px; height: 4px; background: #28a745 !important;"></div>
                  <!-- -->
                </div>
                <div class="row text-right">
                  <div class="col-12 last-win-m-p-0">
                    <div class="col-md-4 wd0 last-win-block-info">Tickets: <a href="#" class="text-muted">35</a> <i class="fa fa-cubes fa-1x" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-4 wd1 last-win-block-info last-win-l-3">Rewards: <a href="#" class="text-muted">$ 72</a> <i class="fa fa-trophy fa-1x" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-4 wd2 last-win-block-info-l last-win-l-3">Parcial: <a href="#" class="text-muted">40 %</a>
                    </div>
                    <div class="last-win-block-ext-info mt-2">
                      <nav>
                        <ul class="last-win-m-p-0">
                          <li style="margin: 0px;" class="text-muted fs-win-info-t">Pack: <a href="#" class="text-muted">m0DPS3sc</a></li>
                          <li class="text-muted fs-win-info-t">entrys: <a href="#" class="text-muted">4</a></li>
                          <li style="margin: 0px;" class="text-muted fs-win-info-t">spend: <a href="#" class="text-muted">20</a></li>
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
                <div class="col text-right" style="top: 14px; padding: 0px;">
                  <small class="lt-user-name" class="text-muted"><?php echo $count_last_win_lt; ?>° st <?php echo $user_name_w; ?></small>
                  <?php 
                
                    $array_coin_win_rel_dep = array();

                    for($i = 0; $i < 7; $i++){

                      $array_coin_win_rel_dep[$i] = "coin-win-rel-dep-1";
                    
                    }

                    if($coin_win_rel_dep == "usdt"){
                      $array_coin_win_rel_dep[0] = "coin-win-rel-dep-0";
                    }else if($coin_win_rel_dep == "btc"){
                      $array_coin_win_rel_dep[1] = "coin-win-rel-dep-0;";
                    }else if($coin_win_rel_dep == "eth"){
                      $array_coin_win_rel_dep[2] = "coin-win-rel-dep-0";
                    }else if($coin_win_rel_dep == "busd"){
                      $array_coin_win_rel_dep[3] = "coin-win-rel-dep-0";
                    }else if($coin_win_rel_dep == "ltc"){
                      $array_coin_win_rel_dep[4] = "coin-win-rel-dep-0";
                    }else if($coin_win_rel_dep == "tron"){
                      $array_coin_win_rel_dep[5] = "coin-win-rel-dep-0";
                    }else if($coin_win_rel_dep == "pix"){
                      $array_coin_win_rel_dep[6] = "coin-win-rel-dep-0";
                    }

                  ?>
                  <div class="fluid-container" style="display: block ruby;">
                    <img src="images/coins/usdt-sm.png" class="<?php echo $array_coin_win_rel_dep[0]; ?>" title="usdt" width="16" height="16" alt="busd coin">
                    <img src="images/coins/btc-sm.png" class="<?php echo $array_coin_win_rel_dep[1]; ?>" title="Paid in btc" width="16" height="16" alt="coin selected">
                    <img src="images/coins/eth-sm.png" class="<?php echo $array_coin_win_rel_dep[2]; ?>" title="ethereum" width="16" height="16" alt="coin selected"> 
                    <img src="images/coins/busd-sm.png" class="<?php echo $array_coin_win_rel_dep[3]; ?>" title="busd" width="16" height="16" alt="coin selected">
                    <img src="images/coins/ltc-sm.png" class="<?php echo $array_coin_win_rel_dep[4]; ?>" title="ltc" width="16" height="16" alt="coin selected">
                    <img src="images/coins/trx-sm.png" class="<?php echo $array_coin_win_rel_dep[5]; ?>" title="trx" width="16" height="16" alt="coin selected">
                    <img src="images/coins/pix.png" class="<?php echo $array_coin_win_rel_dep[6]; ?>" title="pix" width="16" height="16" alt="coin selected"><br>
                  </div>
                  <small class="text-muted">#lt<?php echo $last_session_lt_session; ?></small>
                  <small class="text-muted"><?php echo base64_decode($array_last_win_lt['data']); ?></small>
                </div>
              </div>
              <hr>
            </div>
            <?php $count_last_win_lt++; } ?>
          </div>
          <div class="daily-winners">
            <nav>
              <ul>
                <li>Total investors: <a href="#" class="text-muted">50</a></li>
                <li>Total tickets: <a href="#" class="text-muted">240</a></li>
                <li>Total winners: <a href="#" class="text-muted">3</a></li>
                <li>Total paid: <a href="#" class="text-muted">$ 120</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <small class="container" style="margin-top: 30px; display: block; ">In total 50% of participants will receive part of 80% of the total value of the daily draw. There is 20% left for the system to carry out the activities. <b>*</b> Note that 50% of participants is a ratio to the number of lottery participants, if the total number of participants is not divisible by 2, whose total division is exact, the system will round up the total prizes to - 1 winner in the round.<br><b>E.g. 55 participants is not divisible by 2, so 54 drawn will win,<br>7 participants is not divisible by 2, so 3 drawn will win.</b></small><br>
          <!-- <img src="images/daily-promo.png" width="600px" height="80px"> -->
          <!--Text daily promo<i class="fa fa-gift fa-2x" aria-hidden="true"></i>-->
        <div class="space-fix-idx-2"></div>
        <div id="lt-more-info" class="container mt-5 mb-5">
          <img width="100%" height="80px" style="margin: 0px auto !important;padding: 0px;position: relative;" src="images/banners/banner-idx-desktop.png" class="">
        </div>
        <div class="container" style="margin-top: 4%;"> 
          <h2>Current Loterry <small><?php echo date('m/d/y'); ?></small> <i class="fa fa-calendar fa-1x" aria-hidden="true"></i></h2>
          <div class="current-loterry-container container col-md-12 bg-theme mt-5">
            <nav class="col-md">
              <ul class="font-sm">
                <li class="text-light">Total participants: <a href="#" class="text-muted">10</a> <i class="fa fa-users fa-1x" aria-hidden="true"></i></li>
                <li class="text-light">Total reward: <a href="#" class="text-muted">100</a> <i class="fa fa-cubes fa-1x" aria-hidden="true"></i></li>
                <li class="text-light">Total winners: <a href="#" class="text-muted">3 </a> <i class="fa fa-trophy fa-1x" aria-hidden="true"></i></li>
              </ul>
              <?php 
              
              error_reporting(E_ALL & ~E_NOTICE);
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
              <h5 class="lt-time ltime-b text-muted">Time end in:<br><br><i class="fa fa-clock-o" aria-hidden="true"></i><span class="span-h">&nbsp<?php echo $convert_time_h; ?></span> hs: <span class="span-m"><?php echo $min; ?></span> min: <span class="span-s"><?php echo $seg; ?></span> seg</h5>
            </nav>
            <br><small class="text-muted">Reset each 12 hs.</small>
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
                      <img src="php/imagesperfil/7.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#" class="text-muted">buy 10 tickets</a>
                    </li>
                    <li style="color: #fff; font-size: 20px;">
                      <img src="php/imagesperfil/57.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#" class="text-muted">buy 10 tickets</a>
                    </li>
                    <li style="color: #fff; font-size: 20px;">
                      <img src="php/imagesperfil/10.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#" class="text-muted">buy 10 tickets</a>
                    </li>
                    <li style="color: #fff; font-size: 20px;">
                      <img src="php/imagesperfil/43.jpg" width="20" height="20" alt="user feedback" class="rounded-circle"> Paulo <a href="#" class="text-muted">buy 10 tickets</a>
                    </li>
                  </ul>
                </nav>
              </marquee>
              <div class="binance-api">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 5120 1024" class="header-logo text-light" width="150px" height="50px" fill="currentColor"><path d="M230.997333 512L116.053333 626.986667 0 512l116.010667-116.010667L230.997333 512zM512 230.997333l197.973333 197.973334 116.053334-115.968L512 0 197.973333 314.026667l116.053334 115.968L512 230.997333z m395.989333 164.992L793.002667 512l116.010666 116.010667L1024.981333 512l-116.992-116.010667zM512 793.002667l-197.973333-198.997334-116.053334 116.010667L512 1024l314.026667-314.026667-116.053334-115.968L512 793.002667z m0-165.973334l116.010667-116.053333L512 396.032 395.989333 512 512 626.986667z m1220.010667 11.946667v-1.962667c0-75.008-40.021333-113.024-105.002667-138.026666 39.978667-21.973333 73.984-58.026667 73.984-121.002667v-1.962667c0-88.021333-70.997333-145.024-185.002667-145.024h-260.992v561.024h267.008c126.976 0.981333 210.005333-51.029333 210.005334-153.002666z m-154.026667-239.957333c0 41.984-34.005333 58.965333-89.002667 58.965333h-113.962666V338.986667h121.984c52.010667 0 80.981333 20.992 80.981333 58.026666v2.005334z m31.018667 224c0 41.984-32.981333 61.013333-87.04 61.013333h-146.944v-123.050667h142.976c63.018667 0 91.008 23.04 91.008 61.013334v1.024z m381.994666 169.984V230.997333h-123.989333v561.024h123.989333v0.981334z m664.021334 0V230.997333h-122.026667v346.026667l-262.997333-346.026667h-114.005334v561.024h122.026667v-356.010666l272 356.992h104.96z m683.946666 0L3098.026667 228.010667h-113.962667l-241.024 564.992h127.018667l50.986666-125.994667h237.013334l50.986666 125.994667h130.005334z m-224.981333-235.008h-148.992l75.008-181.973334 73.984 181.973334z m814.037333 235.008V230.997333h-122.026666v346.026667l-262.997334-346.026667h-114.005333v561.024h122.026667v-356.010666l272 356.992h104.96z m636.970667-91.008l-78.976-78.976c-44.032 39.978667-83.029333 65.962667-148.010667 65.962666-96 0-162.986667-80-162.986666-176v-2.986666c0-96 67.968-174.976 162.986666-174.976 55.978667 0 100.010667 23.978667 144 62.976l78.976-91.008c-51.968-50.986667-114.986667-86.997333-220.970666-86.997334-171.989333 0-292.992 130.986667-292.992 290.005334V512c0 160.981333 122.965333 288.981333 288 288.981333 107.989333 1.024 171.989333-36.992 229.973333-98.986666z m527.018667 91.008v-109.994667h-305.024v-118.016h265.002666v-109.994667h-265.002666V340.992h301.013333V230.997333h-422.997333v561.024h427.008v0.981334z" p-id="2935"></path></svg>
                <p class="text-light">Integrated</p>
              <div>
              <style type="text/css">
                .nav-last-buy-tkt ul li { display:inline !important; margin-left: 10px; font-size: 12px !important; }
                .depo-user:hover { display: inline-block; color: #fff !important; background: rgba(17, 18, 36, 0.9); cursor: pointer; }
              </style>
            </div>
          </div>
          <div class="col-md-12 bg-light" id="info-idx" style="height: 400px; display: none;">
          </div>
          <div class="space-fix-idx"></div>
        </div>
        <div class="space-fix-idx-2"></div>
        <div class="fluid-container col-md-12 dep-user-container" >
          <h2>Feedback's</h2>
          <div style="height: 30px;"></div>
          <div class="" style="height: 350px !important; overflow-y: auto;">
            <div class="depo-user" style="display: inline-block;">
              <img id="img-dep-7" src="php/imagesperfil/7.jpg" height="100" alt="user feedback" class="rounded-circle">
              <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #28a745 !important;"></div>Paulo</small>
            </div>
            <div class="depo-user" style="display: inline-block;">
              <img id="img-dep-43" src="php/imagesperfil/43.jpg" height="100" alt="user feedback" class="rounded-circle">
              <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #28a745 !important;"></div>fx</small>
            </div>
            <div class="depo-user" style="display: inline-block;">
              <img id="img-dep-57" src="php/imagesperfil/57.jpg" height="100" alt="user feedback" class="rounded-circle">
              <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #ccc;"></div>akmedis</small>
            </div>
            <div class="depo-user" style="display: inline-block;">
              <img id="img-dep-45" src="php/imagesperfil/45.jpg" height="100" alt="user feedback" class="rounded-circle">
              <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #ccc;"></div>fxadm</small>
            </div>
            <div class="depo-user" style="display: inline-block;">
              <img id="img-dep-10" src="php/imagesperfil/10.jpg" height="100" alt="user feedback" class="rounded-circle">
              <small><div style="margin-left: 10px; width: 4px; height: 4px; background: #28a745 !important;"></div>bitsler</small>
            </div>
            <div class="col-md-12 color-theme" style="height: 110px;">
              <div class="return-depoiment col-md-10" style="margin: 25px auto !important">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat,Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec diam ut est commodo pretium commodo sed nisi,  quis dignissim mi dui ut erat.</p>
              </div> 
            </div>
          </div>
          <script type="text/javascript">
            //Instantly scroll to the top-left corner
            window.scrollTo(0, 0);

            //Add height for init loading page      
            const viewportHeight = window.innerHeight;
            $(".fix").css({"height": viewportHeight+"px"});

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
                  str_name = name.replace(" ", "");  
                   
                  $.post("php/profile/show_depoiment.php",{"user":str_name}, function(data){
                    $(".return-depoiment").text(data);
                  });

                } 
              
              }
              
            }, 4000);
            //init show dep

            //start select depoiment for show
            $(".depo-user").on("click", function(){
              
              idx = $(this).index();
              id_depoiment = $(this).children().attr("id");
              str_children = id_depoiment.replace("img-dep-", "");

              $(".depo-user:eq(0)").addClass("depo-user-selected");
              $(".depo-user:eq(0)").addClass("align-depo-user-1");
              
              for (var i = qtd_feedback - 1; i >= 0; i--) {
            
                if($(".depo-user:eq("+i+")").attr("class") != "depo-user align-depo-user-0"){
            
                  $(".depo-user:eq("+i+")").removeClass("depo-user-selected");
                  $(".depo-user:eq("+i+")").removeClass("align-depo-user-1");
                  $(".depo-user:eq("+i+")").addClass("align-depo-user-0");
                  next = i+1;
                
                }    

                $(".depo-user:eq("+idx+")").removeClass("align-depo-user-0");
                $(".depo-user:eq("+idx+")").addClass("depo-user-selected");
                $(".depo-user:eq("+idx+")").addClass("align-depo-user-1");
            
              }

              $.post("php/profile/show_depoiment.php",{"user":str_children}, function(data){
                $(".return-depoiment").text(data);
              });
            
            });
            //end select depoiment for show
          </script>
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
