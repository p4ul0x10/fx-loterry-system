<?php 
/*echo "Acesso direto: 10"; ?>
<?php echo "Total usuarios registrados: 10"; ?>
<?php echo "Total usuarios ativos: 10"; ?>
<?php echo "Total depositado: 10"; ?>
<?php echo "Total withdraw: 10"; ?>
<?php echo "Total earn: 10"; */
ini_set( 'display_errors', 0);

include "../conn.php";
include "analitics/functions.php";

session_start();

$email = $_SESSION['email'];

$get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
$array_user = mysqli_fetch_array($get_user);
$leader_nome = $array_user['f_nome'];
$idu = $array_user['id'];

$array_direct_id_user = array();
$array_direct_data = array();

$id_user_main = $array_user['id'];
$check_filter_month = mysqli_query($con, "SELECT * FROM sets_ref_analitics WHERE id_user ='$id_user_main'");

$month_add = date("m");
$year = date("Y");

$month_current = $month_add;
$year_current = $year;

$wd_window = $_POST['wd_window'];
$ht_window = $_POST['ht_window'];

mysqli_query($con, "UPDATE user_config SET window_w_gp = '$wd_window', window_h_gp = '$ht_window' WHERE id_user = '$idu'");

?> 
<style>
    .ml-graph { margin-left: 7% !important; }
    .ml-graph-min-0 { margin-left: 7% !important; }
    .ml-graph-min-m { margin-left: 7% !important; }
    .ml-graph-bar { margin: 0px 2px !important; }
    .graph-r { float: right; }
    .graph-l { float: left; }
    .pointer-events-none { pointer-events: none; }
    .touch-action-none { touch-action: none; }
    .pointer-events-init { pointer-events: initial; }
    .touch-action-init { touch-action: initial; }
</style>
<script type="text/javascript">

