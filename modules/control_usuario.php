<?php
$ControlUsuario = new ControlUsuario ();

if (isset ( $_POST ["boton"] )) {
	if ($_POST ["boton"] == "Guardar") {
		$exito = $ControlUsuario->RegistraEmpleado ( $_POST ["rut_usuario"], $_POST ["sucursal"], $_POST ["idrol"], $_POST ["nombre"], $_POST ["apellido"], $_POST ["password"] );
		if ($exito == 1) {
			echo '<script type="text/javascript"> alert("Rut a ingresar ya se encuentra registrado favor usar funcion de busqueda para editar!");</script>';
		} else {
			if ($exito == 0) {
				echo '<script type="text/javascript"> alert("Error al ingresar el empleado!");</script>';
			}
		}
	}
	if ($_POST ["boton"] == "Editar") {
		if ( isset ( $_POST ["password"] ) ) {
			$exito = $ControlUsuario->ModificaEmpleado ( $_POST ["rut_usuario"], $_POST ["sucursal"], $_POST ["idrol"], $_POST ["nombre"], $_POST ["apellido"], $_POST ["password"], $_POST ["activo"] );
		} else {
			$exito = $ControlUsuario->ModificaEmpleadoSP ( $_POST ["rut_usuario"], $_POST ["sucursal"], $_POST ["idrol"], $_POST ["nombre"], $_POST ["apellido"], $_POST ["activo"] );
		}
		if ($exito == 2) {
			//empleado modificado con exito.
		} else {
			echo '<script type="text/javascript"> alert("Error al modificar el empleado.");</script>';
		}
	}
}
?>
<script type="text/javascript">
$(document).ready(function(){

	var consulta;
	
	$("#rut_usuario").focus();
	
	$("#rut_usuario").change(function(e){
		consulta = $("#rut_usuario").val().replace("k","0");
		$("#rut_usuario").val(consulta);
		if (validaRut(consulta)) {
			var elements = $(".datosusuario");
			for (var i =0; i< elements.length; i++){
				elements[i].disabled = false;
			}
			$.ajax({
				type: "POST",
				url: "busqueda.php",
				data: "rut="+consulta+"&modulo=<?php print $_GET["modulo"];?>",
				dataType: "html",
				beforeSend: function(){
				},
				error: function(){
					alert("Error!!!");
				},
				success: function(data){
					if(data.length > 6){
						var res = data.split("|");
						$("#nombre").val(res[0]);      
						$("#apellido").val(res[1]);         	
						$("#sucursal").val(res[2]);         
						$("#idrol").val(res[3]);
						$("#activo").val(res[4]);
						$("#boton").val("Editar");
						$("#rut_usuario").attr("readonly",true);
						$("#filapass").html('<input type="button" onclick="editaPassword();" value="Cambiar Contrase&ntilde;a">');
					}
					else{
						$("#nombre").val("");
						$("#apellido").val("");
						$("#sucursal").val("");
						$("#idrol").val("");
						$("#activo").val("");
						$("#filapass").html('<input type="password" id="password" name="password" required>');
						$("#boton").val("Guardar");
					}
					$("#nombre").focus();
				}
			});
		} else { 
			alert("Rut invalido."); 
			$("#rut_usuario").focus();
		}
	});
	$("#rut_usuario").keydown(function (e) {
		if (e.keyCode == 109 || e.keyCode == 110 || e.keyCode == 189 ||  e.keyCode == 190) { 
			return false;
		}
	});
});
function editaPassword() {
	$("#filapass").html('<input type="password" id="password" name="password" required>');
}
function validaRut(rut) {
	var conjunto = rut.split("");
	var mult = 2;
	var suma = 0;
	for (var i = (conjunto.length-2); i >= 0; i--) {
		if (mult == 8)
			mult = 2;
		var res = conjunto[i] * mult;
		suma += res;
		mult++;
	}
	var resto = 11 - (suma%11);	
	return (resto == conjunto[conjunto.length-1]) ? true : false;
}
</script>
<div class="rightBar">
	<form action="#" method="POST">
		<table>
			<tr>
				<th>Rut</th>
				<th>Nombre</th>
				<th>Sucursal</th>
				<th>Acceso</th>
			</tr>
			<?php
			echo $ControlUsuario->ListaEmpleados ();
			?>
			</table>
	</form>
</div>
<div class="centerBar">
	<h1 align="center">Control Usuarios</h1>
	<form action="#" method="post" name="input">
		<table>
			<tr>
				<td>Rut:</td>
				<td><input type="text" id="rut_usuario" name="rut_usuario" value=""
					formnovalidate required></td>
			</tr>
			<tr>
				<td>Nombre:</td>
				<td><input type="text" id="nombre" class="datosusuario" name="nombre" value="" required></td>
			</tr>
			<tr>
				<td>Apellido:</td>
				<td><input type="text" id="apellido" class="datosusuario" name="apellido" value=""
					required></td>
			</tr>
			<tr>
				<td>Sucursal:</td>
				<td><select id="sucursal" class="datosusuario" name="sucursal">
			<?php echo $ControlUsuario->ObtieneSucursales ();?>
				</select></td>
			</tr>
			<tr>
				<td>Contrase&ntilde;a:</td>
				<td id="filapass"><input type="password" id="password" class="datosusuario" name="password" required></td>
			</tr>
			<tr>
				<td>Nivel de Acceso:</td>
				<td><select id="idrol" class="datosusuario" name="idrol">
				<?php
				print $ControlUsuario->ObtieneRoles ();?>
								
				</select></td>
			</tr>
			<td>Activo:</td>
			<td><select id="activo" class="datosusuario" name="activo">
					<option value="0">NO</option>
					<option value="1">SI</option>
			</select></td>
			<tr>
				<td colspan="2"><input type="submit" id="boton" class="datosusuario" name="boton"
					value="Guardar"></td>
			</tr>
		</table>
	</form>
</div>