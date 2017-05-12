<?php
/**
 * SQL prepared statements
 * Naming standard for defines:
 * {CLASS}_{SEL/INS/UPD/DEL/REP}_{Summary of data changed}
 * When updating more than one field, consider looking at the calling function
 * name for a suiting suffix.
 * Ej: define ( "CAJA_DEL_ITEM", "DELETE FROM temp_caja WHERE id = ?" );
 */

//Consultas Login
define ( "LOGIN_SEL_USER", "SELECT Rut FROM User WHERE Rut = ? and Status = 1" );
define ( "LOGIN_SEL_USERPWD", "SELECT Rut FROM User WHERE Rut= ? AND Password= ? and Status = 1" );
define ( "LOGIN_SEL_LEVELACC", "SELECT Rol_id FROM User WHERE Rut = ?" );
define ( "LOGIN_SEL_SCHOOL", "SELECT School_id FROM User WHERE Rut = ?" );
define ( "LOGIN_SEL_NAME", "SELECT Name FROM User WHERE Rut = ? AND Status = 1" );
//==============================================================Revisado hasta aqui====================================================================
//Consulta Creacion de Usuarios
define ( "REGISTRO_SEL_SUCURSAL", "SELECT id_sucursal, nombre_sucursal FROM sucursal ORDER BY id_sucursal" );
define ( "REGISTRO_SEL_ROLUSER", "SELECT nombre_rol,id_rol FROM rol_empleado WHERE id_rol > 0 ORDER BY nombre_rol" );
define ( "REGISTRO_INS_EMPLEADO", "INSERT INTO empleado (rut_empleado,id_sucursal,id_rol, nombre_empleado, apellido_empleado, password, fechaingreso ) VALUES (?, ?, ?, ?, ?, ?, (now()))" );
define ( "REGISTRO_SEL_LISTAEMPLEADOS", "SELECT rut_empleado, nombre_empleado, apellido_empleado, nombre_sucursal, nombre_rol FROM empleado a LEFT JOIN sucursal b ON a.id_sucursal = b.id_sucursal LEFT JOIN rol_empleado c ON a.id_rol = c.id_rol WHERE activo = 1 ORDER BY apellido_empleado" );
define ( "USUARIO_SEL_USUARIO", "SELECT rut_empleado, nombre_empleado, apellido_empleado, id_sucursal, id_rol, activo FROM empleado WHERE rut_empleado = ? " );
define ( "USUARIO_UPD_USUARIO", "UPDATE empleado SET id_sucursal = ?, id_rol = ?, nombre_empleado = ?, apellido_empleado = ?, password = ?, activo = ? WHERE rut_empleado = ?" );
define ( "USUARIO_UPD_USUARIOSP", "UPDATE empleado SET id_sucursal = ?, id_rol = ?, nombre_empleado = ?, apellido_empleado = ?, activo = ? WHERE rut_empleado = ?" );

//Consultas Portal Web
define ( "PORTAL_SEL_MODULOS", "SELECT m.nombremodulo,m.Texto,m.debug FROM rol_modulo r, modulo m WHERE r.id_modulo = m.id_modulo AND r.id_rolempleado = ? ORDER BY m.id_modulo" );
define ( "PORTAL_SEL_ACCLEVEL", "SELECT r.id_rolempleado FROM rol_modulo r, modulo m WHERE m.nombremodulo = ? AND r.id_modulo = m.id_modulo ORDER BY m.nombremodulo" );
define ( "PORTAL_SEL_GRUPO", "SELECT id_carne, nombre_carne FROM carne ORDER BY id_carne" );
define ( "PORTAL_SEL_SUBGRUPO", "SELECT id_ccarne, nombre_ccarne FROM corte_carne ORDER BY id_ccarne" );
define ( "PORTAL_SEL_PRODUCTOS", "SELECT id_producto, nombre_producto, nombre_carne, nombre_ccarne, unidad_medida FROM `producto` a LEFT JOIN carne b ON a.id_carne = b.id_carne LEFT JOIN corte_carne c on a.id_ccarne = c.id_ccarne ORDER BY id_producto" );
define ( "PORTAL_SEL_LISTAPRECIOS", "SELECT l.id_producto, p.nombre_producto, l.precio, l.fechacambioprecio, l.precio_anterior FROM producto p, lista_precios l WHERE p.id_producto = l.id_producto AND l.id_sucursal = ?" );

define ( "ROL_SEL_MODULOS", "SELECT id_modulo, texto FROM modulo ORDER BY texto" );
define ( "ROL_SEL_ROLES", "SELECT id_rol, nombre_rol FROM rol_empleado WHERE id_rol > 0 ORDER BY nombre_rol" );
define ( "ROL_SEL_PERMISOS", "SELECT a.id_modulo, texto, CASE WHEN nombre_rol IS NULL THEN '' ELSE 'checked' END AS acceso FROM modulo a LEFT JOIN rol_modulo b on b.id_modulo = a.id_modulo and b.id_rolempleado = ? LEFT JOIN rol_empleado c on b.id_rolempleado = c.id_rol order by texto" );
define ( "ROL_DEL_PERMISOS", "DELETE FROM rol_modulo WHERE id_rolempleado = ?" );
define ( "ROL_INS_PERMISOS", "INSERT INTO rol_modulo (id_rolempleado, id_modulo) VALUES (?,?) " );
define ( "ROL_INS_ROL", "INSERT INTO rol_empleado (nombre_rol) VALUES (?) " );
define ( "ROL_SEL_IDROL", "SELECT id_rol FROM rol_empleado WHERE nombre_rol = ?" );
define ( "ROL_DEL_ROL", "DELETE from rol_empleado WHERE id_rol = ?" );
define ( "ROL_UPD_REASIGNACION", "UPDATE empleado SET id_rol = -1 WHERE id_rol = ?" );

define ( "SUCURSAL_SEL_LISTASUCURSAL", "SELECT id_sucursal, nombre_sucursal FROM sucursal ORDER BY nombre_sucursal" );
define ( "SUCURSAL_SEL_SUCURSAL", "SELECT nombre_sucursal FROM sucursal WHERE id_sucursal = ?" );
define ( "SUCURSAL_SEL_SUCURSALPORNOMBRE", "SELECT id_sucursal, nombre_sucursal FROM sucursal WHERE nombre_sucursal = ?" );
define ( "SUCURSAL_INS_SUCURSAL", "INSERT INTO sucursal (nombre_sucursal) VALUES (?)" );
?>