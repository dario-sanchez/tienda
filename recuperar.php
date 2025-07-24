<?php
require_once('./inc/checkSession.php');
$title = 'Recuperar contraseña';
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
                <img src="/image/logo.png" alt="TSPlus" class="mx-auto mb-4 d-block" style="height: 65px; width: auto;">
                <h4 class="text-center mb-4 text-tsplus-alt">Recuperar contraseña</h4>
                <form data-url='' id='formRecuperacion'>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="email" required class="form-control" id="email" name="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-tsplus" type="submit" id="btnEnviar">Enviar</button>
                    </div>
                </form>

            </div>
            <div class="card-footer">
                <a class="text-muted small" href="registro.php">¡REGÍSTRATE!</a>
                <a href="/tienda" class="text-muted small float-end">¡INICIA SESIÓN!</a>
            </div>
        </div>
    </div>
<?php require_once('./mod/js.php'); ?>
    <div class="d-flex w-100 h-100 bg-dark  bg-opacity-50 text-light position-absolute justify-content-center text-center d-none" style="top:0; left:0; z-index: 9999;" id="loadingPane">
        <div class="align-self-center">
            <div class="spinner-border" role="status"></div> <br>
            Procesando...
        </div>                            
    </div>
<script src="/tienda/js/recuperar.js"></script>
</body>
</html>