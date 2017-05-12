<?php
class Sucursal{
	private $MySQL;
	function Sucursal() {
		$this->MySQL = new MySQL ();
		$this->MySQL->Init ();
	}
	function ObtieneTablaSucursales(){
		$list = "";
		if ($stmt = $this->MySQL->PrepareQuery ( SUCURSAL_SEL_LISTASUCURSAL )) {
			$stmt->execute ();
			$stmt->bind_result ( $id, $nombre );
			while ( $stmt->fetch () ) {
				$list .= "<tr><td>$id</td><td>$nombre</td></tr>";
			}
			$stmt->close ();
		}
		return $list;
	}
	function ObtieneSucursal ($id) {
		$nombre = "";
		if ($stmt = $this->MySQL->PrepareQuery ( SUCURSAL_SEL_SUCURSAL )) {
			$stmt->bind_param ( "i", $id );
			$stmt->execute ();
			$stmt->bind_result ( $nombre );
			$stmt->fetch ();
		}
		$stmt->close ();
		return $nombre;
	}
	function ObtieneSucursalPorNombre ($nombre) {
		$existe = false;
		if ($stmt = $this->MySQL->PrepareQuery ( SUCURSAL_SEL_SUCURSALPORNOMBRE )) {
			$stmt->bind_param ( "s", $nombre );
			$stmt->execute ();
			$stmt->bind_result ( $id, $nombre );
			if ($stmt->fetch ()){
				$existe = true;
			}
		}
		$stmt->close ();
		return $existe;
	}
	function IngresaSucursal ($nombre) {
		$exito = false;
		if ($stmt = $this->MySQL->PrepareQuery ( SUCURSAL_INS_SUCURSAL )) {
			$stmt->bind_param ("s", $nombre);
			if ($stmt->Execute()) {
				$exito = true;
				$stmt->close();
			}
		}
		return $exito;
	}
}
?>