<?php

//start
$name_page = $_SERVER['REQUEST_URI'];
$url_page = $name_page;

$str_pos = strpos($url_page, "perfil.php");
if($str_pos > 0){
	$url_page = "/perfil.php";
}

if($str_pos < 1){
	$str_pos = strpos($url_page, "backoffice.php");
	if($str_pos > 0){
		$url_page = "/backoffice.php";
	}
}

if($url_page == "/perfil.php"){
	$url_return = "/backoffice.php";
}else{
	$url_return = "/index.php"; 
}
//end

?>