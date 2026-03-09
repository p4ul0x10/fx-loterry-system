<?php
$host = $_SERVER['REQUEST_METHOD'];
if($host == "GET"){
	exit();
}

include "conn.php";

$modal_type = $_POST['modal'];
$show_menu = $_POST['id'];
$mode_show = $_POST['mode'];

include "functions.php";

if(is_string($modal_type) && $modal_type == "modal-dep" && strlen($modal_type) <= 10){

	if(is_string($show_menu) && $show_menu == "modal_dep_p" && strlen($show_menu) <= 11){

		if($mode_show == "desktop"){
			listdeposito();			
		}else if($mode_show == "no_desktop"){
			listdeposito_mobile();
		}

	}else if(is_string($show_menu) && $show_menu == "modal_dep_t" && strlen($show_menu) <= 11){

		if($mode_show == "desktop"){
			listdeposito_t();			
		}else if($mode_show == "no_desktop"){
			listdeposito_mobile_t();
		}

	}else{
		echo "null 2";
	}

}else if(is_string($modal_type) && $modal_type == "modal-extrato" && $show_menu = "modal_wt_p" && strlen($modal_type) <= 10){

	if($mode_show == "desktop"){
		listextrato();			
	}else if($mode_show == "no_desktop"){
		listextrato_mobile();
	}

}else if(is_string($modal_type) && $modal_type == "modal-extrato" && $show_menu = "modal_wt_r" && strlen($modal_type) <= 10){
	
	if($mode_show == "desktop"){
		listextrato_rakeback();			
	}else if($mode_show == "no_desktop"){
		listextrato_rakeback_mobile();
	}

}else if(is_string($modal_type) && $modal_type == "modal-extrato" && $show_menu = "modal_wt_t" && strlen($modal_type) <= 10){
	
	if($mode_show == "desktop"){
		listextrato_tickets();			
	}else if($mode_show == "no_desktop"){
		listextrato_tickets_mobile();
	}

}

?>