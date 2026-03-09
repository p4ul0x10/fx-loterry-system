<?php //include $_SERVER['REQUEST_URI']."php/functions.php"; ?>
<?php  
  
  $get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$idu'");
  if($row_true = mysqli_affected_rows($con) >= 1){
    
    $get_user = mysqli_fetch_array($get_theme);
   
  }

?>
<?php if($rows_lt >= 1){ ?> <div class="modal modal-deptkt text-primary" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-tables" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light" align="center">Tickets Buyed</h5>
        <i class="fa-dep-exclamation fa fa-info" aria-hidden="true"></i>
         <div class="float-right" style="margin-left: 63%;"><?php /*if($get_user['show_coin'] == "coin"){ echo "show coin to usd <i id='cvd-coin' class='fa fa-exchange fa-1x convert-val-deps' aria-hidden='true' title='convert coin to usd' style='cursor:pointer;'></i>"; }else{ echo "show usd to coin <i id='cvd-usd' class='fa fa-exchange fa-1x convert-val-deps' aria-hidden='true' title='convert usdt to coin' style='cursor:pointer;'></i>"; }*/ ?></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mb" style="max-height: 300px; overflow-y: auto;">
        <?php listdeposito(); ?>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div> <?php } ?>
<!-- -->
<script type="text/javascript">
$(document).ready(function() {

  $(".close").click(function () {
    $(".sum-for-paid-tkt").remove();
  });
  
 //start
 $(".choose-package").on('click', function(){
      
    count_length = $(".choose-package").length;
  
    for(var count = 0; count < count_length+1; count++){
 
      $(".choose-package:eq("+count+")").removeClass("bg-theme");
      $(".choose-package:eq("+count+")").removeClass("text-light");  
      $(".choose-package:eq("+count+")").addClass("color-theme");     

      if($(this).attr("id") == $(".choose-package:eq("+count+") a").attr("title")){
      
        $(".choose-package:eq("+count+")").addClass("bg-theme");     
        $(".choose-package:eq("+count+")").addClass("text-light");     
        $(".choose-package:eq("+count+")").removeClass("color-theme");     

        $(".buy-tkt-user").show();
      
      }
   
    }
    
    $(".buy-tkt-user").val("");    
    $(".concluir-deposito-tkt").hide();
    $(".sum-for-paid-tkt").remove();

  });
 //end

 //start buy tickets by plan gets / sets
 $(".concluir-deposito-tkt").on("click", function(){

    count_length = $(".choose-package").length;
  
    for(var count = 0; count < count_length+1; count++){

      if($(".choose-package:eq("+count+")").attr("class") == "nav-item choose-package bg-theme text-light" || $(".choose-package:eq("+count+")").attr("class") == "nav-item choose-package bg-theme text-light"){
   
        rel_dep = $(".choose-package:eq("+count+")").attr("id");
        str_dep = rel_dep.replace("#", "");
   
      }
   
    }

    value = $(".buy-tkt-user").val();
    type = "tkt";
    nickname = $(".nick").text();
    
    $.post("php/deposito.php",{"id_dep":str_dep, "nome":nickname, "valor":value, "plan":"tkt", "subject":"Deposit"}, function(data){

      tkt_json = JSON.parse(data);
      $(".return-deposito-tkt").html(tkt_json[0]);
      
      if(tkt_json[1] == "Tickets request created..."){
        
        $(".tkt-response").remove();
        $(".modal-tkt-buy .nav-select-pack ul").html(tkt_json[2]);
        $(".modal-tkt-buy .modal-footer").append('<h4 class="tkt-response ml-3 color-theme" style="left: 0px;position: absolute;">Tickets request created...</h4>');
      
      }
    
    });

 });
 //end

});