$(document).ready(function(){
    
    $(".max-limit-graph").on("click", function(){

        str = $(this).attr("id");
        str_by = str.charAt(0)+""+str.charAt(1);
        
        if(str_by == "ad"){
            
            idx = parseFloat(str.replace("ad-","")) - parseFloat(1);
            if($(".dl-ad:eq("+idx+")").attr("class") == "dl-ad bg-theme text-light"){
                $(".dl-ad:eq("+idx+")").removeClass("bg-theme");
                $(".dl-ad:eq("+idx+")").removeClass("text-light");
            }else{
                $(".dl-ad:eq("+idx+")").addClass("bg-theme");
                $(".dl-ad:eq("+idx+")").addClass("text-light");
            }

        }else if(str_by == "ua"){
            
            idx = parseFloat(str.replace("ua-","")) - parseFloat(1);
            if($(".dl-ua:eq("+idx+")").attr("class") == "dl-ua bg-theme text-light"){
                $(".dl-ua:eq("+idx+")").removeClass("bg-theme");
                $(".dl-ua:eq("+idx+")").removeClass("text-light");
            }else{
                $(".dl-ua:eq("+idx+")").addClass("bg-theme");
                $(".dl-ua:eq("+idx+")").addClass("text-light");
            }
            
        }else if(str_by == "ur"){
            
            idx = parseFloat(str.replace("ur-","")) - parseFloat(1);
            if($(".dl-ur:eq("+idx+")").attr("class") == "dl-ur bg-theme text-light"){
                $(".dl-ur:eq("+idx+")").removeClass("bg-theme");
                $(".dl-ur:eq("+idx+")").removeClass("text-light");
            }else{
                $(".dl-ur:eq("+idx+")").addClass("bg-theme");
                $(".dl-ur:eq("+idx+")").addClass("text-light");
            }
            
        }else if(str_by == "tw"){

            idx = parseFloat(str.replace("tw-","")) - parseFloat(1);
            if($(".dl-tw:eq("+idx+")").attr("class") == "dl-tw bg-theme text-light"){
                $(".dl-tw:eq("+idx+")").removeClass("bg-theme");
                $(".dl-tw:eq("+idx+")").removeClass("text-light");
            }else{
                $(".dl-tw:eq("+idx+")").addClass("bg-theme");
                $(".dl-tw:eq("+idx+")").addClass("text-light");
            }
        
        }else if(str_by == "td"){

            idx = parseFloat(str.replace("td-","")) - parseFloat(1);
            if($(".dl-td:eq("+idx+")").attr("class") == "dl-td bg-theme text-light"){
                $(".dl-td:eq("+idx+")").removeClass("bg-theme");
                $(".dl-td:eq("+idx+")").removeClass("text-light");
            }else{
                $(".dl-td:eq("+idx+")").addClass("bg-theme");
                $(".dl-td:eq("+idx+")").addClass("text-light");
            }

        }
    
    });

    $(".select-fa-y").on("change", function(){

        selected_id = $(this).attr("id");
        str_selected_id = selected_id.replace("slct-fa-y-", "");
        str_year_id = "slct-fa-m-"+str_selected_id;
        $("#"+str_year_id).attr("disabled", false);

        selected_id = $(this).attr("id");
        selected_y = $(this).val();

        str_selected_y = selected_y.replace("fa-y", "");
        
        $("#d"+str_selected_id).text("01/"+str_selected_y);
        analitics_select_data(str_selected_id, 1, str_selected_y);

        selectors = '<div class="col-2 float-left" onclick="att_pg('+str_selected_id+'001);"><i id="l" class="l1fa max-limit-graphl fa fa-2x fa-angle-left float-left" aria-hidden="true"></i></div><div class="col-2 float-right" onclick="att_pg('+str_selected_id+'001);" style="margin: 0px auto;"><i id="r" class="r1fa max-limit-graphr fa fa-2x fa-angle-right float-right" aria-hidden="true"></i></div>';
        $("#f"+str_selected_id+" .col-12:eq(0)").html(selectors);
        
        str_param_att_pg = str_selected_id+"001";
        att_pg(str_param_att_pg);
        
    });

    $(".select-fa-m").on("change", function(){
        
        m_selected = $(this).val();
        str_m_selected = m_selected.replace("fa-m", "");

        selected_id = $(this).attr("id");
        str_selected_id = selected_id.replace("slct-fa-m-", "");
        selected_id_idx = parseFloat(str_selected_id) - parseFloat(1);

        selectors = '<div class="col-2 float-left" onclick="att_pg('+str_selected_id+'00'+str_m_selected+');"><i id="l" class="l1fa max-limit-graphl fa fa-2x fa-angle-left float-left" aria-hidden="true"></i></div><div class="col-2 float-right" onclick="att_pg('+str_selected_id+'00'+str_m_selected+');" style="margin: 0px auto;"><i id="r" class="r1fa max-limit-graphr fa fa-2x fa-angle-right float-right" aria-hidden="true"></i></div>';
        
        $("#f"+str_selected_id+" .col-12:eq(0)").html(selectors);

        $(".select-fa-y:eq("+selected_id_idx+") option").each(function(){
        
            if($(this).prop("selected") == true){ 
               
                str_val_selected = $(this).val(); 
                str_fa_y = parseFloat(str_val_selected.replace("fa-y", ""));
                
                if(str_m_selected < 10){
                    $("#d"+str_selected_id).text("0"+str_m_selected+"/"+str_fa_y);        
                }else{
                    $("#d"+str_selected_id).text(str_m_selected+"/"+str_fa_y);        
                }
            
            }
        
        });

        str_param_att_pg = str_selected_id+"00"+str_m_selected;
        att_pg(str_param_att_pg);            
    
    });

});

function show_dad(id) {

    l_sd = $(".dl-ad").length;

    for (var i = 0; i < l_sd; i++) {
        
        if($(".dl-ad:eq("+i+")").attr("class") == "dl-ad bg-theme"){ 

            $(".dl-ad:eq("+i+")").removeClass("bg-theme");
            $(".dl-ad:eq("+i+")").removeClass("text-light");

            $(".dl-ad:eq("+i+") p a").removeClass("text-light");
            $(".dl-ad:eq("+i+") p a").addClass("color-theme");

        }
    
    }
    
    $(".dl-ad:eq("+id+")").addClass("bg-theme");
    $(".dl-ad:eq("+id+") p a").addClass("text-light");
    $(".dl-ad:eq("+id+") p a").removeClass("color-theme");
    
}

function show_dur(id) {
    
    l_sd = $(".dl-ur").length;

    for (var i = 0; i < l_sd; i++) {
    
        if($(".dl-ur:eq("+i+")").attr("class") == "dl-ur bg-theme"){

            $(".dl-ur:eq("+i+")").removeClass("bg-theme");
            $(".dl-ur:eq("+i+")").removeClass("text-light");

            $(".dl-ur:eq("+i+") p a").removeClass("text-light");
            $(".dl-ur:eq("+i+") p a").addClass("color-theme");

        }
    
    }
        
   $(".dl-ur:eq("+id+")").addClass("bg-theme");
   $(".dl-ur:eq("+id+") p a").addClass("text-light");
   $(".dl-ur:eq("+id+") p a").removeClass("color-theme");
    
}

