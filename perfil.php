<?php session_start();
ini_set( 'display_errors', 0);

include "php/conn.php";
include "php/functions.php";
include "php/theme-mod/mode_class.php";

if(!isset($_SESSION['email'])) {

  echo "<script>setTimeout(function(){
  location.href='index.php';
 }, 1);</script>";

 session_destroy();
 exit();

}

if(isset($_GET['visible']) && isset($_GET['check'])){

  if($_GET['visible'] == "public" || $_GET['visible'] == "anonymous"){

    if($_GET['check'] == "true"){

      $email = $_SESSION['email'];
      $get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
      $user = mysqli_fetch_array($get_usr);
      $idu = $user['id'];
      $visible = $_GET['visible'];

      if($visible == "public"){
        
        $change = "anonymous";

        $update = mysqli_query($con, "UPDATE user_config SET visible = '$change' WHERE id_user = '$idu'");
      
      }else{

        $change = "public";

        $update = mysqli_query($con, "UPDATE user_config SET visible = '$change' WHERE id_user = '$idu'");
 
      }
 
    }
 
  }

}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Investe FX Robot - Perfil</title>
     <!-- Bootstrap & custom core CSS -->
    <link link href="css/bootstrap.min.css?v=<?php echo filemtime('css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="css/style-all.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- end -->
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
    $(window).on("load", function(){

      // página totalmente carregada (DOM, imagens etc.)
      $(".fix").css("all", "unset");
      $("#loading").remove(); 

      $.getJSON("https://ipinfo.io/<?php echo $_SERVER['REMOTE_ADDR']; ?>", function(data){
        
        country = data['country'];
        $("body").attr("id", country);
 
        ip = $("#ip").text(); 
        $("#ip").text(ip+", "+data['country']);
      
      });
    
      var url = location.href;
  
      if(url.indexOf("visible=public") > 1 && url.indexOf("check=true") < 1){
        turn = "public";
      }else if(url.indexOf("visible=anonymous") > 1 && url.indexOf("") < 1){
        turn = "anonymous";
      }

      modal_yesno_profile = '<div class="modal yesnoprofile text-primary" tabindex="-1" role="dialog" style="display:block;"><div class="modal-dialog" role="document"><div class="modal-content bg-theme" style="margin-top: 15%;"><div class="modal-header"><h5 class="modal-title text-light" align="center">Profile info</h5></div><p class="text-light">Change '+turn+' info profile? </p><center><button id="yesinfochange" onclick="yesinfochange();" style="width:25%;">Yes</button><button id="noinfochange" onclick="noinfochange();" style="width:25%;">No</button></center></div></div></div>';
      
      if(url.indexOf("check=true") < 1){
       
       if(url == '<?php echo 'http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI']; ?>' || url == '<?php echo 'http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI']; ?>'){
      
          $("body").append(modal_yesno_profile);
      
        }
      
      }
    
    });

    function yesinfochange() {
      url = location.href;
      location.href = url+'&check=true';
    }

    function noinfochange() {
      $(".yesnoprofile").remove();
    }
    
    function change_pw(){
      $(".change-pw").toggle();
    }

    function change_email(){
      $(".change-email").toggle();
    }
    </script>
    <style> 
      .skiptranslate { display: none !important; }
      body { top: 0px !important; }
      .close-vals { padding-top:1rem !important; padding-right:1rem !important;  padding-bottom:1rem !important;}
      .close-vals span{ float:right; }
    </style>
  </head>
  <body class="text-center <?php bg_color(); ?>" onload="main_change();" onresize="main_change();">
    <div class="fix" style="float: left; top:80px; padding:0px; width: 100%; height: 1000px; position: absolute; z-index: 10000;background: rgba(17,18,36, 0.95);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
    <div class="fluid-container">
      <?php include "theme-parts/header.php"; ?>
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
           
            //svg.charAt(0) != "f" && svg.charAt(1) != "e" && svg.charAt(2) != "a" && svg.charAt(3) != "t" && svg.charAt(4) != "h" && svg.charAt(5) != "e" && svg.charAt(6) != "r"
            
            if(document.getElementsByTagName("svg")[i].getAttribute("class") != "" && document.getElementsByTagName("svg")[i].getAttribute("class") != null && svg.charAt(0) != "f" && svg.charAt(1) != "e" && svg.charAt(2) != "a" && svg.charAt(3) != "t" && svg.charAt(4) != "h" && svg.charAt(5) != "e" && svg.charAt(6) != "r"){
              svgc=svg;

              $("svg:eq("+i+")").remove();
              document.getElementsByTagName("header")[0].style.zIndex='10000';
              /*for (var i = 0; i < 6; i++) {
                class_svg = class_svg+""+svgc.charAt(i);
              } 
              divs = document.getElementsByTagName("div").length;
             
              for(i= 0; i < divs; i++){
                
                div_class = document.getElementsByTagName("div")[i].getAttribute("class");
                div_pos1 = div_class.charAt(0);
                div_pos2 = div_class.charAt(1);
                div_pos3 = div_class.charAt(2);
                div_pos4 = div_class.charAt(3);
                div_pos5 = div_class.charAt(4);
                div_pos6 = div_class.charAt(5);
                div_pos = div_pos1+""+div_pos2+""+div_pos3+""+div_pos4+""+div_pos5+""+div_pos6;
                alert(div_pos+" "+class_svg);
                if(div_pos == class_svg){
                  $("div:eq("+i+")").remove();
                }

              }*/

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
      <div class="modal change-email" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-theme">
              <h5 class="modal-title text-light">Change email</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" name="formlogin" class="formlogin">
                <div class="form-group">
                  <label class="text-light" for="senhatual">Account email</label>
                  <input type="email" class="form-control color-theme email-atual" name="email-atual" id="email-atual" value="<?php echo $_SESSION['email']; ?>">
                </div>
                <div class="form-group">
                  <label class="text-light" for="novasenha">New email</label>
                  <input type="email" class="form-control color-theme nova-senha1" name="new-email" id="new-email" placeholder="Enter a new email">
                </div>        
                <div class="return-new-email"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn bg-theme text-light removar-email">Change</button>
              <button class="btn btn-muted cancelar-email">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal change-pw" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-theme">
              <h5 class="modal-title text-light">Change password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" name="formlogin" class="formlogin">
                <div class="form-group">
                  <label class="text-light" for="senhatual">Account password</label>
                  <input type="password" class="form-control color-theme senha-atual" name="senha-atual" id="senha-atual" placeholder="Your password">
                </div>
                <div class="form-group">
                  <label class="text-light" for="novasenha">New password</label>
                  <input type="password" class="form-control color-theme nova-senha1" name="nova-senha1" id="nova-senha1" placeholder="Choose new password">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control color-theme nova-senha2" name="nova-senha2" id="nova-senha2" placeholder="Confirm password">
                </div>          
                <div class="return-nova"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button class="btn bg-theme text-light removar-senha">Change</button>
              <button class="btn btn-muted cancelar-senha">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <main class="col padding-0" style="width: 100%; top:150px !important;">
        <div class="resize-main fluid-container">
          <?php echo perfil(); ?>
        </div>
      <?php include "theme-parts/footer.php"; ?>
      </main>
      <?php     
      $email = $_SESSION['email'];
      $get_usr = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
      $array_user = mysqli_fetch_array($get_usr);
      $idu = $array_user['id'];

      $get_deps = mysqli_query($con, "SELECT * FROM deposits WHERE id_user ='$idu'");
      $get_with = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$idu'");
      $get_nots = mysqli_query($con, "SELECT * FROM notifications WHERE email = '$email'");
      $rows_dep = mysqli_num_rows($get_deps);
      $rows_with = mysqli_num_rows($get_with);
      $rows_nots = mysqli_num_rows($get_nots);
      ?>  
      <?php include "php/with/modal-with.php"; ?>
      <?php include "php/dep/modal-dep.php"; ?>
      <?php include "php/ref/modal-ref.php"; ?>
      <?php include "php/not/modal-not.php"; ?>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>
      $(document).ready(function(){
        //start
        $("#acv").click(function(){ location.href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/perfil.php?visible=anonymous"; }); 
        $("#aca").click(function(){ location.href="<?php echo 'http://'.$_SERVER['SERVER_NAME']; ?>/perfil.php?visible=public"; });
        //end
      });
    </script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/calc.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
