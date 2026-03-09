<?php
	ini_set( 'display_errors', 0);

	include_once "../conn.php";
	
	session_start();
	$user = $_SESSION['email'];
	$get_info = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$user'");
	$count = 1;

	$get_user = mysqli_fetch_array($get_info);
	$id = $get_user['id'];
	$count_ref_db = $get_user['total_ref'];

	$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");

	if($row_true = mysqli_affected_rows($con) >= 1){
	
		$get_user = mysqli_fetch_array($get_theme);

		$max_ipg = $get_user['lt_nipg'];
	
		if($get_user['conf_theme'] == "light" || $get_user['conf_theme'] == "default"){

			$table_color = "table-light";
			$text_color = "color-theme";
			$bg_theme = "bg-light";

		}else if($get_user['conf_theme'] == "dark"){
		
			$table_color = "table-dark";
			$text_color = "text-light";
			$bg_theme = "bg-dark";
		
		}
		
		$mtext_color = "text-muted";

	}
?>
<style>.fa-ref { height: 5px !important;
float: initial !important;
position: absolute !important;
margin: 5px 5px !important; }
@media only screen and  (max-device-width : 700px){
  .table-mobile-ref1 { position: relative !important; float: left !important; width: 100% !important; display: block !important; overflow-x: auto !important; }
  .filter-table-ref1 { position: relative !important; float: right !important; margin-right: 0% !important; }

}</style>
<script type="text/javascript" src="js/ref_script.js"></script>
<div class="fixed-table-toolbar mt-3 mb-3">
	<h2 class="net-resources float-left h2 color-theme">Referrals</h2>
	<div class="columns columns-right btn-group float-right mb-3">
  	<div class="bs-bars float-right">
  		<div id="toolbar-n">
		  	<select class="form-control select-n">
		    	<option value="fn-id">Id</option>
		    	<option value="fn-name">Name</option>
		    	<option value="fn-level">Level</option>
		    	<option value="fn-date">Date</option>
		    	<option value="fn-leader">Leader</option>
		    	<option value="fn-earns">Earns</option>
		    	<option value="fn-activity">Activity</option>
		  	</select>
		</div>
	</div>
	<div class="float-right search btn-group ml-1">
    <input class="form-control search-input sn" id="search-n" type="search" aria-label="Search" placeholder="Select type" autocomplete="off" disabled>
  </div>
</div>
<table id="box-menu-table" class="table table-striped <?php echo $table_color; ?> table-mobile-ref1 ref-table-top color-theme">
	<thead class="<?php echo $text_color; ?>">
    <tr>
      <th scope="col"><span class="filter-table-ref1">#<i id="rf1" class="fa fa-ref fa-sort-desc <?php echo $text_color; ?>" aria-hidden="true" onclick="ref_click(1);"></i></span>
			</th>
      <th scope="col">Name</th>
      <th scope="col"><span class="filter-table-ref1">Level<i id="rf2" class="fa fa-ref fa-sort-desc <?php echo $text_color; ?>" aria-hidden="true" onclick="ref_click(2);"></i></span></th>
      <th scope="col">Started</span></th>
      <th scope="col">Leader</th>
      <th>Status</th>
      <th><span class="filter-table-ref1">Earns<i id="rf4" class="fa fa-ref fa-sort-desc <?php echo $text_color; ?>" aria-hidden="true" onclick="ref_click(4);"></i></span>
      </th>
      <th><span class="filter-table-ref1">Activity<i id="rf5" class="fa fa-ref fa-sort-desc <?php echo $text_color; ?>" aria-hidden="true" onclick="ref_click(5);"></i></span>
      </th>
    </tr>
  </thead>
	<tbody class="tbodyref" style="max-height: 500px; overflow-y: auto;">
  	<?php 
  	
  	$get_rows_list = mysqli_query($con, "SELECT * FROM network_list WHERE leader_id ='$id'");
  	$num_net_rows = mysqli_num_rows($get_rows_list);

  	$get_net_list = mysqli_query($con, "SELECT * FROM network_list WHERE leader_id = '$id' ORDER BY id ASC LIMIT $max_ipg");
  	if($rtl = mysqli_affected_rows($con) >= 1){
		while ($array_network = mysqli_fetch_array($get_net_list)) { ?>
		<tr>
			<th scope="row">
				<a href="#pos_ref" class="id_ref <?php echo $mtext_color; ?>"><?php echo $count; ?></a>
			</th>
			<td>
				<a href="?ref_name=<?php echo $array_network['nome_ref']; ?>" class="name_ref <?php echo $text_color; ?>"><?php echo $array_network['nome_ref']; ?></a>
			</td>
			<td>
				<a href="#ref_level" class="level_ref <?php echo $mtext_color; ?>"><?php echo $array_network['level_ref']; ?></a>
			</td>
			<td>
				<a href="#ref_date" class="date_ref <?php echo $mtext_color; ?>"><?php echo $array_network['started_ref']; ?></a>
			</td>
			<td>
				<a href="#up_name_ref" class="up_ref <?php echo $text_color; ?>"> <?php echo $array_network['leader_ref']; ?></a>
			</td>
			<td>
				<a href="#status_ref" class="status_ref <?php echo $text_color; ?>"><?php echo $array_network['status_ref']; ?></a>
			</td>
			<td>
				<a href="?earns_ref=<?php echo $array_network['nome_ref']; ?>" class="cv earns_ref <?php echo $mtext_color; ?>"><?php echo $array_network['earns_ref']; ?></a>
			</td>
			<td>
				<a href="#actions" class="activity_ref <?php echo $mtext_color; ?>"><?php echo $array_network['activity_ref']; ?></a>
			</td>
		</tr>
		<?php	
		$count++;
		}    	

	} ?>
	</tbody>
