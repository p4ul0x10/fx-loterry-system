<?php session_start();
include "php/conn.php";
include "php/functions.php";

    if (!isset($_SESSION['email'])) {
      echo "<script>setTimeout(function(){
      location.href='index.php';
     }, 1);</script>";
     session_destroy();
     exit();
    }else{
      
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

    <title>Painel Admin</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/cover.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
      .nav-deps-all {float: left; width:100%; height: 40px; color: #fff; }
      .nav-deps-all ul li{ float:left; display:inline !important; margin-left:20px !important; }
     /* .nav_deps_all ul li a{ float: left !important; display: inline !important; }*/
    </style>
  </head>

  <body class="text-center">
    <div class="cover-container d-flex w-100 h-100 flex-column">
       <header class="masthead mb-auto bg bg-theme" style="z-index: 1;">
        <div class="inner navheader">
        
          <nav class="navbar navbar-expand-lg navbar-dark bg-theme">
            <a href="paineladmin.php"><img src="images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="45px"></a>
            <a href="#user" class="profile-mobile float-right" style="display:none; position:absolute !important; float: left !important; margin-left: 61.5%;"><?php echo user_profile(); ?></a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="hnav navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link link_depu text-light" href="#deposits"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 16 16"><g fill="currentColor"><path d="M12.5 16a3.5 3.5 0 1 0 0-7a3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/><path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905"/></g></svg> Deposits <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link link-withu text-light" href="#with"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 16 16"><g fill="currentColor"><path d="M12.5 16a3.5 3.5 0 1 0 0-7a3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/><path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867c-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905"/></g></svg> Withdraws</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link link-users text-light" href="#users"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87m-4-12a4 4 0 0 1 0 7.75"/></g></svg>
                  Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link link-statistics text-light" href="#statistics"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                  Statistics</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link link-networku text-light" href="#network"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87m-4-12a4 4 0 0 1 0 7.75"/></g></svg>
                  Network</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link link-logout text-light" href="logout.php?logout=on"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="currentColor" d="M13 3h-2v10h2zm4.83 2.17l-1.42 1.42A6.92 6.92 0 0 1 19 12c0 3.87-3.13 7-7 7A6.995 6.995 0 0 1 7.58 6.58L6.17 5.17A8.932 8.932 0 0 0 3 12a9 9 0 0 0 18 0c0-2.74-1.23-5.18-3.17-6.83"/></svg>
                  Logout</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </header>
     <div class="modal modal-login text-primary" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" align="center">Acesse sua conta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="post" name="formlogin" class="formlogin">
              <div class="form-group">
                <label for="formGroupExampleInput2">E-mail</label>
                <input type="email" class="form-control text-success emaillogin" name="emailogin" id="emaillogin" placeholder="E-mail válido">
              </div>
              <div class="form-group">
                <label for="formGroupExampleInput2">Digite sua senha</label>
                <input type="password" class="form-control text-success senhalog" name="senhalogin" id="senhalog" placeholder="Senha de acesso">
              </div>
              <div class="return-login"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary fazer-login">Entrar</button>
            <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
          </div>
        </div>
      </div>
    </div>
      <main role="main" class="inner cover mainoffice">
        <div class="row">
        <main role="main" class="container pt-4"><div style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2 color-theme">Resume SYS</h1>
           <div class="row user-block">
             <p class="text-primary">Online on <b><?php echo numdays1(); ?></b> dia(s)</p>
           </div>

          </div>
          <div class="row">
            <div class="col-12 col-lg-6 col-xl-3">
              <div class="widget widget-tile">
                <div id="spark1" class="chart sparkline"><canvas style="display: inline-block; width: 85px; height: 35px; vertical-align: top;" width="85" height="35"></canvas></div>
                <div class="data-info card">
                  <i class="fas fa-users fa-3x"></i>
                  <div class="desc">Members</div>
                  <div class="value"><span class="indicator indicator-equal mdi mdi-chevron-right"></span><span data-toggle="counter" class="number"><?php echo total_contas(); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
              <div class="widget widget-tile">
                <div id="spark2" class="chart sparkline"><canvas style="display: inline-block; width: 81px; height: 35px; vertical-align: top;" width="81" height="35"></canvas></div>
                <div class="data-info card">
                 <i class="fas fa-hand-holding-usd fa-3x"></i>
                  <div class="desc">All deposited</div>
      
                  <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-suffix="%" class="number"><?php echo total_depositado(); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
              <div class="widget widget-tile">
                <div id="spark3" class="chart sparkline"><canvas style="display: inline-block; width: 85px; height: 35px; vertical-align: top;" width="85" height="35"></canvas></div>
                <div class="data-info card">
                  <i class="far fa-handshake fa-3x"></i>
                  <div class="desc">All paid</div>
                  <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-up"></span><span data-toggle="counter" data-end="532" class="number"><?php echo totalBonus(); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-3">
              <div class="widget widget-tile">
                <div id="spark4" class="chart sparkline"><canvas style="display: inline-block; width: 85px; height: 35px; vertical-align: top;" width="85" height="35"></canvas></div>
                <div class="data-info card">
                  <i class="fas fa-child fa-3x"></i>       
                  <div class="desc">Referrals</div>
                  <div class="value"><span class="indicator indicator-negative mdi mdi-chevron-down"></span><span data-toggle="counter" data-end="113" class="number"><p class="text-primary"><?php echo total_sponsors(); ?> <i class="fas fa-link fa-1x"></i></p></span>
                  </div>
                </div>
              </div>
            </div>
          </div><br>
           <div>
              <?php simple_statistics(); ?>
            </div>
          <div class="card bg-theme">
            <h3 class="text-light">Index page edit / text</h3>
          </div>
           <div class="col-md-6 data-info card float-left">
              <span>Texto > Titulo</span>
              <input type="text" name="titulo" class="form-control title-edt" value="<?php echo titulo(); ?>">
              <small class="text-warning title-return">Para editar basta digitar um novo titulo</small>
              <button type="button" class="btn col-md-2 btn-success btn-edit-title">Editar</button>
           </div>
            <div class="col-md-6 data-info card float-right">
              <span>Texto > Descrição</span>
              <input type="text" name="titulo" class="form-control desc-edt" value="<?php echo descricao(); ?>">
              <small class="text-warning desc-return">Para editar basta digitar uma nova descrição</small>
              <button type="button" class="btn col-md-2 btn-success btn-edit-desc">Editar</button>
           </div>
          <canvas class="my-4 chartjs-render-monitor" id="myChart" width="1028" height="auto"></canvas>
        </main>
      </div>
      <div class="modal modal-rate text-primary" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" align="center">Rate / porcentagem diária</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" name="formlogin" class="formlogin">
                <div class="form-group">
                  <label for="formGroupExampleInput1">Porcentagem atual</label>
                  <input type="text" class="form-control text-primary rate_atual" value="<?php echo rate_atual(); ?> %" name="rate_atual" id="rate_atual" disabled>
                </div>
                 <div class="form-group">
                  <label>Nova porcentagem</label>
                  <input type="text" class="form-control text-success rate_new"  name="rate_new" id="rate_new" placeholder="Ex: 0.45">
                </div>
                 <div class="return-rate text-center"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary concluir-rate">Concluir</button>
              <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
            </div>
          </div>
        </div>
      </div>
      </main>
      
     <footer class="col-md-12 footer ff float-left bg-theme">
        <div class="col text-light mg-footer">
          <div class="col-md-4 float-left inim" style="height: 40px">
            <p class="f">Investe FX Robot @ <a href="https://getbootstrap.com/" title="trader center">Trader center</a>,  <a href="https://twitter.com/mdo">2024</a>.</p>
          </div>
          <div class="col-md-4 float-right inim" style="height: 40px;">
             <a href="https://www.infinityfree.com" title="infinityfree" target="_new">Sponsored By:
            <img src="https://vpassets.infinityfree.net/welcome2017/logo.png" alt="InfinityFree" height="40px">
          </a>
          </div>
        </div>
      </footer>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="js/scripts.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
