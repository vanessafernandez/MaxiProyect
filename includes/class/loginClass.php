<?php
class Login {
	private $MySQL;
	function Login() {
		$this->MySQL = new MySQL ();
		$this->MySQL->Init ();
	}
	function getAccess($user) {
		if ($stmt = $this->MySQL->PrepareQuery ( LOGIN_SEL_LEVELACC )) {
			$stmt->bind_param ( "i", $user );
			$stmt->execute ();
			$stmt->bind_result ( $levelacc );
			if ($stmt->fetch ()) {
				$stmt->close ();
				return $levelacc;
			} else {
				$stmt->close ();
				return 0;
			}
		} else {
			return 0;
		}
	}
	function getSucursal($user) {
		if ($stmt = $this->MySQL->PrepareQuery ( LOGIN_SEL_SCHOOL )) {
			$stmt->bind_param ( "i", $user );
			$stmt->execute ();
			$stmt->bind_result ( $suc );
			if ($stmt->fetch ()) {
				$stmt->close ();
				return $suc;
			} else {
				$stmt->close ();
				return 0;
			}
		} else {
			return 0;
		}
	}
	function getUserAcc($user, $pass) {
		$str = sha1 ( $user . ":" . $pass );
		if ($stmt = $this->MySQL->PrepareQuery ( LOGIN_SEL_EMPLEADOPWD )) {
			$stmt->bind_param ( "is", $user, $str );
			$stmt->execute ();
			$stmt->bind_result ( $nombre );
			$stmt->fetch ();
			$stmt->close ();
			return $nombre;
		} else {
			return FALSE;
		}
	}
	function getUserName($user) {
		if ($stmt = $this->MySQL->PrepareQuery ( LOGIN_SEL_NAME )) {
			$stmt->bind_param ( "i", $user );
			$stmt->execute ();
			$stmt->bind_result ( $nombre );
			$stmt->fetch ();
			$stmt->close ();
			return $nombre;
		}
	}
	function ComprobarPassword($user, $pass) {
		$str = sha1 ( $user . ":" . $pass );
		if ($stmt = $this->MySQL->PrepareQuery ( LOGIN_SEL_EMPLEADOPWD )) {
			$stmt->bind_param ( "is", $user, $str );
			$stmt->execute ();
			if ($stmt->fetch ()) {
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
	function validateUser($user, $pass) {
		$cad;
		if (! $this->UserExist ( $user )) {
			return "<tr><td colspan=\"2\">Usuario no existe.</td></tr>";
		} else {
			if (! $this->ComprobarPassword ( $user, $pass )) {
				return "<tr><td colspan=\"2\">Contrase&ntilde;a incorrecta.</td></tr>";
			} else {
				$rut = $this->getUserAcc ( $user, $pass );
				$_SESSION ["usuario"] = $this->getUserName( $user );
				$_SESSION ["sucursal"] = $this->getSucursal ( $user );
				
			}
		}
	}
	function UserExist($user) {
		if ($stmt = $this->MySQL->PrepareQuery ( LOGIN_SEL_USER )) {
			$stmt->bind_param ( "i", $user );
			$stmt->execute ();
			if ($stmt->fetch ()) {
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