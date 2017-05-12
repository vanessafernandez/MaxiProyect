<?php
class Rol {
	private $MySQL;
	function Rol() {
		$this->MySQL = new MySQL ();
		$this->MySQL->Init ();
	}
	function ObtieneContenido() {
		$contenido = '<tr>';
		$contenidoAgregado = "</form><form action=\"#\" method=\"POST\"><tr><td> <input type =\"text\" name=\"nuevonombre\" required/> </td>";
		if ($stmt = $this->MySQL->PrepareQuery ( ROL_SEL_MODULOS )) {
			$stmt->execute ();
			$stmt->bind_result ( $idModulo, $nombreModulo );
			$contenido .= "<th>Rol</th>";
			while ( $stmt->fetch () ) {
				$contenido .= "<th>$nombreModulo</th>";
				$contenidoAgregado .= "<td><input type=\"checkbox\" name=\"nuevo" . "[]" . "\" value=\"$idModulo\"></td>";
			}
			$contenidoAgregado .= "<td><input type=\"submit\" name=\"ingresar\" value=\"Ingresar\"></td></tr></form>";
			$contenido .= "<th></th></tr>";
			if ($stmt2 = $this->MySQL->PrepareQuery ( ROL_SEL_ROLES )) {
				$stmt2->execute ();
				$stmt2->bind_result ( $idRol, $nombreRol );
				$array = array ();
				while ( $stmt2->fetch () ) {
					$array [] = array (
							$idRol,
							$nombreRol
					);
				}
				$stmt2->free_result ();
				for($i = 0; $i < count ( $array ); $i ++) {
					$array2 = $array [$i];
					$contenido .= "<tr> <td> <input type=\"text\" value=\"$array2[1]\" readonly /> </td>";
					if ($stmt3 = $this->MySQL->PrepareQuery ( ROL_SEL_PERMISOS )) {
						$stmt3->bind_param ( "i", $array2 [0] );
						$stmt3->execute ();
						$stmt3->bind_result ( $idModulo2, $nombreModulo2, $acceso );
						while ( $stmt3->fetch () ) {
							$contenido .= "<td> <input type=\"checkbox\" name=\"$array2[0]" . "[]\" value=\"$idModulo2\" $acceso /></td>";
						}
						$stmt3->close ();
					} else {
						$contenido .= "<td>" . $this->MySQL->Error () . "</td>";
					}
					$contenido .= "<td><button value=\"$array2[0]\" name=\"actualizar\">Actualizar</button> <button value=\"$array2[0]\" name=\"eliminar\">Eliminar</button></td></tr>";
				}
			}
			$contenido .= $contenidoAgregado;
		}
		return $contenido;
	}
	function EliminaAsignacion($id) {
		$exito = false;
		if ($stmt = $this->MySQL->PrepareQuery ( ROL_DEL_PERMISOS )) {
			$stmt->bind_param ( "i", $id );
			if ($stmt->execute ()) {
				$exito = true;
			}
		}
		return $exito;
	}
	function AsignaPermisos($id, $modulo) {
		$exito = false;
		if ($stmt = $this->MySQL->PrepareQuery ( ROL_INS_PERMISOS )) {
			$stmt->bind_param ( "ii", $id, $modulo );
			if ($stmt->execute ()) {
				$exito = true;
			}
		}
		return $exito;
	}
	function IngresaRol($nombre) {
		if ($stmt = $this->MySQL->PrepareQuery ( ROL_INS_ROL )) {
			$stmt->bind_param ( "s", $nombre );
			if ($stmt->execute ()) {
				if ($stmt2 = $this->MySQL->PrepareQuery ( ROL_SEL_IDROL )) {
					$stmt2->bind_param ( "s", $nombre );
					$stmt2->execute ();
					$stmt2->bind_result ( $idRol );
					if ($stmt2->fetch ()) {
						$stmt2->close ();
						$stmt->close ();
						return $idRol;
					} else {
						return 0;
					}
				} else {
					return 0;
				}
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	function EliminaRol($id) {
		if ($stmt = $this->MySQL->PrepareQuery ( ROL_DEL_ROL )) {
			$stmt->bind_param ("i", $id);
			if ($stmt2 = $this->MySQL->PrepareQuery ( ROL_UPD_REASIGNACION )) {
				$stmt2->bind_param ("i", $id);
				if ($stmt2->execute ()) {
					$stmt->execute ();
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
?>