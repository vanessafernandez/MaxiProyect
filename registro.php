<?php
session_start ();
require_once 'load.php';
$error = null;
$Login = new Login ();
if (isset ( $_POST ["Entrar"] )) {
  $error = $Login->validateUser ( $_POST ["usuario"], $_POST ["pass"] );
}
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>

<link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/registro.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
<?php
      if (isset ( $error ))
        print $error;
      ?>
      <form class="form-register" action="#" method="POST">
        <h3 class="form-register-heading">Creacion de Cuenta</h3>
        <label for="inputRut" class="sr-only">Rut</label>
        <input type="text" name="" name="inputRut" id="inputRut" class="form-control" placeholder="RUT" required autofocus>
        <label for="inputUsername" class="sr-only">Nombre</label>
        <input type="text" id="inputUsername" class="form-control" placeholder="Nombre" required>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Correo" required>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <label for="inputPassword2" class="sr-only">Confirmar Contraseña</label>
        <input type="password" id="inputPassword2" class="form-control" placeholder="Confirmar Contraseña" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Guardar</button>
      </form>

    </div>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>