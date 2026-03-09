<script type="text/javascript">
 
  function rmnot(id){
    
    var get_count = $(".count-not").text();
    var count = get_count.replace("+", "");
    var new_count = parseFloat(count) - parseFloat(1);

    $(".count-not").text("+"+new_count);

    var get_count = $(".count-not-cog").text();
    var count = get_count.replace("+", "");
    var new_count = parseFloat(count) - parseFloat(1);

    $(".count-not-cog").text("+"+new_count);
    id_not = id;

    $.post('php/not/rmnot.php',{"id": id_not}, function(data){
      
    });

    notdiv_len = $(".modal-not .modal-body div").length;
    for (var i = 0; i < notdiv_len; i++) {

      if($(".modal-not .modal-body div:eq("+i+") div")){

        if($(".modal-not .modal-body div:eq("+i+") div").attr("id") == "card-not"+id_not){

          $(".modal-not .modal-body div:eq("+i+")").remove();
        
        }
      
      }
    
    }
    
  }
 
  function readynot(id){

    var id_not = id;
    var get_count = $(".count-not").text();
    var count = get_count.replace("+", "");

    if(count >= 1){

      $.post('php/not/readynot.php',{"id": id_not}, function(data){

      });

      var get_count = $(".count-not").text();
      var count = get_count.replace("+", "");
      var new_count = parseFloat(count) - parseFloat(1);

      $(".count-not").text("+"+new_count);

      var get_count = $(".count-not-cog").text();
      var count = get_count.replace("+", "");
      var new_count = parseFloat(count) - parseFloat(1);

      $(".count-not-cog").text("+"+new_count);
      
      $(".ready-not").each(function(count = 0){

        var obj_id = "#ready-not"+id_not;
      
        if($(this).attr("href") == obj_id){

          new_id_count = obj_id.replace("#ready-not", "");
          obj = $(this);
          $(".ready-not:eq("+count+") i").remove();
          $(".ready-not:eq("+count+")").append("<i class='fa fa-check-square' aria-hidden='true'></i>");

        }
        count++;

      });
      
    }else{

     $(".count-not").text(""); 
     $(".count-not-count").text(""); 

    }

  }

</script>
<div class="modal text-primary modal-not" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-theme">
        <h5 class="modal-title text-light" align="center">Notifications</h5>
        <i class="fa-with-exclamation fa fa-info" aria-hidden="true"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?php
      
      $sm = $_SESSION['email'];
      $get_id = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");
      if($row_email = mysqli_affected_rows($con) >= 1){

        $array_user = mysqli_fetch_array($get_id);
        $id_user = $array_user['id'];
        
        $get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user ='$id_user'");
        $array_theme = mysqli_fetch_array($get_theme);

        if($array_theme['conf_theme'] == "dark"){
          $bg_card = "bg-dark";
          $text_color = "text-light";
        }else{
          $bg_card = "bg-light";
          $text_color = "text-muted";
        }

      }

      $get_not = mysqli_query($con, "SELECT * FROM notifications WHERE email = '$sm' ORDER BY id DESC LIMIT 25");

      if($row_not = mysqli_affected_rows($con) >= 1){
        
        while ($array_not = mysqli_fetch_array($get_not)) {

          if($array_not['action'] == '0'){
            $btn_type = "text_not-primary";
            $check_ico = "fa fa-check";
          }else{
            $btn_type = "text-primary";
            $check_ico = "fa fa-check-square";
          }
        
          echo  "<div class='card ".$bg_card."' style='width: 100%'>
          <div class='card-body mg-bnot' id='card-not".$array_not['id']."' style='height: 175px;'>
            <h5 class='card-title color-theme'>".base64_decode($array_not['title_not'])."</h5>
            <p class='card-text'>".base64_decode($array_not['text_not'])."</p>
            <p class='".$text_color." float-right text-sm-not'>".$array_not['date_send']."</p>
            <a href='#ready-not".$array_not['id']."' class='".$btn_type." float-left ready-not mr-2 text-light' id='ready-not".$array_not['id']."' onclick='readynot(".$array_not['id'].")'>
              <i class='".$check_ico." ".$text_color."' title='mark ready' aria-hidden='true'></i>
            </a>
            <a href='#remove-not' class='rm-not float-left ".$text_color."' id='rm-not".$array_not['id']."' onclick='rmnot(".$array_not['id'].")'>
              <i class='fa fa-window-close' title='remove' aria-hidden='true'></i>
            </a>
          </div>
        </div>";

        }

      }

      ?>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>-->
      </div>
    </div>
  </div>
</div>