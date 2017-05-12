<?php
$Rol = new Rol ();
if (isset ( $_POST ["actualizar"] )) {
	$id = $_POST ["actualizar"];
	$modulos = array ();
	if (isset ( $_POST [$id] )) {
		$modulos = $_POST [$id];
		$exito = $Rol->EliminaAsignacion ( $id );
		if ($exito) {
			for($i = 0; $i < count ( $modulos ); $i ++) {
				$Rol->AsignaPermisos ( $id, $modulos [$i] );
			}
		} else {
			echo "error";
		}
	} else {
		$Rol->EliminaAsignacion ( $id );
	}
}
if (isset ( $_POST ["ingresar"] )) {
	$idModulo = $Rol->IngresaRol ( $_POST ["nuevonombre"] );
	$modulos = $_POST ["nuevo"];
	if ($idModulo > 0) {
		for($i = 0; $i < count ( $modulos ); $i ++) {
			$Rol->AsignaPermisos ( $idModulo, $modulos [$i] );
		}
	}
}
if (isset ( $_POST ["eliminar"] )) {
	$id = $_POST ["eliminar"];
	$exito = $Rol->EliminaAsignacion ($id);
	if ($exito) {
		$Rol->EliminaRol($id);
	}
}
?>
<div class="fullbar">
	<table class="rol">
		<form action="#" method="post">
	<?php
	echo $Rol->ObtieneContenido ();
	?>
</table>
</div>