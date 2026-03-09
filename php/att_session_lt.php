<?php

include_once "conn.php";

$host = $_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}
	
$date = addslashes($_POST['lt_date']);
$mode = addslashes($_POST['mode']);


?>