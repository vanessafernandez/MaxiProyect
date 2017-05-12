<?php
$Sucursal = new Sucursal();

if (isset ( $_POST ["boton"] ) ){
	if ( $_POST ["boton"] == "Guardar" ){
		if (trim ( $_POST ["nombre"] ) != "") {
			$resultado = $Sucursal->ObtieneSucursalPorNombre ( $_POST ["nombre"]);
			if (!$resultado) {
				 $resultado2 = $Sucursal->IngresaSucursal ( $_POST ["nombre"] );
				 if (!$resultado2)
					echo "<script language='javascript'>alert('Error al ingresar sucursal.');</script>";
			} else {
				echo "<script language='javascript'>alert('Sucursal ya se encuentra ingresada.');</script>";
			}
		} else {
			echo "<script language='javascript'>alert('Debe ingresar un nombre.');</script>";
		}
	}
	if ( $_POST ["boton"] == "Editar" ) {
		//comprobar si existe
	}
}
?>
<script type="text/javascript">
$(document).ready(function(){
	var consulta;
	$("#id").focus();
	$("#id").change(function(e){
		consulta = $("#id").val();
		$.ajax({
			type: "POST",
			url: "busqueda.php",
			data: "id="+consulta+"&modulo=<?php print $_GET["modulo"];?>",
			dataType: "html",
			beforeSend: function(){
			},
			error: function(){
				alert("Error!!!");
			},
			success: function(data){
				if(data.length > 6){
					//var res = data.split("");
					$("#nombre").val(data);
					$("#boton").val("Editar");
					$("#id").attr("readonly", true);
				}
				else{
					$("#nombre").val("");
				}
			}
		});
	});
});
</script>
<div class="rightBar">
	<table>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
		</tr>
<?php print $Sucursal->ObtieneTablaSucursales();?>
</table>
</div>
<div class="centerBar">
	<h1 align="center">Control Sucursales</h1>
	<form action="#" method="POST">
		<table>
			<tr>
				<td>ID</td>
				<td><input type="text" id="id" name="id" value="" size="10" /> 
			</tr>
			<tr>
				<td>Nombre:</td>
				<td><input type="text" id="nombre" name="nombre" value="" /></td>
			</tr>
			<tr>
			<td>
				<input type="submit" id="boton" value="Guardar" name="boton" />
			</td>
		</tr>
		</table>
	</form>
</div>