<?php

/*
Create a new mysqli connection
*/

// Vars init
$user = "root";
$passwd = "";
$host = "localhost";
$db = "fxrobot";

// Con create
$con = new mysqli($host,$user,$passwd,$db);	

ini_set('display_errors', 0);
session_start();

include_once ("security_sys/sec_adds.php");

?>