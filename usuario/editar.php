<?php
require_once('../inc/checkSession.php');
$title = 'Modificar datos del usuario';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('../mod/head.php'); ?>
    <?php require_once('../mod/css.php'); ?>
</head>

<body>
    <?php require_once('../mod/menu.php'); ?>

    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header text-center">
                <button class="btn btn-link text-muted float-start" onclick="history.back()">
                    <i class="fa-solid fa-circle-chevron-left"></i> Regresar
                </button>
                <h3 class="d-inline-block mb-0 fs-3 text-muted">
                    Modificar datos del usuario
                </h3>
            </div>
            <div class="card-body">
            <form id="formUpdateUsuario">
                    <div class="row">
                        <h3 class="h4 text-tsplus">Datos del cliente</h3>
                        <input class="form-control mb-2"  type="text" id="nombre" name="nombre"maxlength="255" placeholder="Nombre" required>
                        <input class="form-control mb-2" type="text" id="apellido" name="apellido" maxlength="255" placeholder="Apellido" required> 
                        <input class="form-control mb-2" type="password" id="password" name="password" minlength="8" maxlength="15" placeholder="Password">
                        <hr>
                        <h3 class="h4 text-tsplus">Datos de la Empresa</h3>
                        <input class="form-control mb-2" type="text" id="empresa_nombre" name="empresa_nombre" maxlength="30" placeholder="Empresa">
                        <input class="form-control mb-2" type="tel" id="telefono" name="telefono" maxlength="15" placeholder="Teléfono">
                        <input class="form-control mb-2" type="text" id="pais" name="pais" maxlength="50" placeholder="País (Mexico)">
                        <input class="form-control mb-2" type="text" id="direccion" name="direccion" maxlength="255" placeholder="Dirección">
                        <input class="form-control mb-2" type="text" id="colonia" name="colonia" maxlength="255" placeholder="Colonia">
                        <input class="form-control mb-2" type="text" id="ciudad" name="ciudad" maxlength="255" placeholder="Ciudad">
                        <input class="form-control mb-2" type="text" id="zip" name="zip" maxlength="10" placeholder="Código postal">
                        <input class="form-control mb-2" type="text" id="estado" name="estado" maxlength="255" placeholder="Estado">
                        <input class="form-control mb-1" type="text" id="cupon" name="cupon" maxlength="50" placeholder="Cupón de descuento(opcional)">
                        <div class="d-grid gap-2">
                            <button class="btn btn-tsplus" type="submit" id="btnEnviar">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="d-flex w-100 h-100 bg-dark  bg-opacity-50 text-light position-absolute justify-content-center text-center d-none" style="top:0; left:0; z-index: 9999;" id="loadingPane">
        <div class="align-self-center">
            <div class="spinner-border" role="status"></div> <br>
            Procesando...
        </div>
    </div>

    <?php require_once('../mod/js.php'); ?>    
    <script src="/tienda/js/usuario.js"></script>
</body>

</html>