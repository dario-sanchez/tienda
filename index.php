<?php
require_once('./inc/checkSession.php');

$title = 'Tienda';
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
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <span class="h3 text-muted">Bienvenido <?php echo $_SESSION['usuario_nombre'] ?></span>
            </div>
            <div class="card-body p-5">
                <div class="row d-flex justify-content-center">
                    <a href="./ordenes/cotizacion.php" class="shadow-sm text-white fw-bold m-2 col-sm-4 col-md-3 col-lg-2 border rounded p-4 bg-tsplus-alt text-center">
                        <i class="fa-solid fa-file-invoice-dollar d-block fs-1"></i>
                        Cotizar
                    </a>
                    <a href="./ordenes/lista.php" class="shadow-sm text-white fw-bold m-2 col-sm-4 col-md-3 col-lg-2 border rounded p-4 bg-tsplus-alt text-center">
                        <i class="fa-solid fa-receipt d-block fs-1"></i>
                        Ver cotizaciones y ordenes de compra
                    </a>
                    <a href="./usuario/editar.php" class="shadow-sm text-white fw-bold m-2 col-sm-4 col-md-3 col-lg-2 border rounded p-4 bg-tsplus-alt text-center">
                        <i class="fa-solid fa-user d-block fs-1"></i>
                        Modificar mis datos
                    </a>
                    <?php if ($_SESSION['usuario_tipo'] == 2) : ?>
                        <a href="./administracion/editar.php" class="shadow-sm text-white fw-bold m-2 col-sm-4 col-md-3 col-lg-2 border rounded p-4 bg-tsplus-alt text-center">
                            <i class="fa-solid fa-sliders fs-1 d-block"></i>
                            Modificar precios
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- <div class="card-footer">pie</div> -->
        </div>
    </div>
    <?php require_once('./mod/js.php'); ?>
    <script>
    </script>
</body>

</html>