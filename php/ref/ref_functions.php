<?php 
function referrals_info(){

	include "php/conn.php"; 

	$user = $_SESSION['email'];
	$get_info = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$user'");
	$count = 1;

	echo "<style>.fa-ref { height: 5px !important;
float: initial !important;
position: absolute !important;
margin: 5px 5px !important; }
@media only screen and  (max-device-width : 700px){
  .table-mobile-ref1 { position: relative !important; float: left !important; width: 100% !important; display: block !important; overflow-x: auto !important; }
  .filter-table-ref1 { position: relative !important; float: right !important; margin-right: 0% !important; }

}</style>";
	echo '<script type="text/javascript" src="js/ref_script.js"></script>';
	echo '<h2 class="text-primary" style="display: none;">Network list</h2><table class="table table-striped table-mobile-ref1">
	      <thead>
	        <tr>
	          <th scope="col"><span class="filter-table-ref1">#<i id="rfm1" class="fa fa-ref fa-sort-desc text-light" aria-hidden="true" onclick="ref_clickm(1);"></i>
	</span>
	</th>
	          <th scope="col">Name</th>
	          <th scope="col"><span class="filter-table-ref1">Level<i id="rfm2" class="fa fa-ref fa-sort-desc text-light" aria-hidden="true" onclick="ref_clickm(2);"></i>
	</span></th>
	          <th scope="col">Started
	</span></th>
	          <th scope="col">Leader</th>
	          <th>Status</th>
	          <th><span class="filter-table-ref1">Earns<i id="rfm4" class="fa fa-ref fa-sort-desc text-light" aria-hidden="true" onclick="ref_clickm(4);"></i>
	</span></th>
	          <th><span class="filter-table-ref1">Activity<i id="rfm5" class="fa fa-ref fa-sort-desc text-light" aria-hidden="true" onclick="ref_clickm(5);"></i>
	</span></th>
	        </tr>
	      </thead><tbody>';

	if($rows_info = mysqli_affected_rows($con) >= 1){

		while ($ref_info = mysqli_fetch_array($get_info)) {
			
			$sponsor_main = $ref_info['f_nome'];
			$get_sponsor1 = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$sponsor_main'");
			
			if($rows_info3 = mysqli_affected_rows($con) >= 1){

				while($rows_info = mysqli_fetch_array($get_sponsor1)){
					
					$id3 = $rows_info['id'];
					$get_true_deposit = mysqli_query($con, "SELECT * FROM deposits WHERE status = '1' AND id_user = '$id3'");
					$deps3 = mysqli_affected_rows($con);

					if($deps3 >= 1){
					
						$get_sum = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE status = '1' AND id_user = '$id3'");
						$earns3 = 0;
						while ($get_dep3_bonus= mysqli_fetch_array($get_sum)) {
							
							$calc3 = ($get_dep3_bonus['quantidade'] / 100) * 3;
							$earns3 = $earns3 + number_format($calc3, 2, ".", "");
						}

						$status3 = "active";
						if($earns3 < "0.00000001"){
							echo "0.00";
						}

					}else{

						$status3 = "pending";
						$earns3 = "0.00";
					}
					
					echo '
          <tr>
            <th scope="row"><a href="#pos_ref" class="id_refm text-light">'.$count.'</a></th>
            <td><a href="#ref_name" class="name_refm color-theme">'.$rows_info['f_nome'].'</a></td>
            <td><a href="#ref_level" class="text-light level_refm">3</a></td>
            <td><a href="#ref_date" class="text-light date_refm">'.$rows_info['data'].'</a></td>
          	<td><a href="#up_name_ref" class="up_refm">'.$sponsor_main.'</a></td>
          	<td><a href="#status_ref" class="text-light status_refm">'.$status3.'</a></td>
          	<td><a href="#earns_ref" class="text-light earns_refm">'.$earns3.'</a></td>
          	<td><a href="#deposit_ref" class="text-light activity_refm">'.$deps3.'</a></td>
          </tr>'; 
	                
	        $count++; 
    			$sponsor_main3 = $rows_info['f_nome'];	

    			$get_sponsor2 = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$sponsor_main3'");
		
					if($rows_info2 = mysqli_affected_rows($con) >= 1){
						
						while ($ref_info = mysqli_fetch_array($get_sponsor2)) {

							$id2 = $ref_info['id'];
							$get_true_deposit = mysqli_query($con, "SELECT * FROM deposits WHERE status = '1' AND id_user = '$id2'");
							$deps2 = mysqli_affected_rows($con);

							if($deps2 >= 1){
							
								$get_sum = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE status = '1' AND id_user = '$id2'");
								$earns2 = 0;
								while ($get_dep2_bonus= mysqli_fetch_array($get_sum)) {

									$calc2 = ($get_dep2_bonus['quantidade'] / 100) * 2;
									$earns2 = $earns2 + number_format($calc2, 2, ".", "");
								}

								$status2 = "active";
								if($earns2 < "0.00000001"){
									echo "0.00";
								}
						
							}else{

								$status2 =  "pending";
								$earns2 = "0.00";
							}

							echo '
                <tr>
                  <th scope="row"><a href="#pos_ref" class="id_refm text-light">'.$count.'</a></th>
                  <td><a href="#ref_name" class="name_refm">'.$ref_info['f_nome'].'</a></td>
                  <td><a href="#ref_level" class="text-light level_refm">2</a></td>
                  <td><a href="#ref_date" class="text-light date_refm">'.$ref_info['data'].'</a></td>
                  <td><a href="#up_name_ref" class="up_refm">'.$sponsor_main3.'</a></td>
                  <td><a href="#status_ref" class="text-light status_refm">'.$status2.'</a></
                  td>
                  <td><a href="#earns_ref" class="text-light earns_refm">'.$earns2.'</a></td>
                	<td><a href="#deposit_ref" class="text-light activity_refm">'.$deps2.'</a></td>
                </tr>';
              $count++;	
							$sponsor_main2 = $ref_info['f_nome'];

							$get_sponsor1 = mysqli_query($con, "SELECT * FROM usuarios WHERE sponsor = '$sponsor_main2' ORDER BY id ASC LIMIT 1");
					
							if($rows_info1 = mysqli_affected_rows($con) >= 1){
								
								while ($ref_info = mysqli_fetch_array($get_sponsor1)) {

									$id1 = $ref_info['id'];
									$get_true_deposit = mysqli_query($con, "SELECT * FROM deposits WHERE status = '1' AND id_user = '$id1'");
									$deps1 = mysqli_affected_rows($con);

									if($deps1 >= 1){
									
										$get_sum = mysqli_query($con, "SELECT sum(quantidade)quantidade FROM deposits WHERE status = '1' AND id_user = '$id1'");
										
										while ($get_dep1_bonus= mysqli_fetch_array($get_sum)) {
											$calc1 = ($get_dep1_bonus['quantidade'] / 100) * 1;
											$earns1 = $earns1 + number_format($calc1, 2, ".", "");
										}

										$status1 =  "active";
										if($earns1 < "0.00000001"){
											echo "0.00";
										}
						
									}else{

										$status1 =  "pending";
										$earns1 = "0.00";
									}

									echo '
                  <tr>
                    <th scope="row"><a href="#pos_ref" class="id_refm text-light">'.$count.'</a></th>
                    <td><a href="#ref_name" class="name_refm">'.$ref_info['f_nome'].'</a></td>
                    <td><a href="#ref_level" class="text-light level_refm">1</a></td>
                    <td><a href="#ref_date" class="text-light date_refm">'.$ref_info['data'].'</a></td>
                  	<td><a href="#up_name_ref" class="up_refm">'.$sponsor_main2.'</a></td>
                  	<td><a href="#status_ref" class="text-light status_refm">'.$status1.'</a></td>
                  	<td><a href="#earns_ref" class="text-light earns_refm">'.$earns1.'</a></td>
                  	<td><a href="#deposit_ref" class="text-light activity_refm">'.$deps1.'</a></td>
                  </tr>';
									$count++;	
								}						
							}
						}		
					}	
        }
      }
		}
	}

	echo '</tbody>
          </table>';
	
}

?>
