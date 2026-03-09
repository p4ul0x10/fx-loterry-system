<?php include "url_requests.php"; ?>
<?php if($url_page == "/" || $url_page == "/index.php"){ $ml = "ml-index"; }else{ $ml = ""; } ?>
<header class="masthead mb-auto bg bg-theme" style="z-index: 1; top: 0px;">
  <div class="inner navheader">      
    <nav class="navbar navbar-expand-lg navbar-dark bg-theme">
      <a href="index.php"><img src="images/logofx2.png" alt="fx loterry" class="float-left logo" style="margin-top: 10px;" width="150px" height="45px"></a>
      <div class="mobile-col">
        <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse <?php echo $ml; ?>" id="navbarSupportedContent">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <?php if($url_page == "/" || $url_page == "/index.php"){ //menu -> index page ?>
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link text-light mt-nav-home" href="#packages">Plan's</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light mt-nav-home" href="#howwork">How work / About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light mt-nav-home" href="#network-referrals">Referral program</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light mt-nav-home" href="#events">Loterry</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-light mt-nav-home" href="#lt-more-info">+ info</a>
            </li>
          </ul class="navbar-nav mr-auto">
          <?php }else if($url_page != "/" && $url_page != "/index.php" && $url_page != "/backoffice.php" && $url_page != "/perfil.php"){ //menu -> page != index && backoffice ?>
          <div class="navbar-nav mr-auto"></div>
          <?php }else if($url_page == "/backoffice.php" || $url_page == "/perfil.php"){ //menu -> backoffice page ?>
          <ul class="hnav navbar-nav mr-auto"> 
            <li class="nav-item active">
              <a class="nav-link text-light" href="perfil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Profile <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-depinv text-light" href="#investimentos"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M12.002 9.007c-1.105 0-2 .672-2 1.5c0 .829.895 1.5 2 1.5s2 .672 2 1.5c0 .829-.896 1.5-2 1.5m0-6c.87 0 1.612.417 1.886 1m-1.886-1v-1m0 7c-.87 0-1.612-.417-1.886-1m1.886 1v1"></path><path d="M13 2.507h-1c-4.478 0-6.718 0-8.109 1.391S2.5 7.528 2.5 12.008c0 4.477 0 6.717 1.391 8.108s3.63 1.391 8.109 1.391c4.478 0 6.718 0 8.109-1.391s1.391-3.63 1.391-8.109v-1"></path><path d="M21.488 2.493L17.313 6.67m-.825-3.656l.119 3.091c0 .729.435 1.183 1.227 1.24l3.124.147"></path></g></svg>
              Deposits</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-ret text-light" href="#retirada"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M12.002 9.001c-1.105 0-2 .672-2 1.5s.895 1.5 2 1.5s2 .672 2 1.5s-.896 1.5-2 1.5m0-6c.87 0 1.612.417 1.886 1m-1.886-1v-1m0 7c-.87 0-1.612-.417-1.886-1m1.886 1v1"></path><path d="M13.5 2.501H12c-4.478 0-6.718 0-8.109 1.391S2.5 7.522 2.5 12.001c0 4.478 0 6.717 1.391 8.109C5.282 21.5 7.521 21.5 12 21.5c4.478 0 6.718 0 8.109-1.391S21.5 16.48 21.5 12v-1.5m-5-3.001l4.176-4.178m.824 3.656l-.118-3.091c0-.729-.435-1.183-1.228-1.24l-3.124-.147"></path></g></svg>
              Withdrawals</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-rw text-light" href="#rewards"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="currentColor" d="M10.5 7a3 3 0 1 0 0 6a3 3 0 0 0 0-6M9 10a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0M2 6.25A2.25 2.25 0 0 1 4.25 4h12.5A2.25 2.25 0 0 1 19 6.25V11h-1.5V8.5h-.75a2.25 2.25 0 0 1-2.25-2.25V5.5h-8v.75A2.25 2.25 0 0 1 4.25 8.5H3.5v3h.75a2.25 2.25 0 0 1 2.25 2.25v.75H14V16H4.25A2.25 2.25 0 0 1 2 13.75zm2.25-.75a.75.75 0 0 0-.75.75V7h.75A.75.75 0 0 0 5 6.25V5.5zM17.5 7v-.75a.75.75 0 0 0-.75-.75H16v.75c0 .414.336.75.75.75zm-14 6.75c0 .414.336.75.75.75H5v-.75a.75.75 0 0 0-.75-.75H3.5zm.901 3.75H14V19H7a3 3 0 0 1-2.599-1.5M22 11V9a3 3 0 0 0-1.5-2.599V11zm-5.5 1a1.5 1.5 0 0 0-1.5 1.5v8a1.5 1.5 0 0 0 1.5 1.5h5a1.5 1.5 0 0 0 1.5-1.5v-8a1.5 1.5 0 0 0-1.5-1.5zm.5 4.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1 0-1m3 0h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1 0-1m-3 2h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1 0-1m3 0h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1 0-1m-3 2h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1 0-1m3 0h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1 0-1M16.5 14a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5z"></path></svg>
              Rewards</a>
            </li>
            <li class="nav-item">
              <a class="nav-link link-refinfo text-light" href="#network"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87m-4-12a4 4 0 0 1 0 7.75"></path></g></svg>
              Referrals</a>
            </li>
          </ul>          
          <form class="form-eng form-inline my-2 my-lg-0">
           <a href="#user" id="profile-desktop"><img id="profileimg" src="php/getImagem.php?user=1&amp;ref_name=null" width="42px" height="42px" style="border-radius: 50% 50% 50% 50%;"></a>
           <a class="translate-drop nav-link nav-item dropdown ml-1" href="#translate" id="lang-translate"><img src="images/flags/gb.svg" width="25px" height="25px" alt="translate en"></a>
           <a class="hr nav-link link-bell nav-item dropdown text-light" href="#nav-resources" onclick="toggledd();"> <img src="open-iconic-master/png/cog-2xw.png">
           </a>
           <div class="dropdown-menu float-right dd bg-dark" aria-labelledby="navbarDropdown">
              <span class="dropdown-item lights text-light lg-mode" id="#dark"><svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 512 512"><path fill="currentColor" d="M256 32A224 224 0 0 0 97.61 414.39A224 224 0 1 0 414.39 97.61A222.53 222.53 0 0 0 256 32M64 256c0-105.87 86.13-192 192-192v384c-105.87 0-192-86.13-192-192"></path></svg> Dark / Light</span>
              <a href="#not" class="count-not display-none">+217</a>
              <span class="dropdown-item link-not text-light"> <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9m-4.27 13a2 2 0 0 1-3.46 0"></path></svg> Notifications</span>
              <span class="nav-link text-muted">See in: </span>
              <div class="dropdown-divider text-muted"></div>
              <span id="current_coin" style="display: none">usdt</span>                  
              <nav class="nav nav-select-coin">
                <ul class="container-fluid">
                  <li class="nav-item choose-coin">
                    <a class="nav-link text-light" href="#coin selected">default <img class="img-action-sm" src="images/coins/usdt-sm.png" title="usdt" width="22px" height="22px" alt="usdt coin"></a>
                  </li>
                  <li class="nav-item choose-coin">
                    <a class="nav-link text-light" href="#btc">bitcoin <img class="img-action-sm" src="images/coins/btc-sm.png" title="bitcoin" width="22px" height="22px" alt="btc coin"></a>
                  </li>
                  <li class="nav-item choose-coin">
                    <a class="nav-link text-light" href="#eth">ethereum <img class="img-action-sm" src="images/coins/eth-sm.png" title="eth" width="22px" height="22px" alt="eth coin"></a>
                  </li>
                   <li class="nav-item choose-coin">
                    <a class="nav-link text-light" href="#ltc">litecoin <img class="img-action-sm" src="images/coins/ltc-sm.png" title="eth" width="22px" height="22px" alt="ltc coin"></a>
                  </li>
                  <li class="nav-item choose-coin">
                    <a class="nav-link text-light" href="#tron">tron <img class="img-action-sm" src="images/coins/trx-sm.png" title="trx" width="22px" height="22px" alt="busd coin"></a>
                  </li>
                   <li class="nav-item choose-coin">
                    <a class="nav-link text-light" href="#pix">pix <img class="img-action-sm" src="images/coins/pix.png" title="trx" width="22px" height="22px" alt="busd coin"></a>
                  </li>
                </ul>
              </nav>
            </div>  
            <div class="dropdown-menu dropdown-menu-flags float-right dd bg-dark" aria-labelledby="navbarDropdown">
              <span class="nav-link text-muted">Translate in: </span>
              <div class="dropdown-divider"></div>  
              <nav class="nav nav-select-flag">
                <ul class="container-fluid">
                  <li class="nav-item choose-lang">
                    <a class="nav-link" href="#default" onclick="changeLanguage('Português (Brasil)');"><img class="" src="images/flags/br.svg" title="Brazil" width="30px" height="30px" alt="br flags"></a>
                  </li>
                  <li class="nav-item choose-lang">
                    <a class="nav-link " href="#ru" onclick="changeLanguage('Russo');"><img src="images/flags/ru.svg" title="Russia" width="30px" height="30px" alt="ru flag"></a>
                  </li>
                   <li class="nav-item choose-lang" onclick="changeLanguage('Inglês');">
                    <a class="nav-link " href="#en"><img src="images/flags/gb.svg" title="Inglês" width="30px" height="30px" alt="inglês flag"></a>
                  </li>
                </ul>
              </nav>
            </div>
            <script type="text/javascript">
            function getBrowserName(userAgent) {

              // The order matters here, and this may report false positives for unlisted browsers.

              if(userAgent.includes("Firefox")) {
                // "Mozilla/5.0 (X11; Linux i686; rv:104.0) Gecko/20100101 Firefox/104.0"
                return "Mozilla Firefox";
              }else if(userAgent.includes("SamsungBrowser")) {
                // "Mozilla/5.0 (Linux; Android 9; SAMSUNG SM-G955F Build/PPR1.180610.011) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/9.4 Chrome/67.0.3396.87 Mobile Safari/537.36"
                return "Samsung Internet";
              }else if(userAgent.includes("Opera") || userAgent.includes("OPR")) {
                // "Mozilla/5.0 (Macintosh; Intel Mac OS X 12_5_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 OPR/90.0.4480.54"
                return "Opera";
              }else if(userAgent.includes("Edge")) {
                // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299"
                return "Microsoft Edge (Legacy)";
              }else if(userAgent.includes("Edg")) {
                // "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36 Edg/104.0.1293.70"
                return "Microsoft Edge (Chromium)";
              }else if(userAgent.includes("Chrome")) {
                // "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36"
                return "Google Chrome or Chromium";
              }else if(userAgent.includes("Safari")) {
                // "Mozilla/5.0 (iPhone; CPU iPhone OS 15_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.6 Mobile/15E148 Safari/604.1"
                return "Apple Safari";
              }else{
                return "unknown";
              }

            }

            function changeLanguage(lang){
              
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
            <div id="google_translate_element"><div class="skiptranslate goog-te-gadget" dir="ltr" style=""><div id=":0.targetLanguage" style="white-space: nowrap;" class="goog-te-gadget-simple"><img src="https://www.google.com/images/cleardot.gif" class="goog-te-gadget-icon" alt="" style="background-image: url(&quot;https://translate.googleapis.com/translate_static/img/te_ctrl3.gif&quot;); background-position: -65px 0px;"><span style="vertical-align: middle;"><a aria-haspopup="true" class="VIpgJd-ZVi9od-xl07Ob-lTBxed" href="#"><span>Selecionar idioma</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span style="border-left: 1px solid rgb(187, 187, 187);">​</span><img src="https://www.google.com/images/cleardot.gif" alt="" width="1" height="1"><span style="color: rgb(118, 118, 118);" aria-hidden="true">▼</span></a></span></div></div></div>
            <script type="text/javascript">
              function googleTranslateElementInit() {
              new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: true},'google_translate_element');
              }

              var googleTranslateScript = document.createElement('script');
              googleTranslateScript.type = 'text/javascript';
              googleTranslateScript.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
              document.getElementsByTagName('body')[0].appendChild( googleTranslateScript );
            </script>  
            <a class="hr-btn btn my-2 my-sm-0 btn-outline-light" href="logout.php?logout=on" name="Logout"><i class="fa fa-sign-out"></i> Sign Out</a>
          </form> 
          <?php } ?>
          <?php if($url_page != "/perfil.php" && $url_page != "/backoffice.php"){ ?>
          <form class="form-log-out form-inline my-2 my-lg-0 form-idx-action">
            <?php if(!isset($_SESSION['email'])){ ?>
            <a href="#" class="nav-link navd login text-light my-2 my-sm-0 btn lg m-auto">Sign-in</a>
            <a href="registro.php" style="" class="nav-link navd my-2 my-sm-0 btn btn-success color-theme m-auto">Sign-up</a>
            <div class="navbar-nav mr-auto m-auto">
              <ul class="mt-3">  
                <li class="nav-item">
                  <a class="nav-link translate-drop dropdown" href="#translate" id="lang-translate" style="position: relative; clear: both; margin-top: 3px;"><img src="images/flags/gb.svg" width="25px" height="25px" alt="translate en"></a>
                </li>
              </ul> 
            </div>
            <?php }else{ ?>
              <div class="navbar-nav mr-auto m-auto" style="height: 38px;">
                <ul class="my-0">  
                  <li class="nav-item">
                    <a class="nav-link translate-drop dropdown" href="#translate" id="lang-translate"><img src="images/flags/gb.svg" width="25px" height="25px" alt="translate en"></a>
                  </li>
                </ul> 
              </div>
              <a href="backoffice.php" class="btn btn-outline-light back-enter m-auto" href="#">Backoffice</a>
            <?php } ?>
          </form> 
          <?php } ?>
        </div>
      </div>
    </nav>
    <div class="dropdown-menu dropdown-menu-flags float-right dd bg-light" aria-labelledby="navbarDropdown" style="overflow-y:auto !important;">
      <span class="nav-link">Translate in: </span>
      <div class="dropdown-divider"></div>  
      <nav class="nav nav-select-flag">
        <ul class="container-fluid">
          <li class="nav-item choose-lang">
            <a class="nav-link" href="#default" onclick="changeLanguage('Português (Brasil)');"><img class=''src='images/flags/br.svg' title='Brazil' width='30px' height='30px' alt='br flags'></a>
          </li>
          <li class="nav-item choose-lang">
            <a class="nav-link "href="#ru" onclick="changeLanguage('Russo');"><img src='images/flags/ru.svg' title='Russia' width='30px' height='30px' alt='ru flag'></a>
          </li>
          <li class="nav-item choose-lang" onclick="changeLanguage('Inglês');">
            <a class="nav-link "href="#en"><img src='images/flags/gb.svg' title='Inglês' width='30px' height='30px' alt='inglês flag'></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>
<?php if($ml == "" && $url_page != "/backoffice.php"){ ?>
<div class="home-return col-1">
  <a href="<?php echo $url_return; ?>" title="home page return">
    <i aria-hidden="true" class="fa fa-2x fa-long-arrow-left color-theme"></i>
  </a>
</div>  
<?php } ?>