function show_dua(id) {
    
    l_sd = $(".dl-ua").length;

    for (var i = 0; i < l_sd; i++) {
    
        if($(".dl-ua:eq("+i+")").attr("class") == "dl-ua bg-theme"){

            $(".dl-ua:eq("+i+")").removeClass("bg-theme");
            $(".dl-ua:eq("+i+")").removeClass("text-light");

            $(".dl-ua:eq("+i+") p a").removeClass("text-light");
            $(".dl-ua:eq("+i+") p a").addClass("color-theme");

        }
    
    }
        
   $(".dl-ua:eq("+id+")").addClass("bg-theme");
   $(".dl-ua:eq("+id+") p a").addClass("text-light");
   $(".dl-ua:eq("+id+") p a").removeClass("color-theme");

}

function show_dtw(id) {
    
    l_sd = $(".dl-tw").length;

    for (var i = 0; i < l_sd; i++) {
    
        if($(".dl-tw:eq("+i+")").attr("class") == "dl-tw bg-theme"){

            $(".dl-tw:eq("+i+")").removeClass("bg-theme");
            $(".dl-tw:eq("+i+")").removeClass("text-light");

            $(".dl-tw:eq("+i+") p a").removeClass("text-light");
            $(".dl-tw:eq("+i+") p a").addClass("color-theme");

        }
    
    }
        
   $(".dl-tw:eq("+id+")").addClass("bg-theme");
   $(".dl-tw:eq("+id+") p a").addClass("text-light");
   $(".dl-tw:eq("+id+") p a").removeClass("color-theme");

}

function show_dtd(id) {
    
    l_sd = $(".dl-td").length;

    for (var i = 0; i < l_sd; i++) {
    
        if($(".dl-td:eq("+i+")").attr("class") == "dl-td bg-theme"){

            $(".dl-td:eq("+i+")").removeClass("bg-theme");
            $(".dl-td:eq("+i+")").removeClass("text-light");

            $(".dl-td:eq("+i+") p a").removeClass("text-light");
            $(".dl-td:eq("+i+") p a").addClass("color-theme");
        
        }
    
    }
        
   $(".dl-td:eq("+id+")").addClass("bg-theme");
   $(".dl-td:eq("+id+") p a").addClass("text-light");
   $(".dl-td:eq("+id+") p a").removeClass("color-theme");

}

function att_pg(filter) {
    
    str_filter = ""+filter+"";
    analitics = str_filter.substr(0, 1);

    str_m = $("#d"+analitics).text();
    str_month0 = str_m.charAt(0);
    str_month1 = str_m.charAt(1);

    str_month = str_month0+""+str_month1;

    str_m_type = str_filter.charAt(1);
    str_method = str_filter.substr(0, 2);

    current_filter = str_filter.charAt(0);
    current_year = $("#d"+current_filter).text();
    
    str_cy3 = current_year.charAt(3);
    str_cy4 = current_year.charAt(4);
    str_cy5 = current_year.charAt(5);
    str_cy6 = current_year.charAt(6);

    str_cy = str_cy3+""+str_cy4+""+str_cy5+""+str_cy6;
    att_acy = str_cy;

    wd_col = $(".align-graph div:eq(2)").width();
    wd = window.innerWidth;

    if(analitics != 2){
        
        $("#f"+analitics+" .col-12:eq(0)").addClass("pointer-events-none"); //remove event click
        $("#f"+analitics+" .col-12:eq(0)").addClass("touch-action-none"); //remove event click

        $("#f"+analitics+" .col-12:eq(0)").removeClass("pointer-events-init"); //remove add event click
        $("#f"+analitics+" .col-12:eq(0)").removeClass("touch-action-init"); //remove add event click

    }

    $.post('php/ref/att_analitics.php', {"analitics":analitics, "filter":str_method, "month":str_month, "cyear":att_acy, "wd_col":wd_col, "wd": wd}).done(function(data) {
        
        filter = str_method+""+str_month;
        str_method1 = filter.substr(1, 1);

        if(str_method1 == 1){

            new_value = str_month;
            add_value = parseFloat(new_value) - parseFloat(1);
            
            new_value = add_value;

            if(add_value < 10){
                new_value = add_value;
            }
            
            if(add_value < 1){
                new_value = "12";
            }

            add_new_id = str_method+""+new_value;

        }else if(str_method1 == 2){

            new_value = str_month;
            add_value = parseFloat(new_value) + parseFloat(1);
            
            new_value = add_value;

            if(add_value < 10){
                new_value = add_value;
            }

            if(add_value > 12){
                new_value = "1";
            }
            
            add_new_id = str_method+""+new_value;

        }else{

            if(str_month < 10){
                new_value = str_month.replace("0", "");
            }else{
                new_value = str_month;
            }
            
            //new_value = 1;
            add_value = 2;
        }
        
        current_filter = filter.charAt(0);
        current_year = $("#d"+current_filter).text();
        
        str_cy3 = current_year.charAt(3);
        str_cy4 = current_year.charAt(4);
        str_cy5 = current_year.charAt(5);
        str_cy6 = current_year.charAt(6);

        str_cy = str_cy3+""+str_cy4+""+str_cy5+""+str_cy6;

        if(add_value < 1){ //dec

            att_cy = parseFloat(str_cy) - parseFloat(1);
        
        }else if(add_value > 12){ //inc
        
            att_cy = parseFloat(str_cy) + parseFloat(1);
        
        }else{

            att_cy = str_cy;
        }

        if(data != "" && data != "offdata"){

            if(data != ""){
                
                $("#f"+analitics).html("");
                $("#f"+analitics).html(data);           
            
            }
            
            $("#f"+analitics).attr("id", "f"+analitics);
            
        }
        
        if(wd < 1050){
            $(".net-resources:eq(0)").attr("id", "net-mobile");
            $(".mf").attr("id", "mf0");
        }else{
            $(".net-resources:eq(0)").attr("id", "net-desktop");    
            $(".mf").attr("id", "mf0");
            $(".align-graph div:eq(2)").css({"margin": "0px auto"});   
        }

        ajust_display(analitics);
        analitics_select_data(analitics, new_value, att_cy);

    });
    
    $(".net-resources:eq(0)").attr("id", "net-reload");
    $("#box-menu").addClass("bg-theme");

}

