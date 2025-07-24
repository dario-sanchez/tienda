<?php
require_once('./inc/checkSession.php');
$title = 'Registro';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('./mod/head.php'); ?>
    <?php require_once('./mod/css.php'); ?>

</head>

<body>
    <?php require_once('./mod/menu.php'); ?>
    <div class="container py-5">
        <div class="card col-md-7 col-sm-9 shadow mx-auto rounded-3">
            <div class="card-body">
                <h2 class="text-center text-tsplus-alt">Registro</h2>
                <form action="./inc/processRegistro.php" method="post" name="formRegistro">
                    <div class="row">
                        <h3 class="h4 text-tsplus">Datos del cliente</h3>
                        <input class="form-control mb-2" type="text" name="nombre" maxlength="255" placeholder="Nombre" required>
                        <input class="form-control mb-2" type="text" name="apellido" maxlength="255" placeholder="Apellido" required>
                        <input class="form-control mb-2" type="password" name="password" maxlength="15" placeholder="Password" required>
                        <input class="form-control mb-2" type="password" name="passwordConf" minlength="8" maxlength="15" placeholder="Confirmar-password" required>
                        <input class="form-control mb-4" type="email" name="usuario_email" maxlength="255" placeholder="E-mail" required>

                        <hr>
                        <h3 class="h4 text-tsplus">Datos de la Empresa</h3>
                        <input class="form-control mb-2" type="text" name="empresa_nombre" maxlength="30" placeholder="Empresa">
                        <input class="form-control mb-2" type="tel" name="telefono" maxlength="15" placeholder="Telefono">
                        <input class="form-control mb-2" type="text" name="pais" maxlength="50" placeholder="Pais (Mexico)">
                        <input class="form-control mb-2" type="text" name="direccion" maxlength="255" placeholder="Direccion">
                        <input class="form-control mb-2" type="text" name="colonia" maxlength="255" placeholder="Colonia">
                        <input class="form-control mb-2" type="text" name="ciudad" maxlength="255" placeholder="Ciudad">
                        <input class="form-control mb-2" type="text" name="zip" maxlength="10" placeholder="Codigo postal">
                        <input class="form-control mb-2" type="text" name="estado" maxlength="255" placeholder="Estado">
                        <input class="form-control mb-1" type="text" name="cupon" maxlength="50" placeholder="Cupon de descuento(opcional)">
                        <span class="small text-muted mb-2">El cupon de descuento es opcional.</span>
                        <div class="col-12 text-center mb-2">
                            <label for="termin"><input type="checkbox" name="termin" id="termin" value="1" required> Acepta los Terminos y <a href="https://tsplus.mx/termsofuse.php" target="_blank">Condiciones</a></label>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-tsplus" type="submit" id="btnEnviar">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="/tienda" class="text-muted small">¡INICIA SESIÓN!</a>
            </div>
        </div>
    </div>
    <?php require_once('./mod/js.php'); ?>
</body>

</html>