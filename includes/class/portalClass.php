<?php
class Portal {
	private $MySQL;
	function Portal() {
		$this->MySQL = new MySQL ();
		$this->MySQL->Init ();
	}
	function Sidebar($level) {
		$menu = "";
		if ($stmt = $this->MySQL->PrepareQuery ( PORTAL_SEL_MODULOS )) {
			$stmt->bind_param ( "i", $level );
			$stmt->execute ();
			$stmt->bind_result ( $nombre, $texto , $debug );
			while ( $stmt->fetch () ) {
				if(file_exists ( MODPATH . $nombre . ".php" ) ){
					$status="";
					if($debug == 1 && $level == Administrator_Lvl){
						$status="disabled";
					}
				}
				else{
					$status="disabled";
				}
				$menu .= "<a href=\"?modulo=$nombre\" id=\"$nombre\"><button id=\"menubutton\" $status>$texto</button></a>\n";
			}
		}
		return $menu;
	}
	function ObtieneTablaSubGrupos() {
		$list = "";
		if ($stmt = $this->MySQL->PrepareQuery ( PORTAL_SEL_SUBGRUPO )) {
			$stmt->execute ();
			$stmt->bind_result ( $id, $nombre );
			while ( $stmt->fetch () ) {
				$list .= "<tr><td>$id</td><td>$nombre</td></tr>";
			}
			$stmt->close ();
		}
		return $list;
	}
	function ObtieneTablaGrupos() {
		$list = "";
		if ($stmt = $this->MySQL->PrepareQuery ( PORTAL_SEL_GRUPO )) {
			$stmt->execute ();
			$stmt->bind_result ( $id, $nombre );
			while ( $stmt->fetch () ) {
				$list .= "<tr><td>$id</td><td>$nombre</td></tr>";
			}
			$stmt->close ();
		}
		return $list;
	}
	function ObtieneTablaProductos() {
		$list = "";
		if ($stmt = $this->MySQL->PrepareQuery ( PORTAL_SEL_PRODUCTOS )) {
			
			$stmt->execute ();
			$stmt->bind_result ( $id, $nombre, $carne, $corte, $unidad );
			while ( $stmt->fetch () ) {
				$list .= "<tr><td>$id</td><td>$nombre</td><td>$carne</td><td>$corte</td><td>$unidad</td></tr>";
			}
			$stmt->close ();
		}
		
		return $list;
	}
	function ObtieneTablaPrecios($sucursal) {
		$list = "<table><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Fecha Cambio</th><th>Precio Anterior</th></tr>";
		if ($stmt = $this->MySQL->PrepareQuery ( PORTAL_SEL_LISTAPRECIOS )) {
			$stmt->bind_param ( "i", $sucursal );
			$stmt->execute ();
			$stmt->bind_result ( $id, $nombre, $precio, $fechaCambio, $precioAnterior );
			while ( $stmt->fetch () ) {
				$list .= "<tr><td>$id</td><td>$nombre</td><td>$precio</td><td>$fechaCambio</td><td>$precioAnterior</td></tr>";
			}
			$stmt->close ();
		} else {
			$list .= "<tr><td>error</td><tr>";
		}
		$list .= "</table>";
		return $list;
	}
	function getModLevel($modulo, $pw) {
		if ($stmt = $this->MySQL->PrepareQuery ( PORTAL_SEL_ACCLEVEL )) {
			$stmt->bind_param ( "s", $modulo );
			$stmt->execute ();
			$stmt->bind_result ( $level );
			while ( $stmt->fetch () ) {
				if ($level == $pw) {
					return true;
				}
			}
			return false;
		}
	}
}
?>