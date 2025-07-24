<?php
require_once('../inc/checkSession.php');
$title = 'Cotizaciones y ordenes de compra';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once('../mod/head.php'); ?>
    <?php require_once('../mod/css.php'); ?>
</head>

<body>
    <?php require_once('../mod/menu.php'); ?>
    <div class="container-fluid p-5">
        <div class="card shadow">
            <div class="card-header text-center">
                <button class="btn btn-link text-muted float-start" onclick="history.back()">
                    <i class="fa-solid fa-circle-chevron-left"></i> Regresar
                </button>
                <h5 class="d-inline-block">
                    Modificar Cotizaciones y Ordenes de Compra
                </h5>
            </div>
            <div class="card-body p-5">
                <table class="table table-sm w-100" id='tablaOrdenes'>
                    <thead class="alert-info">
                        <tr>
                            <th>Folio</th>
                            <th>Fecha de creación</th>
                            <th>Ultima edición</th>
                            <th>Total USD</th>
                            <th>Total MXN</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
    <script src="/tienda/js/listadoOrdenes.js?r=<?php echo rand(1000, 9999); ?>"></script>
</body>

</html>