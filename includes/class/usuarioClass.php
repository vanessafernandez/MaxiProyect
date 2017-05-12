<?php
class ControlUsuario {
	private $MySQL;
	function ControlUsuario() {
		$this->MySQL = new MySQL ();
		$this->MySQL->Init ();
	}
	function ObtieneSucursales() {
		$list = "";
		if ($stmt = $this->MySQL->PrepareQuery ( REGISTRO_SEL_SUCURSAL )) {
			$stmt->execute ();
			$stmt->bind_result ( $id_sucursal, $nombre_sucursal );
			$array = array ();
			while ( $stmt->fetch () ) {
				$list .= "<option value=\"$id_sucursal\">$nombre_sucursal</option>";
			}
			$stmt->close ();
			return $list;
		} else {
			return "Error al listar Sucursales\n";
		}
	}
	function ObtieneRoles() {
		$sel = "";
		if ($stmt = $this->MySQL->PrepareQuery ( REGISTRO_SEL_ROLUSER )) {
			$stmt->execute ();
			$stmt->bind_result ( $rol, $id );
			$array = array ();
			while ( $stmt->fetch () ) {
				if ($id != Developer_Lvl)
					$sel .= "<option value=\"$id\">$rol</option>";
			}
			$stmt->close ();
		} else {
			$sel .= "<option value=\"-1\">Predeterminado</option>";
		}
		return $sel;
	}
	// 0 -> error; 1-> duplicate error ; 2 exito;
	function RegistraEmpleado($rut, $sucursal, $id, $nombre, $apellido, $pass) {
		$exito = 0;
		$str = sha1 ( $rut . ":" . $pass );
		if ($stmt = $this->MySQL->PrepareQuery ( REGISTRO_INS_EMPLEADO )) {
			$stmt->bind_param ( "iiisss", $rut, $sucursal, $id, $nombre, $apellido, $str );
			if ($stmt->execute ()) {
				$stmt->close ();
				$exito = 2;
			} else {
				if (strpos ( $stmt->error, 'Duplicate entry' ) !== FALSE) {
					$exito = 1;
				}
				$stmt->close ();
			}
		}
		return $exito;
	}
	function ListaEmpleados() {
		$contenido = "";
		if ($stmt = $this->MySQL->PrepareQuery ( REGISTRO_SEL_LISTAEMPLEADOS )) {
			$stmt->execute ();
			$stmt->bind_result ( $rut, $nombre, $apellido, $sucursal, $acceso );
			while ( $stmt->fetch () ) {
				$contenido .= "<tr><td>$rut</td><td>$nombre $apellido</td><td>$sucursal</td><td>$acceso</td></tr>";
			}
			$stmt->close ();
		}
		return $contenido;
	}
	function BuscaEmpleado($rut) {
		$resultado = array ();
		$resultado ["exito"] = false;
		if ($stmt = $this->MySQL->PrepareQuery ( USUARIO_SEL_USUARIO )) {
			$stmt->bind_param ( "i", $rut );
			$stmt->execute ();
			$stmt->bind_result ( $rutEmpleado, $nombre, $apellido, $idSucursal, $idRol, $activo );
			if ($stmt->fetch ()) {
				$resultado ["exito"] = true;
				$resultado ["rut"] = $rutEmpleado;
				$resultado ["nombre"] = $nombre;
				$resultado ["apellido"] = $apellido;
				$resultado ["idsucursal"] = $idSucursal;
				$resultado ["idrol"] = $idRol;
				$resultado ["activo"] = $activo;
				$stmt->close ();
			}
		}
		return $resultado;
	}
	// 0 -> error; 1-> x error ; 2 exito;
	function ModificaEmpleado($rut, $sucursal, $id, $nombre, $apellido, $pass, $activo) {
		$exito = 0;
		$str = sha1 ( $rut . ":" . $pass );
		if ($stmt = $this->MySQL->PrepareQuery ( USUARIO_UPD_USUARIO )) {
			$stmt->bind_param ( "iisssii", $sucursal, $id, $nombre, $apellido, $str, $activo, $rut );
			if ($stmt->execute ()) {
				$stmt->close ();
				$exito = 2;
			} else {
				// if (strpos ( $stmt->error, 'Duplicate entry' ) !== FALSE) {
				$exito = 1;
				// }
				
				$stmt->close ();
			}
		}
		return $exito;
	}
	// 0-> error; 1-> x error ; 2 exito;
	function ModificaEmpleadoSP($rut, $sucursal, $id, $nombre, $apellido, $activo) {
		$exito = 0;
		if ($stmt = $this->MySQL->PrepareQuery ( USUARIO_UPD_USUARIOSP )) {
			$stmt->bind_param ( "iissii", $sucursal, $id, $nombre, $apellido, $activo, $rut );
			if ($stmt->execute ()) {
				$stmt->close ();
				$exito = 2;
			} else {
				// if (strpos ( $stmt->error, 'Duplicate entry' ) !== FALSE) {
				$exito = 1;
				// }
				
				$stmt->close ();
			}
		}
		return $exito;
	}
}
?>