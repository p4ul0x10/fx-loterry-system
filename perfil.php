<?php session_start();
ini_set( 'display_errors', 0);

include "php/conn.php";
include "php/functions.php";
include "php/theme-mod/mode_class.php";

$mode_theme_lights = theme_mode_color();
$mode_theme_links = nav_link(); 
$mode_theme_bg = bg_theme(); 

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
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Fx-Loterry">
    <meta name="author" content="p4ul0x10">
    <link rel="icon" type="image/ico" href="images/coins/fxicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>FX Loterry - Profile</title>
     <!-- Bootstrap & custom core CSS -->
    <link link href="css/bootstrap.min.css?v=<?php echo filemtime('css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="css/style-all.css?v=<?php echo filemtime('css/style.css'); ?>" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- end -->
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
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
  <body class="text-center <?php bg_color(); ?>" onload="main_change();" onresize="main_change();" style="overflow-y: hidden;">
    <div class="fix" style="float: left; top:80px; padding:0px; width: 100%; position: absolute; z-index: 10000;background: rgba(17,18,36, 1);"><img id="loading" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" width="100px" height="100px" style="margin-top: 8%;"></div>
    <div class="fluid-container">
      <?php include "theme-parts/header.php"; ?>

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
    <script type="text/javascript" src="js/translate.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript" src="js/calc.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
