<?php
	
	$host =$_SERVER['REQUEST_METHOD'];
	if($host == "GET"){
		exit();
	}
	
	include ("conn.php");

	$login=$_POST['email'];
	$senha=$_POST['senha'];
	
	if ($login == "admin@admin.com" && $senha == "adm@root") {
	
		$loginquery = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$login' and senha='$senha'");
		
		while ($ruseradm=mysqli_fetch_array($loginquery)) {
		
			session_start();
			$_SESSION['email'] = $login;
			$_SESSION['senha'] = $senha;
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		
			echo "<p class='alert-success'>Hi, ".utf8_encode($ruseradm['f_nome']).", go to painel !  <i class='fa fa-spinner fa-pulse'></i></p>";
			echo "<script>setTimeout(function(){ location.href = 'paineladmin.php'; }, 3000);</script>";
		
			exit();	
	
		}

	}

	if (strlen($senha) < 4) {
	
		echo "<p class='alert-danger'>Password should min 4 caracteres...</p>";
		exit();
	
	}
	
	if($senha != "adm@root" && $login != "admin@admin.com"){

		$senha=md5($_POST['senha']);
		$loginquery = mysqli_query($con, "SELECT * FROM usuarios WHERE email='$login' and senha='$senha'");
			
		if ($r=mysqli_affected_rows($con) < 1) {
		
			echo "<p class='alert-danger'>E-mail or password wrong...</p>";
		
		}else{

			while ($ruser=mysqli_fetch_array($loginquery)) {
				
				session_start();
				$_SESSION['email'] = $login;
				$_SESSION['senha'] = $senha;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['id_user'] = $ruser['id'];
				$id = $ruser['id'];

				$ip = $_SERVER['REMOTE_ADDR'];
				$ip_context = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		        $str_ip = base64_encode($ip);
		        $ip = base64_encode($_SERVER['REMOTE_ADDR']);

				$add_session_ip = mysqli_query($con, "UPDATE user_config SET ipgeo='$str_ip' WHERE id_user ='$id'");
				
				$get_ip = mysqli_query($con, "SELECT * FROM user_config WHERE ipgeo='$ip'");
				$ip_sets = mysqli_fetch_array($get_ip);

				$date=date_create();
				$last_datatime = date_timestamp_get($date);
				$check_ip_access_time = date_timestamp_get($date) - $ip_sets['last_datatime'];
				
				if($ip_sets['access_block'] == "true" && $check_ip_access_time > 0){		

					$add_session_access_block = mysqli_query($con, "UPDATE user_config SET access_block='' WHERE id_user ='$id'");
					$add_session_access = mysqli_query($con, "UPDATE user_config SET access='0' WHERE id_user ='$id'");
					$add_session_access = mysqli_query($con, "UPDATE user_config SET last_datatime='$last_datatime' WHERE id_user ='$id'");
					
					echo "<p class='alert-primary'>Hi, ".utf8_encode($ruser['f_nome'])." ".utf8_encode($ruser['l_nome']).", we will redirect to the backoffice <i class='fa fa-spinner fa-pulse'></i></p>";	
					
					if($_SESSION['email']){
			    		echo "<script>setTimeout(function(){ location.href = 'backoffice.php'; }, 3000);</script>";
			   		}
				
				}else if($ip_sets['access_block'] == "" && strlen($ip_sets['last_datatime']) < 2 || $ip_sets['access_block'] == "" && $check_ip_access_time > 20){

					$add_session_access = mysqli_query($con, "UPDATE user_config SET access='0' WHERE id_user ='$id'");
					$add_session_datatime = mysqli_query($con, "UPDATE user_config SET last_datatime='$last_datatime' WHERE id_user ='$id'");
					
					echo "<p class='alert-primary'>Hi, ".utf8_encode($ruser['f_nome'])." ".utf8_encode($ruser['l_nome']).", we will redirect to the backoffice <i class='fa fa-spinner fa-pulse'></i></p>";	
					
					if($_SESSION['email']){
			    		echo "<script>setTimeout(function(){ location.href = 'backoffice.php'; }, 3000);</script>";
			    	}

				}
					
		   	}
				
		}
	
	}

?>
