<div class="row">
	<h2 class="net-resources float-left h2 color-theme mt-3 ml-3">Banners</h2>
</div>
<?php 
	
	include_once "../conn.php";
	session_start();

 	$email = $_SESSION['email'];
	$get_user = mysqli_query($con, "SELECT * FROM usuarios WHERE email ='$email'");
	$array_user = mysqli_fetch_array($get_user);
	$leader_nome = $array_user['f_nome'];
  	
  	echo '<br><h6>300x300 <span><i aria-hidden="true" id="copy_banner1" class="fa fa-files-o fa-1x float-right" onclick="copy_banner1();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></h6><img src="images/banners/ezgif.com-300.gif" width="300px" height="300px" alt="fx banner 1"><br>';
  	echo '<textarea id="b300" name="banner 300x300" rows="2" cols="50" disabled><a href="https://fxloterry.free.nf/register.php?sponsor='.$leader_nome.'"><img src="images/banners/ezgif.com-300.gif" width="300px" height="300px" alt="fx banner 1"></a></textarea>
  <br><br>';
  	echo '<h6>728x90 <span><i aria-hidden="true" id="copy_banner1" class="fa fa-files-o fa-1x float-right" onclick="copy_banner1();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></h6><img src="images/banners/ezgif.com-728.gif" width="728" height="90px" alt="fx banner 2"><br>';
  	echo '<textarea id="b728" name="banner 300x300" rows="2" cols="50" disabled><a href="https://fxloterry.free.nf/register.php?sponsor='.$leader_nome.'"><img src="images/banners/ezgif.com-728.gif" width="300px" height="300px" alt="fx banner 2"></a></textarea>
  <br><br>';
  	echo '<h6>90x90 <span><i aria-hidden="true" id="copy_banner1" class="fa fa-files-o fa-1x float-right" onclick="copy_banner1();" style="position: absolute;margin-top: 2;margin-left: 10px;"></i></h6><img src="images/banners/ezgif.com-90.gif" width="90px" height="90px" alt="fx banner 3"><br>';
  	echo '<textarea id="b90" name="banner 90x90" rows="2" cols="50" disabled><a href="https://fxloterry.free.nf/register.php?sponsor='.$leader_nome.'"><img src="images/banners/ezgif.com-90.gif" width="90px" height="90px" alt="fx banner 3"></a></textarea>
  <br>';
?>