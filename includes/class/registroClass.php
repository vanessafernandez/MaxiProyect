<?php
class Registro {
	private $MySQL;
	function Registro() {
		$this->MySQL = new MySQL ();
		$this->MySQL->Init ();
	}
	function ObtieneSucursales() {
		if ($stmt = $this->MySQL->PrepareQuery ( REGISTRO_SEL_SUCURSAL )) {
			$stmt->execute ();
			$stmt->bind_result ( $id_sucursal, $nombre_sucursal );
			$array = array ();
			while ( $stmt->fetch () ) {
				$array [] = array (
						$id_sucursal,
						$nombre_sucursal
				);
			}
			$stmt->close ();
		} else {
			$array [] = array (
					'-1',
					'SIN ASIGNAR'
			);
		}
		return $array;
	}
	function ObtieneRoles() {
		$sel = "";
		if ($stmt = $this->MySQL->PrepareQuery ( REGISTRO_SEL_ROLUSER )) {
			$stmt->execute ();
			$stmt->bind_result ( $rol, $nivel );
			while ( $stmt->fetch () ) {
				if($nivel != Developer_Lvl){
					$sel .= "<option value=\"$nivel\">$rol</option>";
				}
			$stmt->close ();
			}
		}
		return $sel;
	}
	function RegistraEmpleado($rut, $sucursal, $nivel, $nombre, $apellido, $user, $pass) {
		$str = sha1 ( $user . ":" . $pass );
		if ($stmt = $this->MySQL->PrepareQuery ( REGISTRO_INS_EMPLEADO )) {
			$stmt->bind_param ( "iiissss", $rut, $sucursal, $nivel, $nombre, $apellido, $user, $str );
			if ($stmt->execute ()) {
				$stmt->close ();
				return TRUE;
			} else {
				$stmt->close ();
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
}
?>