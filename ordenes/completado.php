<?php
require_once('../inc/checkSession.php');
$title = 'Pago exitoso';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('../mod/head.php'); ?>
    <?php require_once('../mod/css.php'); ?>
</head>

<body>
    <?php require_once('../mod/menu.php'); ?>

    <div class="container p-5">
        <div class="card shadow p-5 text-center">
            <i class="fa-solid fa-clipboard-check mb-3 text-success" style="font-size: 10rem;"></i>
            <h1 class="display-3 mb-3">Pago exitoso</h1>
            <div>
                <a href="/tienda/ordenes/lista.php" class="btn btn-lg btn-tsplus">Ver mis ordenes</a> <br>
                <a href="/tienda" class="btn btn-link text-muted">Regresar al inicio</a>

            </div>
        </div>
    </div>
    <?php require_once('../mod/js.php'); ?>
    <script src="/tienda/js/listadoOrdenes.js"></script>
</body>

</html>