<?php
$host = $_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}

include "../conn.php";

$modal_type = $_POST['modal'];
$show_menu = $_POST['id'];
$mode_show = $_POST['mode'];

include "../functions.php";

if($modal_type == "modal-dep" && strlen($modal_type) <= 10){

	if(is_string($show_menu) && $show_menu == "modal_dep_p" && strlen($show_menu) <= 11){

		if($mode_show == "desktop"){
			listdeposito();			
		}else if($mode_show == "no-desktop"){
			listdeposito_mobile();
		}

	}else if(is_string($show_menu) && $show_menu == "modal_dep_t" && strlen($show_menu) <= 11){

		if($mode_show == "desktop"){
			listdeposito_t();			
		}else if($mode_show == "no-desktop"){
			listdeposito_mobile_t();
		}

	}else{
		echo "null 2";
	}

}else if($modal_type == "modal-with" && strlen($modal_type) <= 10){

echo "null 1";

}else{
	echo "null";
}

?>