function package_li(id_num) {

  count_length = $(".choose-package").length;

  for (var i = 0; i < count_length; i++) {
    
    $(".choose-package:eq("+i+")").removeClass("bg-theme");
    $(".choose-package:eq("+i+")").removeClass("text-light");  
    $(".choose-package:eq("+i+")").addClass("color-theme");     

    if(id_num == $(".choose-package:eq("+i+") a").attr("title")){
    
      $(".choose-package:eq("+i+")").addClass("bg-theme");     
      $(".choose-package:eq("+i+")").addClass("text-light");     
  
      $(".buy-tkt-user").show();
    
    }
  
  }

  $(".buy-tkt-user").val("");    
  $(".concluir-deposito-tkt").hide();
  $(".sum-for-paid-tkt").remove();
  $(".return-deposito-tkt").children().remove();
  $(".tkt-response").hide();

}

function maxtkt(){

  count_length = $(".choose-package").length;
  for(var count = 0; count < count_length; count++){
    
    if($(".choose-package:eq("+count+")").attr("class") == "nav-item choose-package bg-theme text-light" || $(".choose-package:eq("+count+")").attr("class") == "nav-item choose-package bg-theme text-light"){

      get_val_rest = $(".choose-package:eq("+count+") a").attr("id");
      replace_val = get_val_rest.replace("#trt","");
      max_limit = replace_val;
      value = $(".buy-tkt-user").val();    
   
    }
  
  } 

  rest = parseFloat(max_limit) - parseFloat(value);
  if(rest < 0){

    $(".buy-tkt-user").val(max_limit);    
  
  }else{
    
    if(value >= 1){
  
      $(".concluir-deposito-tkt").show();
  
    }else{
  
      $(".concluir-deposito-tkt").hide();
  
    }
  
  }
  
  total_val_tkt = value * 0.20; //0.20 $ each ticket
  $(".sum-for-paid-tkt").remove();

  $(".buy-tkt-user").after("<span class='sum-for-paid-tkt color-theme' style='position: relative !important; top: 10px !important;'>Total: $ <a href='#sum-tickets' class='color-theme' title='for paid'>"+total_val_tkt.toFixed(2)+"</a></span>");
}

</script>
<?php if($rows_rel_dep >= 1){ ?>
<div class="modal modal-tkt-buy text-primary mdp" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="top: 0px !important;">
    <div class="modal-content modal-contentp">
      <div class="modal-header">
        <h5 class="modal-title text-light" align="center">Spend ticket's</h5>
        <i class="fa-dept-exclamation fa fa-info" aria-hidden="true"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" name="formlogin" class="formlogin">
          <div class="form-group">
            <label for="formGroupExampleInput1">User info</label>
            <input type="email" class="form-control color-theme nome-user" value="<?php nome(); ?>" name="nome-user" id="nome-user" disabled>
          </div>
           <div class="form-group" style="display: none;"> 
            <input type="typed" class="form-control text-success typed-user" value="deposit" name="dep-user-type" id="dep-type" disabled>
          </div>
          <div class="form-group"> 
            <label>Select active package</label>
            <nav class="nav nav-select-pack">
              <ul class="container-fluid">
                <?php
                  $get_lt_data = mysqli_query($con, "SELECT * FROM rel_lt_dep WHERE id_user = '$idu' AND total_rest_tkt > 0");

                  $rows_lt_data = mysqli_num_rows($get_lt_data);
                  if($rows_lt_data > 0){
                    
                    while($array_rel_lt = mysqli_fetch_array($get_lt_data)){

                    echo '<li id="#'.$array_rel_lt['id_dep'].'" class="nav-item color-theme choose-package">
                 #'.$array_rel_lt['id_dep'].'<a id="#trt'.$array_rel_lt['total_rest_tkt'].'" class="nav-link text-muted" title="#'.$array_rel_lt['id_dep'].'" href="#tkt"><small style="top: 0px;"> '.$array_rel_lt['total_rest_tkt'].' tickets rest of the '.$array_rel_lt['total_tickets'].'</small></a></li>';  
                
                    }
                    
                  } 
                ?>
              </ul>
            </nav>
          </div>

          <input type="number" class="form-control text-muted buy-tkt-user float-right" name="buy-tkt-valid-limit" id="buy-tkt-valid-limit" placeholder="Amount of the tickets" onclick="maxtkt();" onkeyup="maxtkt();" required style="display: none;">
          <div class="return-deposito-tkt text-center"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-theme concluir-deposito-tkt float-right text-light" style="display: none;">Create</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>