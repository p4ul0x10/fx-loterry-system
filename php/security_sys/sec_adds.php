<?php

/**

Detect manual $_GET method

*/


// Array of the prevent exceptions

function ar_char_prevent(){

	
	$ar_prevent_chars = array();


	$ar_prevent_chars[0] = "||";

	$ar_prevent_chars[1] = "&&";

	$ar_prevent_chars[2] = "<";

	$ar_prevent_chars[3] = ">";

	$ar_prevent_chars[4] = "OR";

	$ar_prevent_chars[5] = "AND";

	$ar_prevent_chars[6] = "or";

	$ar_prevent_chars[7] = "and";

	$ar_prevent_chars[8] = "'";

	$ar_prevent_chars[9] = "''";

	$ar_prevent_chars[10] = '"';

	$ar_prevent_chars[11] = '""';
	

	return $ar_prevent_chars;


}


// Array of the get type prevent exceptions

function ar_get_type_prevent(){


	$ar_except_gets_method = array();


	$ar_except_gets_method[0] = "modal_deposits=desktop";

	$ar_except_gets_method[1] = "modal_deposits=mobile";

	$ar_except_gets_method[2] = "modal_withdraws=desktop";

	$ar_except_gets_method[3] = "modal_withdraws=mobile";

	$ar_except_gets_method[4] = "dep_tickets=true";

	$ar_except_gets_method[5] = "dep_packages=true";

	$ar_except_gets_method[6] = "pg_dep";

	$ar_except_gets_method[7] = "pg_with";

	$ar_except_gets_method[8] = "modal_deposits=desktop";

	$ar_except_gets_method[9] = "user"; 

	$ar_except_gets_method[10] = "ref_name"; 

	$ar_except_gets_method[11] = "earns_ref";

	$ar_except_gets_method[12] = "visible";

	$ar_except_gets_method[13] = "referral=banners";

	$ar_except_gets_method[14] = "referral=analitics";

	$ar_except_gets_method[15] = "referral=network";

	$ar_except_gets_method[16] = "hgt";


	return $ar_except_gets_method;


}



// Caminho e query string

$requestUri = $_SERVER['REQUEST_URI'];



// Verifica se o caractere existe na URL

$caractere_url = "?";

$pos_char = strpos($requestUri, $caractere_url);

// Load special charecters prevent

$prevent_chars = ar_char_prevent();

// Load get parameters valid's for prevent exceptions

$prevent_get_type = ar_get_type_prevent();


// Detect if is get type

$count_params_get = 0;

$count_str_param = 0;

$array_pos_param = array();


$url_with_param_get = $caractere_url;

$len_str_param = strlen($requestUri);

$str_param_transform = str_split($requestUri);


// Check $_post method space on url

if($_SERVER['REQUEST_METHOD'] === 'POST') {


	$ar_invalids_params_get = count($prevent_chars);

	$space_findedp0 = false;

	foreach ($_POST as $key => $value) {

	
		// Expressão regular:
		// [^a-zA-Z0-9] → captura qualquer caractere que NÃO seja letra ou número
		// O modificador 'u' garante suporte a UTF-8

		$pattern = '/[^a-zA-Z0-9]/u';

		// Executa a busca

		if(preg_match_all($pattern, $value, $matches)) {
		  
			
			$count_str = count($matches[0]);	  	
		    
			for($i=0; $i < $count_str; $i++) { 
				
				// Caracters exceptions
				if($matches[0][$i] != "-" && $matches[0][$i] != "@" && $matches[0][$i] != "#" && $matches[0][$i] != "_" && $matches[0][$i] != "." && $matches[0][$i] != "/" && $matches[0][$i] != ":" && $matches[0][$i] != " "){
					$space_findedp0 = true;
					exit();
			
				}

			}

		}

		// Detect spaces

		if(strpos($value, '%20') !== false && $space_findedp0 == false) {

	    	exit();
		
		}


	}


}

// Check $_get method space on url

if($_SERVER['REQUEST_METHOD'] === 'GET') {


	// Expressão regular:
	// [^a-zA-Z0-9] → captura qualquer caractere que NÃO seja letra ou número
	// O modificador 'u' garante suporte a UTF-8
	$pattern = '/[^a-zA-Z0-9]/u';
	$space_finded0 = false;

	// Executa a busca
	if(preg_match_all($pattern, $requestUri, $matches)) {
	  
		
		$count_str = count($matches[0]);	  	
	    

		for($i=0; $i < $count_str; $i++) { 
		
			if($matches[0][$i] != "/" && $matches[0][$i] != "?" && $matches[0][$i] != "." && $matches[0][$i] != "=" && $matches[0][$i] != "&" && $matches[0][$i] != "#" && $matches[0][$i] != "_"){
			
				$space_finded0 = true;
				
			}


		}
	   

	}

	
	if(strpos($requestUri, ' ') !== false && $space_finded0 == false) {

		$space_finded0 = true;

	}

	
	if($space_finded0 == true){ //space detected

		$exceptions_get = true;

	}



}



// Check get exception true | false

if($exceptions_get == true){ // Exceptions 

	

	if($pos_char !== false){ // Get detected

		

		// Return main backoffice -> detected invalid parameter

		$targetUrl = "/backoffice.php";

		header("Location: " . $targetUrl);

		

	}



}



?>