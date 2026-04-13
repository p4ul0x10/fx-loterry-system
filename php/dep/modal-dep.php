<?php 

include "localhost".$_SERVER['REQUEST_URI']."/php/functions.php"; 
include "localhost".$_SERVER['REQUEST_URI']."/php/theme-mod/mode_class.php";

?>

<?php  
  
  $get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$idu'");
  if($row_true = mysqli_affected_rows($con) >= 1){
    
    $get_user = mysqli_fetch_array($get_theme);
   
  }

?>
<script type="text/javascript">
  
  $(document).ready(function(){
    
    if(location.href.indexOf("modal_deposits") >= 1){
      $(".modal-depinv").show();
    }

    $(".link-depinv").click(function(){
     
      width = $("body").width();
      
      if(width < 850){
      
        type_modal = "mobile";
  
        $(".modal-depositar").css({"top":"0px"});
        
        if(width > 800){ //tablet show

          flex_wrap = "initial";

        }else{ //smartphone show

          flex_wrap = "wrap";
        }

      }else{
      
        type_modal = "desktop";
        flex_wrap = "wrap";

      }

      if(location.href.indexOf("modal_deposits") <= 1){

        location.href = "/backoffice.php?modal_deposits="+type_modal;
        location.href.reload();
        
      }else{
        
        dep_mode = 0;
      
        if(location.href.indexOf("dep-packages") >= 1){

          dep_mode = "dep-packages";

        }

        if(location.href.indexOf("dep_tickets") >= 1){

          dep_mode = "dep-tickets"; 

        }  
        
        if(dep_mode == 0){
          dep_mode = "dep-packages";
        }

        $(".modal-depinv").show();  
        
        /*$.post('php/dep/on-dep.php', {"wrap": flex_wrap, "modal_type": type_modal, "type_show": dep_mode}, function(data){

          $(".modal-depinv .modal-body").html(data);

        });*/
        
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

      wd_w = window.innerWidth;
      ajust_card(wd_w);
    
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

  });
</script>

<?php if($rows_dep >= 1){ ?>
<script type="text/javascript">
  
  function filter(id){

    if(id == 1){
      type = $("#dep_val i:eq(0)").attr("class");
    }else  if(id == 2){
       type = $("#dep_data i:eq(0)").attr("class");
    } 

    //start alter list dep by filter
    for (var c = 0; c <= 6; c++) {

      cc = parseFloat(c)+parseFloat(1);
      if(cc >= 0){

        if(id==1){
        
          e1 = $(".dep-list:eq("+c+") td:eq(2)").text();
          e2 = $(".dep-list:eq("+cc+") td:eq(2)").text();
          cmp = parseFloat(e2) - parseFloat(e1);
          
        }else if(id==2){
          
          e1 = $(".dep-list:eq("+c+") td:eq(5)").text();
          e2 = $(".dep-list:eq("+cc+") td:eq(5)").text();
        
          str_cmp1 = e1.charAt(4);
          str_cmp2 = e2.charAt(4);
          str_cmp11 = e1.charAt(5);
          str_cmp22 = e2.charAt(5);

          if(str_cmp1 == ","){
            
            str_data11 = e1.charAt(0);
            str_data12 = e1.charAt(1);
            str_data13 = e1.charAt(3);
            str_data14 = e1.charAt(5);
            str_data15 = e1.charAt(6);
            str_data16 = e1.charAt(7);
            str_data17 = e1.charAt(8);
            str_data_m1 = str_data11+""+str_data12+""+str_data13+""+str_data14+""+str_data15+""+str_data16+""+str_data17;
    
          }
          
          if(str_cmp11 == ","){
            
            str_data11 = e1.charAt(0);
            str_data12 = e1.charAt(1);
            str_data13 = e1.charAt(3);
            str_data14 = e1.charAt(4);
            str_data16 = e1.charAt(6);
            str_data17 = e1.charAt(7);
            str_data18 = e1.charAt(8);
            str_data19 = e1.charAt(9);
            str_data_m1 = str_data11+""+str_data12+""+str_data13+""+str_data14+""+str_data16+""+str_data17+""+str_data18+""+str_data19;
  
          }

          if(str_cmp2 == ","){

            str_data21 = e2.charAt(0);
            str_data22 = e2.charAt(1);
            str_data23 = e2.charAt(3);
            str_data24 = e2.charAt(5);
            str_data25 = e2.charAt(6);
            str_data26 = e2.charAt(7);
            str_data27 = e2.charAt(8);
            str_data_m2 = str_data21+""+str_data22+""+str_data23+""+str_data24+""+str_data25+""+str_data26+""+str_data27;

          }

          if(str_cmp22 == ","){
            
            str_data21 = e2.charAt(0);
            str_data22 = e2.charAt(1);
            str_data23 = e2.charAt(3);
            str_data24 = e2.charAt(4);
            str_data26 = e2.charAt(6);
            str_data27 = e2.charAt(7);
            str_data28 = e2.charAt(8);
            str_data29 = e2.charAt(9);
            str_data_m2 = str_data21+""+str_data22+""+str_data23+""+str_data24+""+str_data26+""+str_data27+""+str_data28+""+str_data29;
  
          }

          cmp = parseFloat(str_data_m2) - parseFloat(str_data_m1);

        }     
    
        if(type == "fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald"){
          
          //$(".fa-dep-modald").attr("class", "fa fa-dep-modal fa-sort-asc text-light fa-dep-modald");

          if(cmp >= 0.01){
            
            he1 = $(".tbody-dep-list tr:eq("+c+")").html();
            he2 = $(".tbody-dep-list tr:eq("+cc+")").html();
           
            $(".tbody-dep-list tr:eq("+c+")").html(he2);
            $(".tbody-dep-list tr:eq("+cc+")").html(he1);
            
            c = 0;
          }
      
        }else if(type == "fa fa-dep-modal fa-sort-asc text-muted fa-dep-modald"){

          //$(".fa-dep-modald").attr("class", "fa fa-dep-modal fa-sort-desc text-light fa-dep-modald");
    
           if(cmp != 0 && cmp <= 0.01 && id == 1){
            
            he1 = $(".tbody-dep-list tr:eq("+c+")").html();
            he2 = $(".tbody-dep-list tr:eq("+cc+")").html();
           
            $(".tbody-dep-list tr:eq("+c+")").html(he2);
            $(".tbody-dep-list tr:eq("+cc+")").html(he1);
            
            c = 0;

          }else if(id == 2 && str_data_m2 < str_data_m1){

            he1 = $(".tbody-dep-list tr:eq("+c+")").html();
            he2 = $(".tbody-dep-list tr:eq("+cc+")").html();
           
            $(".tbody-dep-list tr:eq("+c+")").html(he2);
            $(".tbody-dep-list tr:eq("+cc+")").html(he1);
            
            c = 0;
          
          }

        }

      }

    }
    //end alter list by filter
  
    if(type == "fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald"){ //ajust for desc
    
      if(id == 1){
        $(".fa-dep-modald:eq(0)").attr("class", "fa fa-dep-modal fa-sort-asc text-muted fa-dep-modald");
      }else if(id == 2){
        $(".fa-dep-modald:eq(1)").attr("class", "fa fa-dep-modal fa-sort-asc text-muted fa-dep-modald");
      } 
    
      for(c = 0; c <= 6; c++){
      
        cc = parseFloat(c)+parseFloat(1);

        if(cc >= 0){
    
          if(id==1){
           
            e1 = $(".dep-list:eq("+c+") td:eq(2)").text();
            e2 = $(".dep-list:eq("+cc+") td:eq(2)").text();
            cmp = parseFloat(e2) - parseFloat(e1);
         
          }else if(id==2){
          
            e1 = $(".dep-list:eq("+c+") td:eq(5)").text();
            e2 = $(".dep-list:eq("+cc+") td:eq(5)").text();
            
            str_cmp1 = e1.charAt(4);
            str_cmp2 = e2.charAt(4);
            str_cmp11 = e1.charAt(5);
            str_cmp22 = e2.charAt(5);

            if(str_cmp1 == ","){
              
              str_data11 = e1.charAt(0);
              str_data12 = e1.charAt(1);
              str_data13 = e1.charAt(3);
              str_data14 = e1.charAt(5);
              str_data15 = e1.charAt(6);
              str_data16 = e1.charAt(7);
              str_data17 = e1.charAt(8);
              str_data_m1 = str_data11+""+str_data12+""+str_data13+""+str_data14+""+str_data15+""+str_data16+""+str_data17;
      
            }
            
            if(str_cmp11 == ","){
              
              str_data11 = e1.charAt(0);
              str_data12 = e1.charAt(1);
              str_data13 = e1.charAt(3);
              str_data14 = e1.charAt(4);
              str_data16 = e1.charAt(6);
              str_data17 = e1.charAt(7);
              str_data18 = e1.charAt(8);
              str_data19 = e1.charAt(9);
              str_data_m1 = str_data11+""+str_data12+""+str_data13+""+str_data14+""+str_data16+""+str_data17+""+str_data18+""+str_data19;
    
            }

            if(str_cmp2 == ","){

              str_data21 = e2.charAt(0);
              str_data22 = e2.charAt(1);
              str_data23 = e2.charAt(3);
              str_data24 = e2.charAt(5);
              str_data25 = e2.charAt(6);
              str_data26 = e2.charAt(7);
              str_data27 = e2.charAt(8);
              str_data_m2 = str_data21+""+str_data22+""+str_data23+""+str_data24+""+str_data25+""+str_data26+""+str_data27;
            
            }

            if(str_cmp22 == ","){
              
              str_data21 = e2.charAt(0);
              str_data22 = e2.charAt(1);
              str_data23 = e2.charAt(3);
              str_data24 = e2.charAt(4);
              str_data26 = e2.charAt(6);
              str_data27 = e2.charAt(7);
              str_data28 = e2.charAt(8);
              str_data29 = e2.charAt(9);
              str_data_m2 = str_data21+""+str_data22+""+str_data23+""+str_data24+""+str_data26+""+str_data27+""+str_data28+""+str_data29;
    
            }

            cmp = parseFloat(str_data_m2) - parseFloat(str_data_m1);

          }     
      
          if(cmp >= 0.01){
            
            he1 = $(".tbody-dep-list tr:eq("+c+")").html();
            he2 = $(".tbody-dep-list tr:eq("+cc+")").html();
           
            $(".tbody-dep-list tr:eq("+c+")").html(he2);
            $(".tbody-dep-list tr:eq("+cc+")").html(he1);
            
            c = 0;
          }

        }
    
      }
    
    }else{ //start ajust for asc

      if(id == 1){
        $("#dep_val i:eq(0)").attr("class", "fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald");
      }else if(id == 2){
        $("#dep_data i:eq(0)").attr("class", "fa fa-dep-modal fa-sort-desc text-muted fa-dep-modald");
      }

      for(c = 0; c <= 6; c++){
      
        cc = parseFloat(c)+parseFloat(1);
        if(cc >= 0){
    
          if(id==1){
           
            e1 = $(".dep-list:eq("+c+") td:eq(2)").text();
            e2 = $(".dep-list:eq("+cc+") td:eq(2)").text();
            cmp = parseFloat(e2) - parseFloat(e1);
         
          }else if(id==2){
          
            e1 = $(".dep-list:eq("+c+") td:eq(5)").text();
            e2 = $(".dep-list:eq("+cc+") td:eq(5)").text();
            
            str_cmp1 = e1.charAt(4);
            str_cmp2 = e2.charAt(4);
            str_cmp11 = e1.charAt(5);
            str_cmp22 = e2.charAt(5);

            if(str_cmp1 == ","){
              
              str_data11 = e1.charAt(0);
              str_data12 = e1.charAt(1);
              str_data13 = e1.charAt(3);
              str_data14 = e1.charAt(5);
              str_data15 = e1.charAt(6);
              str_data16 = e1.charAt(7);
              str_data17 = e1.charAt(8);
              str_data_m1 = str_data11+""+str_data12+""+str_data13+""+str_data14+""+str_data15+""+str_data16+""+str_data17;
      
            }
            
            if(str_cmp11 == ","){
              
              str_data11 = e1.charAt(0);
              str_data12 = e1.charAt(1);
              str_data13 = e1.charAt(3);
              str_data14 = e1.charAt(4);
              str_data16 = e1.charAt(6);
              str_data17 = e1.charAt(7);
              str_data18 = e1.charAt(8);
              str_data19 = e1.charAt(9);
              str_data_m1 = str_data11+""+str_data12+""+str_data13+""+str_data14+""+str_data16+""+str_data17+""+str_data18+""+str_data19;
    
            }

            if(str_cmp2 == ","){

              str_data21 = e2.charAt(0);
              str_data22 = e2.charAt(1);
              str_data23 = e2.charAt(3);
              str_data24 = e2.charAt(5);
              str_data25 = e2.charAt(6);
              str_data26 = e2.charAt(7);
              str_data27 = e2.charAt(8);
              str_data_m2 = str_data21+""+str_data22+""+str_data23+""+str_data24+""+str_data25+""+str_data26+""+str_data27;

            }

            if(str_cmp22 == ","){
              
              str_data21 = e2.charAt(0);
              str_data22 = e2.charAt(1);
              str_data23 = e2.charAt(3);
              str_data24 = e2.charAt(4);
              str_data26 = e2.charAt(6);
              str_data27 = e2.charAt(7);
              str_data28 = e2.charAt(8);
              str_data29 = e2.charAt(9);
              str_data_m2 = str_data21+""+str_data22+""+str_data23+""+str_data24+""+str_data26+""+str_data27+""+str_data28+""+str_data29;
    
            }

            cmp = parseFloat(str_data_m2) - parseFloat(str_data_m1);

          }     
         
         if(cmp != 0 && cmp <= 0.01 && id == 1){
            
            he1 = $(".tbody-dep-list tr:eq("+c+")").html();
            he2 = $(".tbody-dep-list tr:eq("+cc+")").html();
           
            $(".tbody-dep-list tr:eq("+c+")").html(he2);
            $(".tbody-dep-list tr:eq("+cc+")").html(he1);
            
            c = 0;

          }else if(id == 2 && str_data_m2 < str_data_m1){

            he1 = $(".tbody-dep-list tr:eq("+c+")").html();
            he2 = $(".tbody-dep-list tr:eq("+cc+")").html();
           
            $(".tbody-dep-list tr:eq("+c+")").html(he2);
            $(".tbody-dep-list tr:eq("+cc+")").html(he1);
            
            c = 0;
            
          }

        }
      
      }
    
    }
    //end 

    //start ajust html btn
    for (var c = 0; c <= 6; c++) {
      e1 = $(".tbody-dep-list tr:eq("+c+") td:eq(1)").text();
    
      $(".tbody-dep-list tr:eq("+c+")").attr("id","tr"+e1);  
    }
    //end ajust html btn
  }

  function mod_show(id, modal) {

    wd = $("body").width();
    
    if(wd < 975){
      mode = "no_desktop";
    }else{
      mode = "desktop";
    }
    
    /*$.post('php/show_inout.php',{"id":id,"modal":modal,"mode":mode}, function(data){
      
      if(modal == "modal-dep"){
        $(".modal-depinv .modal-body").html(data);
      }else if(modal == "modal-with"){
        $(".modal-extrato .modal-body").html(data);
      } 

    });*/

    wd_w = window.innerWidth;
    ajust_card(wd_w);
    
    //window.history.pushState(initialState, '', location.href+"&mod_show=");
  }

  function ajust_card(div_width) {
      
    alert("enload");  
    //start ajust data on card -> deposits mobile (smartphone)
    wd_col = $(".col-mb-dep-h").width();
    $(".col-12 .col-sm-12").css({"margin-top": "2%"});

    if(div_width < 768){
      
      wd_li = wd_col / 3;
      wd_li2 = wd_col / 2;
      
      for(ic = 0; ic < 5; ic++){
       
        for(i = 0; i < 3; i++){
          $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(0) li:eq("+i+")").css({"width": wd_li});
        }

        for(i = 0; i < 2; i++){
          $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(1) li:eq("+i+")").css({"width": wd_li2});
        }
      
      }

    }else if(div_width >= 768 && div_width <= 1024){
      
      wd_li = wd_col / 5.1;
      
      for(var ic = 0; ic < 5; ic++) {
          
        for (var i = 0; i < 3; i++) {
          $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(0) li:eq("+i+")").css({"width": wd_li});
        }

        for (var i = 0; i < 2; i++) {
          $(".col-mb-dep-h:eq("+ic+") .ul-dep:eq(1) li:eq("+i+")").css({"width": wd_li});
        }

      }
    
    }
    //end
  } 
</script>
<div class="modal modal-depinv text-primary" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-tables" role="document">
    <div class="modal-content">
      <div class="modal-header bg-theme">
        <h5 class="modal-title text-light" align="center">Deposits</h5>
        <i class="fa-dep-exclamation fa fa-question" aria-hidden="true"></i>
        <div class="col-md float-right mt-2">
          <nav class="nav nav-mdep float-right">
            <ul>
              <li><a class="text-light" href="http://<?php 
              $url_dep = $_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI']; 
              
              if($_GET['modal_deposits'] == "desktop"){ 
                $mode = "modal_deposits=desktop"; 
              }else{ 
                $mode = "modal_deposits=mobile"; 
              } 

              $url_df = $_SERVER['SERVER_NAME']."/backoffice.php?".$mode.""; 
              
              if(!$_GET['dep_packages']){ 

                $url_dep_now = $url_dep."&dep_packages=true"; 
              
                if($_GET['dep_tickets'] == 'true'){ 
                  $url_dep_now = $url_df."&dep_packages=true"; 
                } 

              }else{ 
                $url_dep_now = $url_dep; 
              } 
      
              echo $url_dep_now; ?>" id="modal_dep_p" onclick="mod_show(id,'modal-dep');">Packages</a></li>
      
              <li><a class="text-light" href="http://<?php 
              if(!$_GET['dep_tickets']){ 

                $url_dep_now = $url_dep."&dep_tickets=true"; 

                if($_GET['dep_packages'] == 'true'){ 
                  $url_dep_now = $url_df."&dep_tickets=true"; 
                }

              }else{ 
              
                $url_dep_now = $url_dep; 
              
              } 
      
              echo $url_dep_now; ?>" id="modal_dep_t" onclick="mod_show(id,'modal-dep');">Tickets</a></li>
            </ul>
          </nav>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mb" style="max-height: 300px; overflow-y: auto;">
        <?php 
        
          if($_GET["modal_deposits"] == "desktop"){ 
            
            if(!$_GET['dep_packages'] && !$_GET['dep_tickets']){
              listdeposito(); 
            }else{
              
              if($_GET['dep_packages'] == "true"){
                listdeposito(); 
              }else{
                listdeposito_t();
              }
            
            }
            
          }else if($_GET["modal_deposits"] == "mobile"){

            if(!$_GET['dep_packages'] && !$_GET['dep_tickets']){
              listdeposito_mobile(); 
            }else{
             
              if($_GET['dep_packages'] == "true"){
                listdeposito_mobile();
              }else if($_GET['dep_tickets'] == "true"){
                listdeposito_mobile_t();
              }
            
            }
          
          }

        ?>
      </div>
      <div class='modal-footer'>
      <?php 
      
      $get_pg = $_GET['pg_dep'];
      
      if(!isset($_GET['dep_tickets'])){

        $get_deps = mysqli_query($con, "SELECT * FROM deposits WHERE id_user = '$id_user'");
        $num_rows_dep = mysqli_num_rows($get_deps);
      
      }else{
      
        $get_deps_t = mysqli_query($con, "SELECT * FROM loterry_tkt_buyed WHERE id_user = '$id_user'");
        $num_rows_dep = mysqli_num_rows($get_deps_t);
      
      }

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
      $mode_show = $_GET['modal_deposits'];

      if($_GET['dep_packages'] == true){
        $mode_pg = "dep_packages=true";     
      }else if($_GET['dep_tickets'] == true){
        $mode_pg = "dep_tickets=true";
      }else{
        $mode_pg = "dep_packages=true"; 
      }

      echo "<div class='col float-center'>";
      
      if($num_rows_dep == 5){ //min 5 units / page
        
        echo "<a class='text-muted' href='http://".$url_default."/backoffice.php?modal_deposits=".$mode_show."&".$mode_pg."&pg_dep=1'>1</a>";
      
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
            echo "<a id='pg-dep-".$pg_btn."' class='color-theme' href='http://".$url_default."/backoffice.php?modal_deposits=".$mode_show."&".$mode_pg."&pg_dep=".$pg_btn."' alt='page num'>< </a>";
          }
         
          if($pg_added <= $max_pgs_isset || $p <= 9){  
            echo "<a class='".$selected."' href='http://".$url_default."/backoffice.php?modal_deposits=".$mode_show."&".$mode_pg."&pg_dep=".$pg_num."'>".$pg_num." </a>";
            $pg_added++;
          }

          if($get_pg < 10 && $pg_added >= $max_pgs_isset || $p >= 9){
            
            if($get_pg != $max_pgs_isset){ 
              echo "<a id='pg-dep-".$pg_btn."' class='color-theme' href='http://".$url_default."/backoffice.php?modal_deposits=".$mode_show."&".$mode_pg."&pg_dep=".$pg_btn."' alt='page num'> ></a>";
            }

            break;

          }else if($get_pg >= 10 && $pg_added > $max_pgs_isset || $p >= 9){

            if($get_pg != $max_pgs_isset){ 
              echo "<a id='pg-dep-".$pg_btn."' class='color-theme' href='http://".$url_default."/backoffice.php?modal_deposits=".$mode_show."&".$mode_pg."&pg_dep=".$pg_btn."' alt='page num'> ></a>";
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
 <?php } ?>
<!-- -->
<script type="text/javascript">
$(document).ready(function() {
     
  if($(".lights").attr("id") == "#light"){
        
    $(".modal-content").removeClass("bg-dark");
    $(".modal-content").addClass("bg-light");
    $(".modal-content").removeClass("text-light");
    $(".modal-content").addClass("color-theme");

    $(".modal-depinv .modal-header").addClass("bg-theme");
    $(".modal-depinv .modal-title").addClass("text-light");

  }else{

    $(".modal-content").removeClass("bg-light");
    $(".modal-content").addClass("bg-dark");
    $(".modal-content").removeClass("color-theme");
    $(".modal-content").addClass("text-light");

    $(".modal-depinv .modal-header").addClass("bg-theme");
    $(".modal-depinv .modal-title").addClass("text-light");

  }

  $(".prot").on('click', function(){
      
    count_length = $(".prot").length;
  
    for(var count = 0; count < count_length+1; count++){
 
      $(".prot:eq("+count+")").removeClass("bg-theme");      
      $(".prot:eq("+count+") a").removeClass("text-light");
      $(".prot:eq("+count+") a").addClass("color-theme");
    
      if($(this).attr("id") == $(".prot:eq("+count+") a").attr("title")){
      
        $(".prot:eq("+count+")").addClass("bg-theme");     
        $(".prot:eq("+count+") a").removeClass("color-theme");      
        $(".prot:eq("+count+") a").addClass("text-light");  
        $(".formdepositar .form-group:eq(4)").show();

      }

    }
 
  });

});
</script>

<!-- start modal buy packages -->
<div class="modal modal-depositar <?php text_color(); ?> mdp" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="top: 0px !important;">
    <div class="modal-content modal-contentp">
      <div class="modal-header">
        <h5 class="modal-title text-light" align="center">Make a deposit</h5>
        <i class="fa-depm-exclamation fa fa-question" aria-hidden="true"></i>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="top10" class="modal-body mbs">
        <form method="post" name="formlogin" class="formdepositar">
          <div class="form-group">
            <label for="formGroupExampleInput1">User info</label>
            <input type="email" class="form-control color-theme nome-user" value="<?php nome(); ?>" name="nome-user" id="nome-user" disabled>
          </div>
          <div class="form-group"> 
            <input type="email" class="form-control text-success email-user" value="<?php email(); ?>" name="email-user" id="email-user" disabled style="display: none;">
          </div>
          <div class="form-group" style="display: none;"> 
            <input type="typed" class="form-control text-success typed-user" value="deposit" name="dep-user-type" id="dep-type" disabled>
          </div>
          <div class="form-group"> 
            <label>Select coin for deposit</label>
            <nav class="nav nav-select-dep">
              <ul class="container-fluid">
                <li class="nav-item choose-coin-dep">
                  <a class="nav-link bgm" href="#usdt"><img class='img-action-sm'src='images/coins/usdt-sm.png' title='usdt' width='22px' height='22px' alt='usdt coin'></a>
                </li>
                <li class="nav-item choose-coin-dep">
                  <a class="nav-link bgm" href="#btc"><img class='img-action-sm'src='images/coins/btc-sm.png' title='btc' width='22px' height='22px' alt='btc coin'></a>
                </li>
                <li class="nav-item choose-coin-dep">
                  <a class="nav-link bgm" href="#eth"><img class='img-action-sm'src='images/coins/eth-sm.png' title='eth' width='22px' height='22px' alt='eth coin'></a>
                </li>
                 <li class="nav-item choose-coin-dep">
                  <a class="nav-link bgm" href="#ltc"><img class='img-action-sm'src='images/coins/ltc-sm.png' title='ltc' width='22px' height='22px' alt='ltc coin'></a>
                </li>
                <li class="nav-item choose-coin-dep">
                  <a class="nav-link bgm" href="#tron"><img class='img-action-sm'src='images/coins/trx-sm.png' title='trx' width='22px' height='22px' alt='busd coin'></a>
                </li>
                <li class="nav-item choose-coin-dep">
                  <a class="nav-link bgm" href="#pix-nubank"><img class='img-action-sm'src='images/coins/pix.png' title='pix' width='22px' height='22px' alt='pix'></a>
                </li>
              </ul>
            </nav>
            <ul id="list_prot">
              <li class='prot' id='btc'><a class="color-theme" href='#btc' title='btc'>btc</a></li>
              <li class='prot' id='btc-bep20'><a class="color-theme" href='#btc' title='btc-bep20'>btc-bep20</a></li>
              <li class='prot' id='segwit'><a class="color-theme" href='#btc' title='segwit'>segwit</a></li>
              <li class='prot' id='eth-erc20'><a class="color-theme" href='#eth' title='eth-erc20'>eth-erc20</a></li>
              <li class='prot' id='eth-bep20'><a class="color-theme" href='#eth' title='eth-bep20'>eth-bep20</a></li>
              <li class='prot' id='arbitrum'><a class="color-theme" href='#eth' title='arbitrum'>arbitrum</a></li>
              <li class='prot' id='avaxc'><a class="color-theme" href='#eth' title='avaxc'>avaxc</a></li>
              <li class='prot' id='trx-trc20'><a class="color-theme" href='#tron' title='trx-trc20'>trx-trc20</a></li>
              <li class='prot' id='trx-bep20'><a class="color-theme" href='#tron' title='trx-bep20'></a></li>
              <li class='prot' id='ltc'><a class="color-theme" href='#ltc' title='ltc'>ltc</a></li>
              <li class='prot' id='ltc-bep20'><a class="color-theme" href='#ltc' title='ltc-bep20'>ltc-bep20</a></li>
              <li class='prot' id='bnb-bep20'><a class="color-theme" href='#bnb' title='bnb-bep20'>bnb-bep20</a></li>
              <li class='prot' id='tether-erc20'><a class="color-theme" href='#usdt' title='tether-erc20'>tether-erc20</a></li>
              <li class='prot' id='tether-bep20'><a class="color-theme" href='#usdt' title='tether-bep20'>tether-bep20</a></li>
              <li class='prot' id='arbitrum'><a class="color-theme" href='#usdt' title='arbitrum'>arbitrum</a></li>
              <li class='prot' id='avaxc'><a class="color-theme" href='#usdt' title='avaxc'>avaxc</a></li>
              <li class='prot' id='pix-nubank'><a class="color-theme" href='#pix-nubank' title='pix-nubank'>pix-nubank</a></li>
            </ul>
          </div>
          <div class="form-group display-none">
            <label>Amount of investment</label>
            <input type="text" class="form-control text-success selected_plan float-right" name="plan-dep" id="plan_selected" value="buy-package" style="display: none;">
            <input type="text" class="form-control text-success selected_coin float-right" name="coin-dep" id="coin_selected" style="display: none;">
            <input type="text" class="form-control color-theme deposito-user float-right" name="deposito-user" id="deposito-user" placeholder="Amount in $">
            <div class="row">
              <span class="plan-deposit-mt-2">Total account: <p class="cv text-muted total-acc-user" style="display: inline-block;"><?php total_acc_user_txt(); ?></p> <i class="fa fa-balance-scale fa-1x text-muted" aria-hidden="true"></i>
              </span>
            </div>
            <div class="return-deposito text-center"></div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="confirm-here-dep" class="btn bg-theme text-light concluir-deposito float-right">Confirm here</button>  
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  
</style>
<!-- end modal buy packages -->
