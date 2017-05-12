<?php
class MySQL {
	private $_webdb;
	function Init() {
		$this->_webdb = new mysqli ( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
	}
	function PrepareQuery($query) {
		return $this->_webdb->prepare ( $query );
	}
	function Kill() {
		$this->_webdb->close ();
	}
	function Error() {
		return $this->_webdb->error;
	}
}
?>