function analitics_select_data(dv_num, m, y){

    dv1 = '<div class="bs-bars float-right">';
    dv2 = '<select class="form-control select-fa-m">';

    dv3 = '</select>';
    dv4 = '</div>';

    ptm = "";

    ar_month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    str_month = m;

    for (var i = 1; i <= 12; i++){

        ii = i;

        if(str_month == ii){
           
            if(str_month != 0){
                ptm += '<option value="fa-m'+i+'" selected>'+ar_month[i-1]+'</option>';            
            }
        
        }

        if(str_month != ii){
        
            if(str_month != 0){
                ptm += '<option value="fa-m'+i+'">'+ar_month[i-1]+'</option>';
            }

        }

    }        

    num_dv_num = parseFloat(dv_num) - parseFloat(1);

    if(str_month < 10){
        m_month = "0"+""+str_month; 
    }else{
        m_month = str_month;
    }

    dv5 = '<div class="float-right search btn-group ml-1">';
    dv6 = '<select class="form-control select-fa-y">';

    dv7 = '</select>';
    dv8 = '</div>';

    pty = "";
    
    year_system = <?php echo date("Y"); ?>;
    year_init_server = <?php echo get_server_init_year($con); ?>;
    year_current = y;

    dec_years = (parseFloat(year_system) - parseFloat(year_init_server)) + parseFloat(1);

    for(var i = 1; i <= dec_years; i++){
        
        add_cont_year = parseFloat(year_init_server) + (parseFloat(i) - parseFloat(1));

        if(i == 1){
        
            if(year_init_server == year_current){

                pty += '<option value="fa-y'+year_current+'" selected>'+year_current+'</option>';

            }else{

                pty += '<option value="fa-y'+add_cont_year+'">'+add_cont_year+'</option>';

            }

        }else if(i != 1){
    
            if(year_current == add_cont_year){

                pty += '<option value="fa-y'+year_current+'" selected>'+year_current+'</option>';

            }else{
            
                pty += '<option value="fa-y'+add_cont_year+'">'+add_cont_year+'</option>';
            
            }

        }

    }                  
    
    //console.log(year_init_server+" "+year_system+" "+year_current);
    
    df_0 = parseFloat(year_current) - parseFloat(year_init_server);
    df_1 = parseFloat(year_system) - parseFloat(year_current);

    if(df_0 >= 0 && df_1 >= 0){
        
        $("#d"+dv_num).text(m_month+"/"+y);
        $(".select-fa-m:eq("+num_dv_num+")").html(dv1+""+dv2+""+ptm+""+dv3+""+dv4);
        $(".select-fa-y:eq("+num_dv_num+")").html(dv5+""+dv6+""+pty+""+dv7+""+dv8);

    }

}

