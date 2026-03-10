<?php
$host =$_SERVER['REQUEST_METHOD'];
  if($host == "POST"){
    exit();
  }

session_start();
include "php/conn.php";
include_once "php/functions.php";
ini_set( 'display_errors', 0);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" type="image/ico" href="images/coins/fxicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
      FX Loterry - FAQ
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
    <style> 
    .skiptranslate { display: none !important; }
    .main .row { margin-top: 20px; margin-bottom: 50px; }
    .faq-title { margin: 0px auto !important; margin-bottom: 10px; }
    .box-faq { overflow-y:auto; width: 100%; }
    .box-faq .marked { width: 5px; height: 5px; top: 12px; position: absolute; z-index: 1; margin-left: 10px; }
    .col-title { height: 30px; margin: 5px 0px; }
    /*.col-text { display: none; margin-bottom: 2px solid #111224; border-bottom: 2px solid #111224; margin-bottom:5px; color-theme }*/
    .col-title:hover { cursor: pointer; }
    .col-title p { top: 3px; position: relative !important; } 
    .open-close-faq i{ cursor: pointer; }
    .login:hover { border-radius: 0.25em !important; border: 1px solid #fff !important; }
    .lg { margin-right: 7px; }
    .dropdown img { vertical-align: bottom !important; }
    body { top: 0px !important; }

    @media only screen and  (max-device-width : 650px){
    .form-inline a, .back-enter{ margin: 0px auto !important; }
    }
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
    <div class="fix" style="width: 100%; height: 3000px; position: absolute; z-index: 10000; margin-top: 6%; background: rgba(17,18,36, 1);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
    <div class="fluid-container">
      <!-- start header here -->
      <?php include "theme-parts/header.php"; ?>
      <!-- end header here -->
      <script type="text/javascript">
        function getBrowserName(userAgent) {

          // The order matters here, and this may report false positives for unlisted browsers.

          if (userAgent.includes("Firefox")) {
            // "Mozilla/5.0 (X11; Linux i686; rv:104.0) Gecko/20100101 Firefox/104.0"
            return "Mozilla Firefox";
          } else if (userAgent.includes("SamsungBrowser")) {
            // "Mozilla/5.0 (Linux; Android 9; SAMSUNG SM-G955F Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/9.4 Chrome/67.0.3396.87 Mobile Safari/537.36"
            return "Samsung Internet";
          } else if (userAgent.includes("Opera") || userAgent.includes("OPR")) {
            // "Mozilla/5.0 (Macintosh; Intel Mac OS X 12_5_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 OPR/90.0.4480.54"
            return "Opera";
          } else if (userAgent.includes("Edge")) {
            // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299"
            return "Microsoft Edge (Legacy)";
          } else if (userAgent.includes("Edg")) {
            // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 Edg/104.0.1293.70"
            return "Microsoft Edge (Chromium)";
          } else if (userAgent.includes("Chrome")) {
            // "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36"
            return "Google Chrome or Chromium";
          } else if (userAgent.includes("Safari")) {
            // "Mozilla/5.0 (iPhone; CPU iPhone OS 15_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6 Mobile/15E148 Safari/604.1"
            return "Apple Safari";
          } else {
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
      <div class="modal modal-login text-primary" tabindex="-1" role="dialog" style="top:40px;">
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
  	  <main class="col padding-0" style="width: 100%; top:150px !important;">
  	  	<div class="row bg-light">
          <h3 class="cover-heading color-theme faq-title">FAQ</h3>
  	  	</div>
  	  	<div class="box-faq">
          <div class="container mt-pg">
          <div class="col-12" style="padding: 0px;">
            <div class="col-12 color-theme col-title">
              <h5 class="text-align float-left" style="margin: 0px;">Texte here</h5>
            </div>
          </div>
  	  		<div class="col">
	  	  		<div class="bg-light marked">
	  	  		</div>
	  	  		<div class="col-12 bg-theme text-light col-title">
	  	  			<p class="text-align">Lorem ipsum text</p>
	  	  		</div>
	  	  		<div id="hide0" class="col bg-light col-text text-muted">
	  	  			Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.	
	  	  		</div>
  	  		</div>
  	  	  <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide1" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide2" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
        </div>
        <div class="container mt-5">
          <div class="col-12" style="padding: 0px;">
            <div class="col-12 color-theme col-title">
              <h5 class="text-align float-left" style="margin: 0px;">Texte here</h5>
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide3" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide4" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide5" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide6" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide7" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide8" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
        </div>
        <div class="container mt-5"> 
          <div class="col-12" style="padding: 0px;">
            <div class="col-12 color-theme col-title">
              <h5 class="text-align float-left" style="margin: 0px;">Texte here</h5>
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide9" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide10" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
          <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide11" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide12" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide13" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide14" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide15" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide16" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
          </div>
          <div class="col">
            <div class="bg-light marked">
            </div>
            <div class="col-12 bg-theme text-light col-title">
              <p class="text-align">Lorem ipsum text</p>
            </div>
            <div id="hide17" class="col bg-light col-text text-muted">
              Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. 
            </div>
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
