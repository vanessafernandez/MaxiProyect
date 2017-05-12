<?php
session_start ();
require_once 'load.php';
$error = null;
$Login = new Login ();
if (isset ( $_POST ["Login"] )) {
  $error = $Login->validateUser ( $_POST ["inputRut"], $_POST ["inputPassword"] );
}
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
        <input type="text" name="inputRut" name="inputRut" id="inputRut" class="form-control" placeholder="RUT" required autofocus>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Contraseña" required>
        <button class="btn btn-lg btn-primary btn-block" name="Login" type="submit">Guardar</button>
      </form>

    </div>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>