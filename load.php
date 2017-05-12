<?php
/**
 * Copyright 2014 Flako.cl 
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

/**
 * Define ABSPATH as this file's directory
 */
define ( 'ROOTPATH', dirname ( __FILE__ ) . '/' );
define ( 'CONFPATH', ROOTPATH . 'includes/' );
define ( 'CLASSPATH', ROOTPATH . 'includes/class/' );
define ( 'MODPATH', ROOTPATH . 'modules/' );
if (file_exists ( CONFPATH . 'config.php' )) {
	require_once (CONFPATH . 'config.php');
	require_once (CONFPATH . 'preparedQuerys.php');
	require_once (CONFPATH . 'loadClass.php');
} else {
	print "Config File Doesn't Exist\n";
	print CONFPATH;
	die();
}
?>