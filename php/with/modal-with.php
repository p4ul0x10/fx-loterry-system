 <?php //include $_SERVER['DOCUMENT_ROOT']."/php/functions.php"; ?>
 <script type="text/javascript">
  $(document).ready(function(){

    $(".concluir-saque").hide();

    //
    $(".link-ret").click(function(){
     
      width = $("body").width();
      
      if(width < 850){
      
        type_modal = "mobile";
        $(".modal-extrato").css({"top":"0px"});
        
        if(width > 800){ //tablet show

          flex_wrap = "initial";

        }else{ //smartphone show

          flex_wrap = "wrap";
        }

      }else{
      
        type_modal = "desktop";
        flex_wrap = "wrap";

      }

      if(location.href.indexOf("modal_withdraws") <= 1){

        location.href = "/backoffice.php?modal_withdraws="+type_modal;
        location.href.reload();
        
      }else{

        dep_mode = 0;
      
        if(location.href.indexOf("withdraws") >= 1){

          dep_mode = "withdraws";

        }
        
        $(".modal-extrato").show();  
        
        $.post('php/dep/on-dep.php', {"wrap": flex_wrap, "modal_type": type_modal, "type_show": dep_mode}, function(data){

          //$(".modal-extrato .modal-body").html(data);

        });
        
      }
      
      len_card = $(".row-flex").length;
    
      if(flex_wrap){
     
        for(i = 0; i < len_card; i++){

          $(".row-flex:eq("+i+")").removeClass("flex-w");
          $(".row-flex:eq("+i+")").addClass("flex-wm");

        } 
      
      }else{

        for(i = 0; i < len_card; i++){

          $(".row-flex:eq("+i+")").removeClass("flex-wm");
          $(".row-flex:eq("+i+")").addClass("flex-w");

        } 

      }

    });

    width = $("body").width();
  
    if(width < 850){ //no-desktop device detected
    
      if(width > 800){ //tablet detected

        flex_wrap = "initial";

      }else{

        flex_wrap = "wrap";

      }

    }else{

      flex_wrap = "wrap";

    }

    len_card = $(".row-flex").length;
  
    if(flex_wrap == "initial"){ //flex-wrap -> tablet show
   
      for(i = 0; i < len_card; i++){

        $(".row-flex:eq("+i+")").removeClass("flex-w");
        $(".row-flex:eq("+i+")").addClass("flex-wm");

      } 
    
    }else if(flex_wrap == "wrap"){ //flex-wrap -> smartphone show

      for(i = 0; i < len_card; i++){

        $(".row-flex:eq("+i+")").removeClass("flex-wm");
        $(".row-flex:eq("+i+")").addClass("flex-w");

      } 

    }  
    //

    $(".list-amount-rest").on('click', function(){
    
      count_length = $(".list-amount-rest").length;
      id_rel = $(this).attr("id");
      
      for(var count = 0; count < count_length+1; count++){
   
        $(".list-amount-rest:eq("+count+")").removeClass("bg-theme");
        $(".list-amount-rest:eq("+count+")").removeClass("text-light");
              
        if($(".list-amount-rest:eq("+count+")").attr("id") == id_rel){

          $(".list-amount-rest:eq("+count+")").removeClass("color-theme");
          $(".list-amount-rest:eq("+count+")").addClass("text-light");
          $(".list-amount-rest:eq("+count+")").addClass("bg-theme");
          
        }
      
      }
  
      count_length = $(".prot-with").length;

      for(prot = 0; prot < count_length; prot++){

        if($(".prot-with:eq("+prot+")").attr("class") == "prot-with bg-theme"){
        
          $(".saque-user").show(); 
          prot = count_length; 
        
        } 
      
      }

      if($(".concluir-saque").css("display") == "none"){
      
        $(".concluir-saque").css("display", "block");
      
      }     

    });

    $(".prot-with").on('click', function(){
      
      count_length = $(".prot-with").length;
      
      for(var count = 0; count < count_length+1; count++){
   
        $(".prot-with:eq("+count+")").removeClass("bg-theme");
        $(".prot-with:eq("+count+") a").removeClass("text-light");
        $(".prot-with:eq("+count+") a").addClass("color-theme");

        if($(this).attr("id") == $(".prot-with:eq("+count+") a").attr("title")){
    
          $(".prot-with:eq("+count+")").addClass("bg-theme");     
          $(".prot-with:eq("+count+") a").addClass("text-light");    
          $(".prot-with:eq("+count+") a").removeClass("color-theme");

        }
    
      }
      
      $(".with-in").show();
      
      //start  
      coin_len_selected = $(".choose-coin-with a").length;

      for (var i = 0; i < coin_len_selected; i++) {
        
        if($(".choose-coin-with:eq("+i+") a").attr("class") == "nav-link bgm bg-theme"){
          
          coin_selected = $(".choose-coin-with:eq("+i+") a img").attr("src");
          break;
        
        }

      }

      num_list_with = $(".list-amount-rest").length;

      for (var i = 0; i < num_list_with; i++) {
        
        if($(".list-amount-rest:eq("+i+") a img").attr("src") != coin_selected){
       
          $(".list-amount-rest:eq("+i+")").hide();
       
        }else{

          $(".list-amount-rest:eq("+i+")").show();

        }

      }
      //end

    });

    if(location.href.indexOf("modal_withdraws") >= 1){
      $(".modal-extrato").show();
    }
    
  });

  function mod_show(id, modal) {

  wd = $("body").width();
  
  if(wd < 975){
    mode = "no_desktop";
  }else{
    mode = "desktop";
  }
  
  $.post('php/show_inout.php',{"id":id,"modal":modal,"mode":mode}, function(data){
    
    if(modal == "modal-dep"){
      $(".modal-depinv .modal-body").html(data);
    }else if(modal == "modal-with"){
      $(".modal-extrato .modal-body").html(data);
    } 

  });
  
  //window.history.pushState(initialState, '', location.href+"&mod_show=");
  }

 </script>
 <?php if($rows_with >= 1){ ?>
 <!-- start modal show withdraws requests -->
 <div class="modal modal-extrato text-primary" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-tables" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-light" align="center">Saques / Extrato</h5>
        <i class="fa-with-exclamation fa fa-question" aria-hidden="true"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
      <?php

      if($_GET["modal_withdraws"] == "desktop"){ 
        listextrato(); 
      }else if($_GET["modal_withdraws"] == "mobile"){ 
        listextrato_mobile();
      }
     
      ?>
      <?php } ?>
      </div>
      <div class='modal-footer'>
        <?php 

        $get_pg = $_GET['pg_with'];

        $get_withdraws = mysqli_query($con, "SELECT * FROM saque WHERE id_user = '$id'");
        $num_rows_dep = mysqli_num_rows($get_withdraws);

        $num_pages = ceil($num_rows_dep / 5);
        $max_pgs_isset = $num_pages;
        
        $count_pgs = 0;
      
        if(!isset($get_pg)){

          $pg_added = 0;
          $get_pg = 1;
          $aux_count = false;
        
        }else{

          //pgs loop vars
          if($get_pg > 10 || $get_pg % 10 == 0){
            $aux_count = true;   
            $pg_added = $get_pg;
          }else{
            $aux_count = false;
          }
          //end
        
        }
                 
        //start df max pg limit
        $df_pg = $max_pgs_isset - $get_pg;
        
        if($df_pg < 10){
          $df_pg_added = $max_pgs_isset - ($max_pgs_isset - $df_pg);
          $pg_added = 10 - $df_pg_added;
        }   
        
        if($get_pg % 10 == 0){
          $pg_added = $get_pg;
        }
        //end

        if($get_pg >= 10){
          $dv = intval($get_pg / 10);
          $pg_added = 10 * $dv;
        }else{
          $pg_added = 0;
        }
        
        $url_default = $_SERVER['SERVER_NAME'];
        $mode_show = $_GET['modal_withdraws'];

        if($_GET['withdraw'] == true){
          $mode_pg = "withdraws=true";     
        }else{
          $mode_pg = "withdraws=true";
        }

        echo "<div class='col float-center'>";
        
        if($num_rows_dep == 5){ //min 5 units / page
          
          echo "<a class='text-muted' href='http://".$url_default."/backoffice.php?modal_withdraws=".$mode_show."&".$mode_pg."&pg_with-=1'>1</a>";
        
        }else if($num_rows_dep > 5){
          
          for ($p = 0; $p < 10; $p++) { 
            
            $pgs = $p + 1;
            
            if($aux_count == true){
              $pg_num = $pg_added;
            }else{
              $pg_num = $pgs;
            }
            
            if(!$get_pg && $p == 0){
              $selected = 'text-muted'; 
            }else if(!$get_pg && $p > 0){
              $selected = 'color-theme';
            }
            
            if($get_pg && $get_pg == $pg_num){
              $selected = 'text-muted';
            }else if($get_pg && $get_pg != $pg_num){
              $selected = 'color-theme';
            }
              
            if($p == 0 && $get_pg > 1 || $p == 0 && $get_pg == $max_pgs_isset){
              $pg_btn = $get_pg - 1;
            }else{
              $pg_btn = $get_pg + 1;
            }
            
            if($p == 0 && $get_pg > 1 || $p == 0 && $get_pg == $max_pgs_isset){
              echo "<a id='pg-with-".$pg_btn."' class='color-theme' href='http://".$url_default."/backoffice.php?modal_withdraws=".$mode_show."&".$mode_pg."&pg_with=".$pg_btn."' alt='page num'>< </a>";
            }     
                                                    
            if($pg_added <= $max_pgs_isset || $p <= 9){  
              echo "<a class='".$selected."' href='http://".$url_default."/backoffice.php?modal_withdraws=".$mode_show."&".$mode_pg."&pg_with=".$pg_num."'>".$pg_num." </a>";
              $pg_added++;
            }

            if($get_pg < 10 && $pg_added >= $max_pgs_isset || $p >= 9){
              
              if($get_pg != $max_pgs_isset){ 
                echo "<a id='pg-with-".$pg_btn."' class='color-theme' href='http://".$url_default."/backoffice.php?modal_withdraws=".$mode_show."&".$mode_pg."&pg_with=".$pg_btn."' alt='page num'> ></a>";
              }

              break;

            }else if($get_pg >= 10 && $pg_added > $max_pgs_isset || $p >= 9){

              if($get_pg != $max_pgs_isset){ 
                echo "<a id='pg-with-".$pg_btn."' class='color-theme' href='http://".$url_default."/backoffice.php?modal_withdraws=".$mode_show."&".$mode_pg."&pg_with=".$pg_btn."' alt='page num'> ></a>";
              }

              break;

            }
           
          }

        }

        echo "</div>";

        ?>
      </div>
    </div>
  </div>
