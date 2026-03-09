<?php 
   
    //start
    function get_server_init_year($con){
        
        $get_info_server = mysqli_query($con, "SELECT * FROM info WHERE id = '1'");
        $ar_info_server = mysqli_fetch_array($get_info_server);
        $out = $ar_info_server['ini_year'];

        return $out;

    }
    //end

    //start
    function show_option_month($month_current){

        $ar_month = array("1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");
    
        for ($i = 1; $i <= 12; $i++) { 
            
            if($month_current < 10){

                $str_month = $month_current;
                $str_i = "0".$i;
            
            }else{
            
                $str_month = $month_current;
                $str_i = $i;
            
            }

            if($str_i == $str_month){

                echo '<option value="fa-m'.$i.'" selected>'.$ar_month[$i].'</option>';

            }else{

                echo '<option value="fa-m'.$i.'">'.$ar_month[$i].'</option>';

            }   
        
        }
   
    }
    //end 

    //start
    function show_option_year($con){

        $year_system = date('Y');
    
        $init_year = get_server_init_year($con);
        
        $ini_server_data = $init_year;
        $dec_years = ($year_system - $ini_server_data) + 1;
    
        for ($i = 1; $i <= $dec_years; $i++) { 
            
            $add_cont_year = $ini_server_data + ($i - 1);
            
            if($i == 1){
            
                if($ini_server_data == $year_system){

                    echo '<option value="fa-y'.$year_system.'" selected>'.$year_system.'</option>';

                }else{

                    echo '<option value="fa-y'.$add_cont_year.'">'.$add_cont_year.'</option>';

                }

            }else if($i != 1){
        
                if($add_cont_year == $year_system){

                    echo '<option value="fa-y'.$year_system.'" selected>'.$year_system.'</option>';
                
                }else{

                    echo '<option value="fa-y'.$add_cont_year.'">'.$add_cont_year.'</option>';

                }

            }
        
        }

    }
    //end

    //start
    function analitics_days_show_desk($mode, $loop_month, $conv, $access_dm, $wd_win){

        if($mode == "f1"){
            $m_type = "dl-ad";
        }else if($mode == "f3"){
            $m_type = "dl-ur";
        }else if($mode == "f4"){
            $m_type = "dl-ua";
        }else if($mode == "f5"){
            $m_type = "dl-tw";
        }else if($mode == "f6"){
            $m_type = "dl-td";
        }

        if($wd_win < 1050){ $conv = "auto; float: left; height: 20px; margin: 0px 2px;"; }else{ $conv = $conv."% !important; text-align: center;"; }

        echo '<div class="graph-access-m graph-mg-d" id="'.$mode.'-'.$loop_month.'" style="width: '.$conv.'"><div class="'.$m_type.'" style="position: relative; top: 7px; width: 100%;"><p class="dl-text text-muted">'.$loop_month.': <a href="#" class="color-theme">'.$access_dm.'</a></p></div></div>';
    
    }
    //end

    //start
    function analitics_graph($con, $mode, $id_user, $leader, $month_current, $year_current, $wd_col){

        $count_rows = 0;
        $leader_nome = $leader;
        $array_direct_country = array();
        $array_direct_id_user = array();
        $array_direct_data = array();
        $array_country = array();

        $count_data = 0;
        $num_day = 0;
        $month = $month_current;
        
        $day = date("j");
        $array_day = array();
        $max_access_day = 0;
        $array_max_access_day = array();
        $array_country_access = array();
        $access = 1;
        $valid_access = "false";

        //start
        for($i=0; $i < 100; $i++) { 
            $array_direct_id_user[$i] = 0;
            $array_direct_data[$i] = 0;
            $array_country[$i] = 0;
        }
        //end
        
        //start
        if($mode == "f1"){

            $get_query = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome = '$leader_nome'");
            $count_mode = "1";
            $show_access = "show_dad"; 
        
        }else if($mode == "f2"){

            $cc = 0;
            $last = "null";
            $add = 1;
            $count_mode = "2";

            $get_query = mysqli_query($con, "SELECT * FROM direct_access_rl WHERE sponsor_nome = '$leader_nome'");
            
            if($row_direct_link = mysqli_affected_rows($con) >= 1){
                
                while($qarray_direct_link = mysqli_fetch_array($get_query)){
                    
                    $array_direct_data[$count_rows] = $qarray_direct_link['data'];      
                    $array_direct_country[$count_rows] = $qarray_direct_link['country'];
                    $count_rows++;
                
                }
            
                //start add country by month
                if($count_rows < 1){ exit(); }

                for ($i = 0; $i < $count_rows; $i++) { 

                    $array_country_access[$i] = 0;

                    if($last != $array_direct_country[$i]){ //check if country true || false for add
                            
                        for($ii = 0; $ii <= $cc; $ii++){

                            if($array_country[$ii] == $array_direct_country[$i]){ //country added previously
                                $add = 0; //no add 
                            }

                        }
                        
                        if($add == 1){ //add true

                            $array_m = $array_direct_data[$i][0]."".$array_direct_data[$i][1];  

                            if($month == $array_m){ 

                                $array_country[$cc] = $array_direct_country[$i];
                                $last = $array_direct_country[$i];
                                $cc++;

                            }

                        }
                        
                        $add = 1;
                    }
                    
                }
                //end add country by month

                //start add access num 
                $add_access = 0;
                
                for ($cf = 0; $cf < $cc; $cf++) { 
                    
                    for ($ca = 0; $ca < $count_rows; $ca++) { 
                
                        $madd = $array_direct_data[$ca][0]."".$array_direct_data[$ca][1];

                        if($array_country[$cf] == $array_direct_country[$ca] && $month == $madd){
                        
                            $array_country_access[$add_access] = $array_country_access[$add_access] + 1;
                    
                        }
                    
                    }

                    $add_access++;
                }
    
                $num_rows_flag = 0;
                //end add access num

                //start show country list
                echo '<div id="box-country" class="col-12 mb-5"><div class="col-2 float-left" onclick="att_pg(21'.$month_current.');"><i id="l" aria-hidden="true" class="col-2 fa fa-2x fa-angle-left color-theme float-left"></i></div>
                    <div class="col-2 float-right" onclick="att_pg(22'.$month_current.');"><i id="r" aria-hidden="true" style="float: right !important;" class="col-2 fa fa-2x fa-angle-right color-theme float-right"></i></div></div>';
                echo '<div class="col-10 mt-5" style="clear:both; margin: 0px auto;"><ul style="margin: 0px auto !important; display:inline-flex;"">';
   
                while ($num_rows_flag <= $add_access) {
                
                    $array_m = $array_direct_data[$num_rows_flag][0]."".$array_direct_data[$num_rows_flag][1];
                    if($array_country[$num_rows_flag] != ""){
                    
                        $flag = strtolower($array_country[$num_rows_flag]);
                        $access_per_country = $array_country_access[$num_rows_flag];
                        echo '<li class="nav-item text-muted"><a href="#"><img src="images/flags/'.$flag.'.svg" width="20" height="20"></a>&nbsp '.$access_per_country.' &nbsp</li>';  
                        
                    }
                    
                    $num_rows_end = $num_rows_flag % 7;

                    if($num_rows_flag != $add_access && $num_rows_flag > 0 && $num_rows_end == 0 || $num_rows_flag == $add_access && $num_rows_flag != $add_access) {
                        echo "</ul><ul>"; 
                    }

                    if($num_rows_flag == $add_access){
                        echo "<ul>";
                    }

                    $num_rows_flag++;

                }
                //end show country list
             echo '</div></div>';
            }
            
        }else if($mode == "f3"){
        
            $get_query = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$leader_nome' AND data LIKE '%$year_current%'");
            $count_mode = "3";
            $show_access = "show_dur"; 
        
        }else if($mode == "f4"){
        
            $get_query = mysqli_query($con, "SELECT * FROM data_dep_pay WHERE id > 0");
            $count_mode = "4";
            $show_access = "show_dua";
        
        }else if($mode == "f5"){
        
            $get_query = mysqli_query($con, "SELECT * FROM saque WHERE id > 0");
            $count_mode = "5";
            $show_access = "show_dtw";
        
        }else if($mode == "f6"){
        
            $get_query = mysqli_query($con, "SELECT * FROM deposits WHERE id > 0");
            $count_mode = "6";
            $show_access = "show_dtd";
        
        }
        //end 

        if($rget_query = mysqli_affected_rows($con) >= 1 && $mode != "f2"){
            
            while($qarray_direct_link = mysqli_fetch_array($get_query)){
                
                if($mode == "f1"){

                    $array_direct_data[$count_rows] = $qarray_direct_link['data'];      
                    $array_direct_country[$count_rows] = $qarray_direct_link['country'];
                
                }else if($mode == "f3"){
                
                    $array_direct_id_user[$count_rows] = $array_direct_id_user[$count_rows] + 1;
                    $array_direct_data[$count_rows] = $qarray_direct_link['data'];
                
                }else if($mode == "f4"){

                    $id_charnum = $qarray_direct_link['id_charnum'];
                    $cmp_id = mysqli_query($con, "SELECT * FROM rel_deposits WHERE id_charnum = '$id_charnum'");           
                    if($rcmp_id = mysqli_affected_rows($con) >= 1){    
                      
                        $array_id_user = mysqli_fetch_array($cmp_id);
                        $id_charnum_user = $array_id_user['id_dep'];
                    
                        $cmp_dep_id = mysqli_query($con, "SELECT * FROM deposits WHERE id = '$id_charnum_user'");
                        $array_dep_user = mysqli_fetch_array($cmp_dep_id);
                        $id_dep_user = $array_dep_user['id_user'];

                        $cmp_user = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_dep_user' AND sponsor = '$leader_nome'");

                        if($rows_user = mysqli_affected_rows($con) >= 1){

                            $array_user_data = mysqli_fetch_array($cmp_user);
                            $array_direct_id_user[$count_rows] = $array_direct_id_user[$count_rows] + 1;
                            $array_direct_data[$count_rows] = $array_user_data['data'];
                                        
                        }
                    
                    }

                }else if($mode == "f5"){

                    if($qarray_direct_link['status'] == "1"){

                        $id_charnum = $qarray_direct_link['id_user'];
                    
                        $cmp_user = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_charnum' AND sponsor = '$leader_nome'");

                        if($rows_user = mysqli_affected_rows($con) >= 1){

                            $array_direct_id_user[$count_rows] = $array_direct_id_user[$count_rows] + 1;
                            $array_direct_data[$count_rows] = $qarray_direct_link['data'];
                        
                        }
                    
                    }
                
                }else if($mode == "f6"){

                    if($qarray_direct_link['status'] == "1"){

                        $id_charnum = $qarray_direct_link['id_user'];
                    
                        $cmp_user = mysqli_query($con, "SELECT * FROM usuarios WHERE id = '$id_charnum' AND sponsor = '$leader_nome'");

                        if($rows_user = mysqli_affected_rows($con) >= 1){

                            $array_direct_id_user[$count_rows] = $array_direct_id_user[$count_rows] + 1;
                            $array_direct_data[$count_rows] = $qarray_direct_link['data'];
                    
                        }
                    
                    }
                
                }

                $count_rows++;

            }

            //start
            while($count_data < $count_rows){

                $str = $array_direct_data[$count_data][3];
                $array_m = $array_direct_data[$count_data][0]."".$array_direct_data[$count_data][1];
                $array_country_access[$count_data] = 0;
                
                //check if days == || !=
                if($array_direct_data[$count_data][3+1] == ","){ //check nums < 10

                    if($count_rows < 2 && $month == $array_m){
                    
                        $array_max_access_day[$max_access_day] = $access; //add +1 access per day
                        $array_day[$max_access_day] = $array_direct_data[$count_data][3];
                        $max_access_day++;
                        $valid_access = "true";

                    }else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3]){
                    
                        $array_max_access_day[$max_access_day] = $access; //add +1 access per day
                        $array_day[$max_access_day] = $array_direct_data[$count_data][3];

                        $access++;
                        $valid_access = "true";
                        
                    }else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3]){
                
                        $access = 1;        

                        if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3]){
                            
                            $array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
                            $valid_access = "true";
                            
                        }
                        
                        if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3]){
    
                            $array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
                            $valid_access = "true";

                        }

                        $array_day[$max_access_day] = $array_direct_data[$count_data][3];

                        $max_access_day++; //new count +1 day

                    }
                
                }else{ //check nums >= 10

                    if($count_rows < 2 && $month == $array_m){
                        
                        $array_max_access_day[$max_access_day] = $access; //add +1 access per day
                        $array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
                        $max_access_day++;

                    }else if($month == $array_m && $array_direct_data[$count_data][3] == $array_direct_data[$count_data+1][3] && $array_direct_data[$count_data][4] == $array_direct_data[$count_data+1][4]){
                    
                        $array_max_access_day[$max_access_day] = $access; //add +1 access per day
                        $array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
                        $valid_access = "true";
            
                        $access++;
            
                    }else if($month == $array_m && $array_direct_data[$count_data][3] != $array_direct_data[$count_data+1][3] || $month == $array_m && $array_direct_data[$count_data][4] != $array_direct_data[$count_data+1][4]){
                
                        $access = 1;        

                        if($array_direct_data[$count_data][3] != $array_direct_data[$count_data-1][3] && $array_direct_data[$count_data][4] != $array_direct_data[$count_data-1][4]){

                            $array_max_access_day[$max_access_day] = $access; // added 1 if value total < 2
                            $valid_access = "true";
                            
                        }
                        
                        if($array_direct_data[$count_data-1][3] == $array_direct_data[$count_data][3] && $array_direct_data[$count_data-1][4] == $array_direct_data[$count_data][4]){

                            $array_max_access_day[$max_access_day] = $array_max_access_day[$max_access_day] + 1; //+1 if current == old
                            $valid_access = "true";
   
                        }

                        $array_day[$max_access_day] = $array_direct_data[$count_data][3]."".$array_direct_data[$count_data][4];
                    
                        $max_access_day++; //new count +1 day
                      
                    }

                }
                
                $count_data++;
            
            }
            //end

            //start 
            $max = 0;
            $max_day = 0;
            
            while($max < $max_access_day){
                
                if($array_max_access_day[$max+1] >= 1){

                    if($max == 0 && $array_max_access_day[$max] >= $array_max_access_day[$max+1]){
                
                        $max_day = $array_max_access_day[$max];
                
                    }else if($max > 0 && $max_day < $array_max_access_day[$max+1]){
                
                        $max_day = $array_max_access_day[$max+1];
                
                    }
                
                }                   

                $max++;
            
            }
        
        }
        //end
     
        //start
        $get_user_config = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id_user'");
        $ar_get_user = mysqli_fetch_array($get_user_config);

        $wd_win = $ar_get_user['window_w_gp'];
        $ht_win = $ar_get_user['window_h_gp'];

        $loop_month = 1;
        $max_limit_loop = 31;
        $graph_p_count = 0;
        $run_loop = true;
        $added_day = 0;
            
        if($wd_win >= 250 && $wd_win < 1050){
            
            $box_graph_adds = " box-graph-tm";
            $align_div0 = " align-graph-zi-tm";
            $col_mt = "mt-3";
            $mt_ma = "mt-3 mb-3";
        
        }else if($wd_win >= 1050){
        
            $col_mt = "mt-4";
            $mt_ma = "mt-0";

        }

        if($mode != "f2"){
            
            echo '<div class="col-12 pointer-events-none touch-action-none">';
            echo '<div class="col-2 float-left" onclick="att_pg('.$count_mode.'1'.$month_current.');"><i id="l" class="l1fa max-limit-graphl fa fa-2x fa-angle-left float-left" aria-hidden="true"></i></div>';
            echo '<div class="col-2 float-right" onclick="att_pg('.$count_mode.'2'.$month_current.');"><i id="r" class="r1fa max-limit-graphr fa fa-2x fa-angle-right float-right" aria-hidden="true"></i></div>';
            echo '</div>';
            echo '<div class="col-12 box-graph '.$col_mt.' dsp-analitics"><div class="col-12 mb-1">';
         
            if($mode != "f2" && $valid_access == "true"){
        
                $div_wd = $wd_col / 31;
                $conv_wd = $div_wd / $wd_col * 100;
                $conv_wd_m = (0.021 / $conv_wd) * 100;
                $conv = $conv_wd - $conv_wd_m;

                while($loop_month <= $max_limit_loop) {
                    
                    //start < 1050 render sets          
                    $rest_div = $loop_month % 2;

                    if($rest_div == 0){
                        $graph_rl = "graph-r"; 
                        $text_align = 'text-align: right;';
                    }else{
                        $graph_rl = "graph-l";
                        $text_align = 'text-align: left;';                
                    }
                    
                    if($rest_div == 1 && $loop_month > 2){
                        $clear = "clear: both;";
                        $float_l = "float: left;";
                    }else{
                        $clear = "";
                    }
                    //end

                    if($array_max_access_day[$graph_p_count] > 0 && $array_day[$added_day] == $loop_month){

                        $graph_percent_show = ($array_max_access_day[$graph_p_count] / $max_day) * 100;

                        if($graph_percent_show > 100){
                            $graph_percent_show = 100;
                        }

                        $top = (100 - $graph_percent_show) + 0;
                        $day_added = $array_day[$added_day];
                        $loop_monthidx = $loop_month - 1;
                    
                        //start < 1050 sets
                        if($wd_win > 625){
                            $left_px = 6;
                        }else{
                            $left_px = 11;  
                        }
                        
                        $wd_ajust = $graph_percent_show - 15; //-15 ajust div wd
                                        
                        if($rest_div % 2 == 0){
                            $left_ajust = (100 - $wd_ajust) - $left_px; //-11 default margin
                        }else{
                            $left_ajust = $left_px; //default margin
                        }
                        //end

                        if($wd_win >= 1050){ //desktop render    
                            echo '<div class="bd max-limit-graph graph-mg-d" id="ad-'.$loop_month.'" onmouseenter="'.$show_access.'('.$loop_monthidx.');" style="width: '.$conv.'% !important; text-align: center;"><p class="graph-num">'.$loop_month.'</p><div class="bg-theme percent-col mt-1" title='.$array_max_access_day[$graph_p_count].' style="position: relative; top: '.$top.'%; width: 100%; height: '.$graph_percent_show.'%;"></div></div>';
                        }else{ // < desktop render
                            echo '<div class="bd max-limit-graph graph-tm-mg '.$graph_rl.'" id="ad-'.$loop_month.'" onmouseenter="'.$show_access.'('.$loop_monthidx.');" style="'.$clear.' width: 50% !important; height: 20px; '.$text_align.'"><p class="graph-num">'.$loop_month.'</p><div class="bg-theme percent-col" title='.$array_max_access_day[$graph_p_count].' style="position: relative; top: -14px; width: '.$wd_ajust.'%; height: 90%; left: '.$left_ajust.'%;"></div></div>';
                        }

                        $added_day++;
                        $graph_p_count++;

                    }else{

                        if($wd_win >= 1050){
                            echo '<div class="bd max-limit-graph graph-mg-d" style="width: '.$conv.'% !important; text-align: center;"><p class="graph-num">'.$loop_month.'</p></div>';
                        }else{
                            echo '<div class="bd max-limit-graph graph-tm-mg" style="'.$float_l.' width: 50% !important; height: 20px; '.$text_align.'"><p class="graph-num">'.$loop_month.'</p></div>';
                        }
                    
                    }

                    if($loop_month == 31){
                        echo '</div></div>';
                    }

                    $loop_month++;

                }

                echo '</div>';
                echo '<div class="col-12 box-graph '.$mt_ma.' dsp-analitics">';

                $loop_month = 1;
                $graph_p_count = 0;
                $added_day = 0;

                while($loop_month <= $max_limit_loop){
                    
                    if($array_max_access_day[$graph_p_count] > 0 && $array_day[$added_day] == $loop_month){
                        
                        $access_dm = $array_max_access_day[$graph_p_count];
                        $added_day++;
                        $graph_p_count++;
                   
                    }else{

                        $access_dm = 0;

                    }
                    
                    analitics_days_show_desk($mode, $loop_month, $conv, $access_dm, $wd_win);
                    $loop_month++;

                }
            
            }  
             
            echo '</div></div>';
                    
        }
        
    }
    //end
?>