</table>
<div class="fixed-table-pagination fixed-pagination-n" style="">
  <div class="float-left pagination-detail">
    <div class="page-list color-theme">Showing in 
      <div class="btn-group dropdown dropup nc">
        <button class="btn btn-secondary dropdown-toggle bg-theme" type="button" data-bs-toggle="dropdown" id="ndd" onclick="inif(id);">
          <span class="page-size page-size-n"><?php echo $get_user['lt_nipg']; ?></span>
        <span class="caret"></span>
        </button>
        <div class="dropdown-menu dropdown-menu-pg-n">
          <div class="dropdown-item page-nn" id="n10" onclick="inif(id)">10</div>
          <div class="dropdown-item page-nn" id="n25" onclick="inif(id)">25</div>
          <div class="dropdown-item page-nn" id="n50" onclick="inif(id)">50</div>
          <div class="dropdown-item page-nn" id="n100" onclick="inif(id)">100</div>
          <div class="dropdown-item page-nn" id="na<?php echo $num_net_rows; ?>" onclick="inif(id)">All</div>
        </div>
      </div> rows per page</div>
    </div>
    <div class="pg-n float-right pagination">
      <ul class="pagination">
      	<?php 
      	if($num_net_rows > $max_ipg){ //pgs found
      		
      		if($num_net_rows % $max_ipg == 0){ //exactly div

	          $div_nv_tw = $num_net_rows / $max_ipg; //qtd pgs
	 
	        }else{ //no exactly div

	          $div_nv_tw_no_exactly1 = $num_net_rows % $max_ipg;
	          $div_nv_tw = ($num_net_rows - $div_nv_tw_no_exactly) / $max_ipg; //qtd pgs
	        
	        } 
                       
      	}else{ //no pages found

          $div_nv_tw = 1;
        
      	}
      	?>
      	<li class="page-item page-pre">
        	<a class="ppage-nnn page-link bg-theme bc-theme text-light" aria-label="previous page" href="javascript:void(0)" id="n-prev-n" onclick="pgs(id)">‹</a>
        </li>	
        <?php
        for ($i = 0; $i < $div_nv_tw; $i++){ 
          $ii = $i + 1; 
        ?>
        <li class="page-item">
        <?php if($i == 0){ ?>
          <a id ="n<?php echo $ii; ?>" class="page-nnn page-link bc-theme color-theme <?php echo $bg_theme; ?>" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "n".$ii; ?>')"><?php echo $ii; ?></a>
          <?php }else{ ?>
          <a id ="n<?php echo $ii; ?>" class="page-nnn page-link bg-theme bc-theme text-light" aria-label="to page <?php echo $ii; ?>" href="javascript:void(0)" onclick="pgs('<?php echo "n".$ii; ?>')"><?php echo $ii; ?></a>
          <?php } ?>
        </li>  
        <?php } ?>	
      	<li class="page-item page-next">
        	<a class="npage-nnn page-link bg-theme bc-theme text-light" aria-label="next page" href="javascript:void(0)" id="n-next-n" onclick="pgs(id)">›</a>
      	</li>
    </ul>
    <?php 
		if($div_nv_tw_no_exactly){ $end_pg = $div_nv_tw + 1; }else{ $end_pg = $div_nv_tw; }
    mysqli_query($con, "UPDATE user_config SET i_pg_n = '1', e_pg_n = '$end_pg' WHERE id_user='$id'");
    ?>
  </div>
</div>
<script>
h = parseFloat($("body").height()) + parseFloat($(".table-mobile-ref1").height()) + parseFloat(250); 
$(".fix").css({"height":h+"px"});

$(".select-n").click(function() {

	$(".search-input").prop("disabled", false); 

  if($(this).val() == "fn-id"){
  	$("#search-n").attr("placeholder", "Choose a id");
  }else if($(this).val() == "fn-name"){
    $("#search-n").attr("placeholder", "Choose a name");
  }else if($(this).val() == "fn-level"){
    $("#search-n").attr("placeholder", "Choose a level");
  }else if($(this).val() == "fn-date"){
    $("#search-n").attr("placeholder", "Choose a date");
  }else if($(this).val() == "fn-leader"){
    $("#search-n").attr("placeholder", "Choose a leader");
  }else if($(this).val() == "fn-earns"){
    $("#search-n").attr("placeholder", "Amount of the earns");
  }else if($(this).val() == "fn-activity"){
    $("#search-n").attr("placeholder", "Amount of the activity");
  }

});

$("#search-n").keyup(function(){
	
	search = $(this).val();	
	search_type = $(this).attr("class");
	mode_search = $(".select-n").val();
	
	if(search != ""){

		$.post("php/search/search.php", {"search":search, "search_type":search_type, "mode_search":mode_search}, function(data){

			$("#box-menu-table tbody").children().remove();
			$("#box-menu-table tbody").html(data);

		});
	
	}else{
		
		$.post("php/search/return_net_table.php", {}, function(data){

			$(".tbodyref").html(data);

		});

	}

});
</script>