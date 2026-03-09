<?php
include ('backoffice.php');

$token = $_SESSION['email'];
if(isset($token)) {
   // limpe tudo que for necessário na saída.
   // Eu geralmente não destruo a seção, mas invalido os dados da mesma
   // para evitar algum "necromancer" recuperar dados. Mas simplifiquemos:
   session_destroy();
   echo "<script>setTimeout(function(){
   	location.href='index.php';
   }, 2500);</script>";
   
   exit();
}

?>
