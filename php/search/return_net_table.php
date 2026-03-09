<?php 
include_once "../conn.php";

session_start();
$user = $_SESSION['email'];

$get_info = mysqli_query($con, "SELECT * FROM usuarios WHERE email = '$user'");
$get_user = mysqli_fetch_array($get_info);

$id = $get_user['id'];

$get_rows_list = mysqli_query($con, "SELECT * FROM network_list WHERE leader_id ='$id'");
$num_net_rows = mysqli_num_rows($get_rows_list);

$get_theme = mysqli_query($con, "SELECT * FROM user_config WHERE id_user = '$id'");

if($row_true = mysqli_affected_rows($con) >= 1){

	$get_user = mysqli_fetch_array($get_theme);
	$max_ipg = $get_user['lt_nipg'];
	$pg = $get_user['pgn'];

	$max_ipg_x_pg = $max_ipg * $pg;
	
	if($pg == 1){
		$max_ipg = 0;
	}else{
		$max_ipg = $max_ipg * ($pg - 1);
	}

}

$get_net_list = mysqli_query($con, "SELECT * FROM network_list WHERE leader_id = '$id' ORDER BY id ASC LIMIT $max_ipg_x_pg");

if($rtl = mysqli_affected_rows($con) >= 1){

	$count = 1;
	$count_pg = 1;

	while ($array_network = mysqli_fetch_array($get_net_list)) { 
		
		if($count_pg > $max_ipg){
	
	?>
<tr>
	<th scope="row">
		<a href="#pos_ref" class="id_ref text-light"><?php echo $count; ?></a>
	</th>
	<td>
		<a href="?ref_name=<?php echo $array_network['nome_ref']; ?>" class="name_ref text-muted"><?php echo $array_network['nome_ref']; ?></a>
	</td>
	<td>
		<a href="#ref_level" class="level_ref text-light"><?php echo $array_network['level_ref']; ?></a>
	</td>
	<td>
		<a href="#ref_date" class="date_ref text-light"><?php echo $array_network['started_ref']; ?></a>
	</td>
	<td>
		<a href="#up_name_ref" class="up_ref text-muted"> <?php echo $array_network['leader_ref']; ?></a>
	</td>
	<td>
		<a href="#status_ref" class="status_ref text-light"><?php echo $array_network['status_ref']; ?></a>
	</td>
	<td>
		<a href="?earns_ref=<?php echo $array_network['nome_ref']; ?>" class="cv earns_ref text-light"><?php echo $array_network['earns_ref']; ?></a>
	</td>
	<td>
		<a href="#actions" class="activity_ref text-light"><?php echo $array_network['activity_ref']; ?></a>
	</td>
</tr>
<?php $count++; } $count_pg++; } } ?>