</div>
<!-- end modal show withdraws requests -->
<!-- -->
<div class="modal modal-saque text-primary" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="top: 0px !important;">
    <div class="modal-content modal-contentp modal-content-with">
      <div class="modal-header">
        <h5 class="modal-title text-light" align="center">Withdraw</h5>
        <i class="fa-withm-exclamation fa fa-question" aria-hidden="true"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" name="formlogin" class="formlogin">
          <div class="form-group">
            <label for="formGroupExampleInput1" class="text-light">Withdraw info</label>
            <input type="email" class="form-control color-theme nome-user-s" value="<?php echo nome(); ?>" name="nome-user" id="nome-user" disabled>
          </div>
           <div class="form-group"> 
            <label>Select coin for withdraw</label>
            <nav class="nav nav-select-dep">
              <ul class="container-fluid">
                <li class="nav-item choose-coin-with">
                  <a class="nav-link bgm" href="#usdt" onclick="upt(1);"><img class='img-action-sm'src='images/coins/usdt-sm.png' title='usdt' width='20px' height='20px' alt='usdt coin'></a>
                </li>
                <li class="nav-item choose-coin-with">
                  <a class="nav-link bgm" href="#btc" onclick="upt(2);"><img class='img-action-sm'src='images/coins/btc-sm.png' title='btc' width='20px' height='20px' alt='btc coin'></a>
                </li>
                <li class="nav-item choose-coin-with">
                  <a class="nav-link bgm" href="#eth" onclick="upt(3);"><img class='img-action-sm'src='images/coins/eth-sm.png' title='eth' width='20px' height='20px' alt='eth coin'></a>
                </li>
                 <li class="nav-item choose-coin-with">
                  <a class="nav-link bgm" href="#ltc" onclick="upt(4);"><img class='img-action-sm'src='images/coins/ltc-sm.png' title='ltc' width='20px' height='20px' alt='ltc coin'></a>
                </li>
                <li class="nav-item choose-coin-with">
                  <a class="nav-link bgm" href="#tron" onclick="upt(5);"><img class='img-action-sm'src='images/coins/trx-sm.png' title='trx' width='20px' height='20px' alt='busd coin'></a>
                </li>
                <li class="nav-item choose-coin-with">
                  <a class="nav-link bgm" href="#pix-nubank" onclick="upt(6);"><img class='img-action-sm'src='images/coins/pix.png' title='trx' width='20px' height='20px' alt='brl coin'></a>
                </li>
              </ul>
            </nav>
            <ul id="list_prot">
              <li class='prot-with' id='btc' onclick="upt(0);"><a href='#btc' title='btc'>btc</a></li>
              <li class='prot-with' id='btc-bep20' onclick="upt(0);"><a href='#btc' title='btc-bep20'>btc-bep20</a></li>
              <li class='prot-with' id='segwit' onclick="upt(0);"><a href='#btc' title='segwit'>segwit</a></li>
              <li class='prot-with' id='eth-erc20' onclick="upt(0);"><a href='#eth' title='eth-erc20'>eth-erc20</a></li>
              <li class='prot-with' id='eth-bep20' onclick="upt(0);"><a href='#eth' title='eth-bep20'>eth-bep20</a></li>
              <li class='prot-with' id='arbitrum' onclick="upt(0);"><a href='#eth' title='arbitrum'>arbitrum</a></li>
              <li class='prot-with' id='avaxc' onclick="upt(0);"><a href='#eth' title='avaxc'>avaxc</a></li>
              <li class='prot-with' id='trx-trc20' onclick="upt(0);"><a href='#tron' title='trx-trc20'>trx-trc20</a></li>
              <li class='prot-with' id='trx-bep20' onclick="upt(0);"><a href='#tron' title='trx-bep20'></a></li>
              <li class='prot-with' id='ltc' onclick="upt(0);"><a href='#ltc' title='ltc'>ltc</a></li>
              <li class='prot-with' id='ltc-bep20' onclick="upt(0);"><a href='#ltc' title='ltc-bep20'>ltc-bep20</a></li>
              <li class='prot-with' id='bnb-bep20' onclick="upt(0);"><a href='#bnb' title='bnb-bep20'>bnb-bep20</a></li>
              <li class='prot-with' id='tether-erc20' onclick="upt(0);"><a href='#usdt' title='tether-erc20'>tether-erc20</a></li>
              <li class='prot-with' id='tether-bep20' onclick="upt(0);"><a href='#usdt' title='tether-bep20'>tether-bep20</a></li>
              <li class='prot-with' id='arbitrum' onclick="upt(0);"><a href='#usdt' title='arbitrum'>arbitrum</a></li>
              <li class='prot-with' id='avaxc' onclick="upt(0);"><a href='#usdt' title='avaxc'>avaxc</a></li>
              <li class='prot-with' id='pix-nubank' onclick="upt(0);"><a href='#pix-nubank' title='pix-nubank'>pix-nubank</a></li>
            </ul>
          </div>
          <!--<div class="form-group">
            <input type="text" class="form-control text-success cpfuser-s" value="" name="cpfuser" id="cpfuser" disabled>
          </div>-->
          <div class="form-group" style="display: none;"> 
            <input type="types" class="form-control text-success types-user" value="withdraw" name="sub withdraw" id="types" disabled>
          </div>
          <div class="form-group with-in" style="max-height: 200px; overflow-y: auto;"> 
            <ul>
              <span>Withdraw in</span>
              <small>
              <?php 
              $email = $_SESSION['email'];
              $get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$email'");

              if($ru = mysqli_affected_rows($con) >= 1){
                
                $user = mysqli_fetch_array($get_user);
                $id_user = $user['id'];
                $get_dep = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id_user' AND status = '1' ORDER BY id ASC");
                
                if($rd = mysqli_affected_rows($con) >= 1){

                  while($array_deps = mysqli_fetch_array($get_dep)){

                    if($array_deps['FINISH'] == 'FALSE'){

                      $deb_dias = 30 - $array_deps['qtd_dias'];
                      $id_dep = $array_deps['id'];
                      $dep_plan = $array_deps['type_dep'];
                      //

                      if($deb_dias >= 0){

                        $get_rel_deps = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_dep = '$id_dep' ORDER BY id ASC");
                        
                        $get_rel = mysqli_fetch_array($get_rel_deps);

                        $rel_dep_coin = $get_rel['coin'];
                        $id_dep = $get_rel['id_dep'];

                        $get_info_percent = mysqli_query($con, "SELECT * FROM info WHERE id ='1'");
                        $array_info = mysqli_fetch_array($get_info_percent);

                        if($dep_plan == "Starter"){
                          $percent = $array_info['plan1'];
                        }else if($dep_plan == "Advanced"){
                          $percent = $array_info['plan2'];
                        }else if($dep_plan == "Premium"){
                          $percent = $array_info['plan3'];
                        }
                        //

                        //$coin != "btc" && $coin != "tron" && $coin != "usdt" && $coin != "ltc" && $coin != "bnb" && $coin != "eth"){
                        if($rel_dep_coin == "btc"){
                          $img = "images/coins/btc-sm.png";
                        }else if($rel_dep_coin == "tron"){
                          $img = "images/coins/trx-sm.png";
                        }else if($rel_dep_coin == "usdt"){
                          $img = "images/coins/usdt-sm.png";
                        }else if($rel_dep_coin == "ltc"){
                          $img = "images/coins/ltc-sm.png";
                        }else if($rel_dep_coin == "bnb"){
                          $img = "images/coins/bnb-sm.png";
                        }else if($rel_dep_coin == "eth"){
                          $img = "images/coins/eth-sm.png";
                        }else if($rel_dep_coin == "pix"){
                          $img = "images/coins/pix.png";
                        }
                        //

                        $max_return = ((number_format($percent, 2, ".", "") * $get_rel['value']) / 100) * 30;
                        //
                        $get_with = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE dep_con = '$id_dep'");
                        
                        if($rw = mysqli_affected_rows($con) >= 1){

                          $array_with_true = mysqli_fetch_array($get_with);  
                          $id_with = $array_with_true['id_charnum'];
                          
                          $get_sum_with = mysqli_query($con, "SELECT sum(quantidade)qtd FROM saque WHERE con_with ='$id_with'");
                          $array_sum = mysqli_fetch_array($get_sum_with);
                          $value_with = $array_sum['qtd'];
                         
                          if($rest_value >= 0){
                            echo "<li class='list-amount-rest bgm' id='dep".$get_rel['id_charnum']."'><b>#".$get_rel['id_charnum']." Rakeback</b> $"." ".number_format($max_return, 2, ".", "")." <i class='fa fa-exchange' aria-hidden='true'></i> ".number_format($rest_value, 2, ".", "")." <a class='cv text-muted' href='#'>Rest in <img src='".$img."' width='20px' height='20px' alt='coin avaliable'></a></li>";
                          }
                        
                        }else{

                          $rest_value = $max_return;
                          if($max_return > $user['total_disp']){
                
                            echo "<li class='list-amount-rest bgm' id='dep".$get_rel['id_charnum']."'><b>#".$id_charnum." Rakeback</b> $"." ".number_format($max_return, 2, ".", "")." <i class='fa fa-exchange' aria-hidden='true'></i> ".number_format($rest_value, 2, ".", "")." <a class='cv text-muted' href='#'>Rest in <img src='".$img."' width='20px' height='20px' alt='coin avaliable'></a></li>";
                
                          }else{
                
                            echo "<li class='list-amount-rest bgm' id='dep".$get_rel['id_charnum']."'><b>#".$id_charnum." Rakeback</b> $"." ".number_format($rest_value, 2, ".", "")." <i class='fa fa-exchange' aria-hidden='true'></i> ".number_format($max_return, 2, ".", "")." <a class='cv text-muted' href='#'>Rest in <img src='".$img."' width='20px' height='20px' alt='coin avaliable'></a></li>";
               
                          }
                        
                        }
                      
                      }
                    
                    }
                  
                  }
                
                }
                //end show dep -> rakeback

                //start amount -> win loterry 
                $get_credit_loterry = mysqli_query($con, "SELECT * FROM loterry_winners WHERE id_user = '$id_user'");
                
                while($array_credit_loterry = mysqli_fetch_array($get_credit_loterry)){
                  
                  $get_rel_loterry = mysqli_query($con, "SELECT * FROM rel_withdraw WHERE dep_con='$id_dep_c' AND type_out='tkt'");

                  if($rows_rel_lt = mysqli_affected_rows($con) > 1){ //dep in progress
                    
                    $ar_rel_withdraw = mysqli_fetch_array($get_rel_loterry);
                    $id_charnum = $ar_rel_withdraw['id_charnum'];

                    $get_amount_withdraw = mysqli_query($con, "SELECT sum(qtd) as value FROM saque WHERE con_with='$id_charnum'");
                    $ar_amount_withdraw = mysqli_fetch_array($get_amount_withdraw);
                    $rest_value = $array_credit_loterry['total_earn'] - $ar_amount_withdraw['value'];

                  }else{ //dep full amount rest

                    $max_return = $array_credit_loterry['total_earn'];
                    $rest_value = $max_return;
                    $id_charnum = $array_credit_loterry['rel_tickets'];

                    //start
                    $ar_str = str_split($id_charnum);
                    $str_p = strpos($id_charnum,"-");
                          
                    $c = 0;
                    $id = array();

                    while($c < $str_p){

                      $id[$c] = $ar_str[$c];
                      $c++;

                    }

                    $id_im = implode("",$id); 
                    //end 

                  }
                  
                  //start
                  $get_coin = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum ='$id_im'");
                    
                  while($return_coin = mysqli_fetch_array($get_coin)){
                   
                    $rel_dep_coin = $return_coin['coin'];

                    if($rel_dep_coin == "btc"){
                      $img = "images/coins/btc-sm.png";
                    }else if($rel_dep_coin == "tron"){
                      $img = "images/coins/trx-sm.png";
                    }else if($rel_dep_coin == "usdt"){
                      $img = "images/coins/usdt-sm.png";
                    }else if($rel_dep_coin == "ltc"){
                      $img = "images/coins/ltc-sm.png";
                    }else if($rel_dep_coin == "bnb"){
                      $img = "images/coins/bnb-sm.png";
                    }else if($rel_dep_coin == "eth"){
                      $img = "images/coins/eth-sm.png";
                    }else if($rel_dep_coin == "pix"){
                      $img = "images/coins/pix.png";
                    }

                    if($rest_value > 0.20){
                      echo "<li class='list-amount-rest bgm' id='".$array_credit_loterry['rel_tickets']."'><b>#".$array_credit_loterry['rel_tickets']." Loterry</b> $"." ".number_format($rest_value, 2, ".", "")." <i class='fa fa-exchange' aria-hidden='true'></i> ".number_format($max_return, 2, ".", "")." <a class='cv text-muted' href='#'>Rest in <img src='".$img."' width='20px' height='20px' alt='coin avaliable'></a></li>";
                    }
                      
                  } 
                  //end 
                 
                }

                //end -> win loterr
              }
              
              ?>
              </small>
            </ul>
          </div>
          <div class="form-group saque-user">
            <small>Total account <?php total_acc_user(); ?></small><br>
            <label class="text-light">Amount withdraw</label>
            <input type="text" class="form-control text-success"  name="wallet-user" id="wallet-user" placeholder="Withdraw wallet" minlength="20"><br>
            <input type="text" class="form-control text-success"  name="saque-user" id="saque-user" placeholder="Amount" minlength="1">
          </div>
          <div class="return-saque text-center"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-theme text-light concluir-saque float-right">Make withdraw</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  
  function upt(id){
    
    if(id != "0"){

      if(id == "1"){
        cpm = "#usdt";
      }else if(id == "2"){  
        cpm = "#btc";
      }else if(id == "3"){
        cpm = "#eth";
      }else if(id == "4"){
        cpm = "#ltc";
      }else if(id == "5"){
        cpm = "#tron";
      }else if(id == "6"){
        cpm = "#pix-nubank";
      }else if(id == "7"){
        cpm = "#pix-nubank";
      }

      count_list_amount_rest = $(".list-amount-rest").length;
      count_list_coin = $(".choose-coin-with").length;
      
      for (var i = 0; i < count_list_coin+1; i++) {
        
        if($(".choose-coin-with:eq("+i+") a").attr("href") != cpm){

          $(".choose-coin-with:eq("+i+") a").removeClass("bg-theme");

        }else{

          $(".choose-coin-with:eq("+i+") a").addClass("bg-theme");

        }

      }
    
    }

    for (var c = count_list_coin - 1; c >= 0; c--) {
      
      if($(".choose-coin-with:eq("+c+") a").attr("class") == "nav-link bg-light"){
      
        coin_selected = $(".choose-coin-with:eq("+c+") a").attr("href");
        
        for (var l = count_list_amount_rest - 1; l >= 0; l--) {
          
          $(".list-amount-rest:eq("+l+")").show();
          
          if(coin_selected == "#btc"){
            cpm = "images/coins/btc-sm.png";
          }else if(coin_selected == "#eth"){  
            cpm = "images/coins/eth-sm.png";
          }else if(coin_selected == "#tron"){
            cpm = "images/coins/trx-sm.png";
          }else if(coin_selected == "#ltc"){
            cpm = "images/coins/ltc-sm.png";
          }else if(coin_selected == "#bnb"){
            cpm = "images/coins/bnb-sm.png";
          }else if(coin_selected == "#usdt"){
            cpm = "images/coins/usdt-sm.png";
          }else if(coin_selected == "#pix-nubank"){
            cpm = "images/coins/pix.png";
          }

          coin_list = $(".list-amount-rest:eq("+l+") img").attr("src");

          if(coin_list != cpm){

            $(".list-amount-rest:eq("+l+")").hide();

          }else{

            $(".with-in").show();

          }
        
        } 

      }

    } 

    $(".concluir-saque").hide();
    $(".saque-user").hide()

  }

  if($(".lights").attr("id") == "#light"){
        
    $(".modal-content").removeClass("bg-dark");
    $(".modal-content").addClass("bg-light");
    $(".modal-content").removeClass("text-light");
    $(".modal-content").addClass("color-theme");

    $(".modal-extrato .modal-header").addClass("bg-theme");
    $(".modal-extrato .modal-title").addClass("text-light");
  
  }else{

    $(".modal-content").removeClass("bg-light");
    $(".modal-content").addClass("bg-dark");
    $(".modal-content").removeClass("color-theme");
    $(".modal-content").addClass("text-light");

    $(".modal-extrato .modal-header").addClass("bg-theme");
    $(".modal-extrato .modal-title").addClass("text-light");
  
  }

</script>
