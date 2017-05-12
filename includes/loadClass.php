<?php
//se deve definir si incluiremos en cada modulo la clase ke necesitamos o dejamos como estaba incluyendo todo en load
//include CLASSPATH."*.php";
function include_all_once ($pattern) {
	foreach (glob($pattern) as $file) {
		include $file;
	}
}
include_all_once(CLASSPATH.'/*.php');
?>