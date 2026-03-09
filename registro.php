<?php session_start();
ini_set( 'display_errors', 0);

include "php/conn.php";

if(isset($_GET['sponsor'])){

  $sponsor = $_GET['sponsor'];
  $ip_referral = $_SERVER['REMOTE_ADDR'];
  $data_access = date("m,j,Y g:i a");

  $ip = $_SERVER['REMOTE_ADDR'];
  $apiUrl = "http://ipinfo.io/".$ip;
  
  // Fazendo a solicitação via cURL
  $ch = curl_init($apiUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch);
  
  // Decodificando a resposta JSON
  $data = json_decode($response, true);
  $country = $data['country'];
  
  $check_added_ip = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome='$sponsor' AND ip_referral ='$ip'");
  
  if($row_referral = mysqli_affected_rows($con) < 1){
    
    $check_sponsor = mysqli_query($con, "SELECT * FROM usuarios WHERE f_nome = '$sponsor'");
   
    if($row_sponsor = mysqli_affected_rows($con) >= 1){

      $add_referral_ip = mysqli_query($con, "INSERT INTO direct_access_rl (sponsor_nome,ip_referral,country,data) VALUES ('$sponsor','$ip','$country','$data_access')");
       
    }

  }
 
}
//end check / add new referral ip -> analitcs resources
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/ico" href="images/coins/fxicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    
    <title>FX Robot - Create account</title>
    <!-- Bootstrap & custom core CSS -->
    <link link href="css/bootstrap.min.css?v=<?php echo filemtime('css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="css/style-all.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- end -->
    <script src="js/jquery.min.js"></script>
    <style type="text/css">
      #senhacc0, #senhacc1 { padding-left-left: 2px !important; }
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
      .register-align { margin: 0px auto; }
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

         }, 1000);
        
        h = window.innerHeight;
      
        if(h > 906){

          ajust_footer = parseFloat(h) - parseFloat(906);
          mg_footer = parseFloat(200) + parseFloat(ajust_footer);
        
          //document.getElementsByClassName("footer")[0].style.top = mg_footer+"px";
        
        }

      });
    </script>
  </head>
  <body class="text-center" onload="main_change();" onresize="main_change();">
    <div class="fix" style="width: :100%; width: 100%; height: 3000px; position: absolute; z-index: 10000;margin-top: 6%; background: rgba(17,18,36, 1);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
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
      <div class="modal modal-login text-primary" tabindex="-1" role="dialog"  style="top:40px;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-theme">
              <h5 class="modal-title text-light" align="center">Access your account</h5>
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
                  <label for="formGroupExampleInput2" class="color-theme">Your password</label>
                  <input type="password" class="form-control text-muted senhalog" name="senhalogin" id="senhalog" placeholder="Senha de acesso">
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
        <div class="row">
          <h3 class="cover-heading color-theme register-align ">Release steps below.</h3>
        </div>
        <div class="col-12 mt-pg" style="overflow-y:auto;">
          <form method="post" name="registro" class="registro">
            <div class="form-group">
              <label for="formGroupExampleInput">Nickname</label>
              <input type="text" class="form-control text-muted" name="fname" id="fname" maxlength="16" placeholder="User name">
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput2">Name</label> 
              <input type="text" class="form-control text-muted" name="lname" id="lname" maxlength="16" placeholder="First name">
            </div>
             <div class="form-group">
              <input type="hidden" class="form-control text-muted indicado_por" id="indicado_por" name="incidado_por" value="<?php $get = $_GET['sponsor']; echo $get; ?>">
            </div>
              <div class="form-group" style="display: none;">
              <input type="hidden" class="form-control text-muted typea" id="newacc" name="new account" value="created_acc">
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput2">E-mail</label>
              <input type="email" class="form-control text-muted" id="emailcriaracc" name="emailcriaracc" placeholder="E-mail">
            </div>
            <div class="form-group">
              <label for="formGroupExampleInput2">Password</label><br>
              <div class="p-l">
                <input type="password" name="senhacc" id="senhacc" placeholder="min 4 caracteres" class="form-control text-muted col-md-6 float-left">
              </div>
              <div class="p-r">
                <input type="password" name="senhacc-confirm" id="senhaccc" placeholder="Confirm password" class="form-control text-muted col-md-6 float-right">
              </div>
              <br>
              <a class="small text-muted" href="#terms">Terms: </a><input type="checkbox" name="not checked" class="terms" onclick="terms0();">
            </div>
            <div class="return-cria"></div>
            <div class="container bg-theme text-term" style="display: none; max-height: 180px; overflow-y: auto !important;">
              <p class="color-theme small alert-primary" style="padding: 0px 20px;">
                TERMS OF SERVICE<br>
                These terms are a set of all the information about us, our services, legal and financial circumstances of cooperation through our website. These terms are implemented to all business operations carried out since this day.

                By ordering any of our services, you automatically agree to the terms and conditions described below. Therefore, before entering into a contract we strongly recommend that you read the terms and make sure you understand all items. In the future, all aspects of our cooperation will be based on these terms.

                If you agree with the terms stated below, then please click "I accept" and continue working on our website. If you refuse to accept the terms further cooperation with us is not possible and we will not be able to provide you with our services.

                The following terms may be partially modified in compliance with the mutual interests of the parties. We are open to suggestions and comments from you that do not violate the law and do not infringe the interests of other customers.

                For further reading and use of this document, we suggest that you keep a copy of this page to the hard disk or have it printed.

                In accordance with Section 7 we can change the terms unilaterally without written notice. Before entering into a contract please read the latest version of the terms published on this page.

                <br>1. ABOUT US<br>
                1.1 SafeAssets.com is the online platform of the Urbi et Orbi LTD company, a leading provider and manager of crypto and DeFi investment products.

                1.2 Please use the contact information presented on the main page of the website if you want to contact us.

                <br>2. OUR SERVICES<br>
                2.1 SageAssets.com is an online platform of Urbi et Orbi LTD, that provides a wide range of services in the field of investment in the cryptocurrency market. We use the most effective investment tools and offer several basic asset management strategies that meet the various expectations of the investor.

                <br>2.2<br> We offer brokerage services on the leading trading floors, powerful analytical support and special conditions for professional market participants.

                <br>3. USE OF OUR WEBSITE<br>
                The use of our site is governed by these terms. We strongly recommend that you familiarize yourself with the given conditions, as their content governs our cooperation within the website.

                <br>4. USE OF PERSONAL DATA<br>
                Collection, storage and use of your personal information is carried out strictly in accordance with the "Privacy Policy". We strongly recommend that you familiarize yourself with the present document since its content regulates our cooperation in the website.

                <br>5. CUSTOMER RIGHTS AND OBLIGATIONS<br>
                5.1 Our services are available only for persons over 18 years of age. If there is information that confirms that a customer is under 18 years old at the time of conclusion of the contract, the implementation of our obligations will be suspended.

                5.2 As a consumer, you can enjoy your legal rights with respect to services that do not meet the characteristics described. You can get support and consultation about your rights in a local consumer rights organization. These terms and conditions shall in no way infringe upon your statutory rights.

                <br>6. THE CONCLUSION OF THE CONTRACT<br>
                6.1 To get access to our services you need to pass the registration procedure that will not take you much time.

                6.2 If we cannot provide you with the service — for example, due to the fact that the service is no longer available or because of an error on our website, we will notify you by email and will not process your deposit. If you have already made the deposit, we will promptly refund you the full amount you paid.

                <br>7. OUR RIGHT FOR MODIFICATION OF TERMS<br>
                7.1 We reserve the right to apply changes and modifications in these terms.

                7.2 The changes associated with the internal operation of the website have no effect on existing contracts. They continue to work under the terms of which they were in force at the time of conclusion of the contract.

                7.3 Amendments to our terms associated with changes in the current legislation that regulates our activities may affect the existing contracts.

                7.4 Each time when you use our services the terms which are active at that moment will be applied to your treaty.

                7.5 Each time when we issue amendments and changes in these terms we will notify you about that via website news or in writing. It will depend on the importance of new changes.

                <br>8. PAYMENT OPTIONS<br>
                8.1 You can make a deposit to gain revenue via any payment systems available on the platform.

                8.2. Withdrawal of the initial deposit (principal) prior its maturity date is not allowed.

                <br>9. REVENUE<br>
                9.1 You receive income according to an investment plan you have selected on our platform.

                <br>10. OUR LIABILITY TO CLIENTS<br>
                10.1 We take full financial responsibility for violation of our commitments, including cases of force majeure, negligence, carelessness.

                10.2 Our liability is incurred at our apparent fault. Cases of non-obvious guilt shall be dealt with in accordance with applicable law.

                10.3 If we are unable to fulfill our contractual obligations, we take responsibility for loss or damage obviously inflicted by violation of terms of service.

                <br>11. FORCE MAJEURE<br>
                11.1 The occurrence of force majeure temporarily or permanently frees us from fulfilling our obligations specified in the contract. In the event of force majeure, we will not be liable for any failure or delay in performance of any of our obligations under the contract.

                11.2 Under the definition of force majeure fall events and circumstances that are beyond our reasonable control, such as extensive strikes, mass layoffs or other industrial strikes of third parties, civil commotion, riots, military invasion, terrorist attack or threat of terrorist attack, war (whether declared or not), the threat of war or preparation for war, fire, explosion, storm, flood, earthquake, landslide, epidemic or other natural disasters, failure of public or private telecommunications networks, significant changes in legislation governing our activities.

                11.3 In the event of force majeure, which directly affects the performance of our contractual obligations, we are committed to promptly notify you via email or notification on the site.

                11.4 In case of force majeure circumstances that directly affect the performance of our contractual obligations, our liabilities will be suspended and the timeframe of their implementation will be extended for the duration of the force majeure.

                11.5 If the force majeure circumstances affect the provision of services under the contract for more than 6 months, we may terminate the Services. If service is discontinued, you will be entitled to receive reimbursement of their value.

                <br>12. REIMBURSEMENT UNDER FORCE MAJEURE<br>
                12.1 If the duration of the force majeure circumstances forces us to stop providing services, we will make all the necessary efforts to recover the costs to our customers.

                12.2 In order to recover the costs, we will use the funds that are currently on the account of the company. All the property of the company will be sold. Revenue from this sale will be used to repay existing financial liabilities.

                12.3 In case the available money and funds received after the sale of the company's assets, will not be enough to fulfill all financial obligations, we commit to continue payments in equal shares to all customers, to whom we will have financial obligations under the terms of contract, 6 months after termination of the force majeure.

                <br>13. INFORMATION EXCHANGE<br>
                13.1 If the current terms and conditions refer to the term "in written form", it also includes the exchange of information via email. All communications from us in writing, you will receive an email.

                13.2 For any question you can contact us through the means of communication specified in section "Contacts". Appeals are considered within 24 hours after receipt of the message. In complex cases that require special attention, we reserve the right to respond within 72 hours after receipt of the message.

                <br>14. FINAL PROVISIONS<br>
                14.1 We may transfer our rights and obligations under the contract to a third party only in case we are not able to fulfill our obligations and this does not affect your rights under the contract. If this happens, we will notify you by email.

                14.2 You may transfer your rights and obligations under the contract to a third party only upon our prior written consent. Any attempt of assignment without our written consent will be denied legal effect.

                14.3 Each of the sections of these terms and conditions is applicable individually. If the court or other competent authority decides that any of the sections of the current terms and conditions is unlawful, the other sections remain in force.

                14.4 We do not keep a copy of the contract.
              </p>
            </div>
            <div class="form-group">
              <button class="btn bg-theme btn-lg criar-acc bg-theme text-light">Create</button>              
            </div>
          </form>
        </div>
        <!-- start footer here -->
        <?php include "theme-parts/footer.php"; ?>
        <!-- end footer here -->        
      </main>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/calc.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/translate.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