function loop_render_margin(wd, ht) {
    
    for (var i = 0; i <= 30; i++) {

        rest_div = $(".max-limit-graph:eq("+i+")").text();
        
        //start tablet smartphone

        if(wd > 480 && wd < 1050){
            
            if(rest_div % 2 == 0){
                $(".max-limit-graph:eq("+i+")").css({"width": "50%"});
            }else{
                $(".max-limit-graph:eq("+i+")").css({"width": "50%"});
            }

        }

        if(wd < 480){

            if(rest_div % 2 == 0){
                $(".max-limit-graph:eq("+i+")").css({"width": "50%"});
            }else{
                $(".max-limit-graph:eq("+i+")").css({"width": "50%"});
            }

        }

        //end
    }

}

function ajust_display(analitics) {

    setTimeout(function(){
 
        $("#box-menu").removeClass("bg-theme");
        $(".ref-analitics-top").removeClass("bg-theme");
        $(".ref-analitics-top").css({"display":"block"});

        if(analitics != 2){
            
            if(analitics > 0){    
        
                $("#f"+analitics+" .col-12:eq(0)").addClass("pointer-events-init"); //add event click
                $("#f"+analitics+" .col-12:eq(0)").addClass("touch-action-init"); //add event click

                $("#f"+analitics+" .col-12:eq(0)").removeClass("pointer-events-none"); //remove event click
                $("#f"+analitics+" .col-12:eq(0)").removeClass("touch-action-none"); //remove event click
        
            }else if(analitics == 0){

                for(var i = 0; i < 6; i++) {
                    
                    f_idx = parseFloat(i) + parseFloat(1);
                
                    $("#f"+f_idx+" .col-12:eq(0)").addClass("pointer-events-init"); //add event click
                    $("#f"+f_idx+" .col-12:eq(0)").addClass("touch-action-init"); //add event click

                    $("#f"+f_idx+" .col-12:eq(0)").removeClass("pointer-events-none"); //remove event click
                    $("#f"+f_idx+" .col-12:eq(0)").removeClass("touch-action-none"); //remove event click

                }

            }   
        
        }

    }, 1000);

}

//start change analitics section
ajust_display(0);
//end

//start get / set height device
if(location.href.indexOf("hgt") < 0){
    
    ht = $("body").height(); //window.innerHeight;
    
    window.history.replaceState(null, "", location.href+"&hgt="+ht);
    
    if($(".mf").attr("id") == "mf0"){
        //$(".mf").attr("id", "mf2");
    }

}
//end
</script>
<div class="row">
    <h2 class="net-resources float-left h2 color-theme mt-3 ml-3">Analitics</h2>
</div>
<div class="fluid-container ref-analitics-top bg-theme mt-5" style="display:none;">
    <?php for ($i = 0; $i < 6; $i++) { 
    
    $num = $i + 1;
    $fmode = "f".$num;

    if($num == 1){
        $analitics_mode_title = "Direct access";
    }else if($num == 2){
        $analitics_mode_title = "Access by country";
    }else if($num == 3){
        $analitics_mode_title = "Registered users";
    }else if($num == 4){
        $analitics_mode_title = "Active users";
    }else if($num == 5){
        $analitics_mode_title = "Total withdraw";
    }else if($num == 6){
        $analitics_mode_title = "Total deposit";
    }
    ?>

    <div class="gp-col-6 col-md-12 float-left">
        <h3 class="color-theme"><?php echo $analitics_mode_title; ?></h3>  
        <?php if($num != 0){ ?>
        <div class="fixed-table-toolbar mt-3">     
            <div class="analitics-select-data columns columns-right btn-group float-right mb-3">
                <div class="bs-bars float-right">
                    <select id="slct-fa-m-<?php echo $num; ?>" class="form-control select-fa-m" disabled>
                        <?php show_option_month($month_current); ?>
                    </select>
                </div>
                <div class="float-right search btn-group ml-1">
                    <select id="slct-fa-y-<?php echo $num; ?>" class="form-control select-fa-y">
                        <?php show_option_year($con, $year_current); ?>
                    </select>
                </div>
            </div>
        </div>
        <small id="d<?php echo $num; ?>" class="float-right small-dt text-muted lt-dt-selected"><?php echo $month_current."/".date("Y"); ?></small>
        <?php } ?>                        
        <div id="f<?php echo $num; ?>" class="<?php if($num != 2){ echo 'row align-graph'; }else{ echo 'nav-flags-analitics nav nav-country align-graph'; } ?>" style="position: relative; top: 22px; overflow-y: hidden;">
            <?php $yy = date("Y"); analitics_graph($con, $fmode, $leader_nome, $month_current, $yy, 0, $idu); ?>
        </div>
    </div>
    <?php } ?>
</div>
