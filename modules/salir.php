<?php
session_destroy ();
$Login = new Login ();
$Caja = new Caja ();
$user = $_SESSION ["cadena"];
$suc = $_SESSION ["sucursal"];
if ($Caja->getStatus ( $user ) == 1) {
	include 'cierrecaja.php';
} else {
	$Login->KillSession ( $_SESSION ["cadena"] );
	header ( "Location: login.php" );
}
?>