<?php
require_once('./inc/checkSession.php');
$title = 'Iniciar sesion';
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
                <h1 class="text-center mb-4 fs-3 text-muted">Iniciar sesion</h1>
                <form id='formLogin'>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="email" required class="form-control" id="email" name="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <div class="form-floating flex-grow-1">
                            <input type="password" required class="form-control" name="password" id="password" placeholder="Contraseña">
                            <label for="password">Contraseña</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-tsplus" type="submit" id="btnEnviar">Ingresar</button>
                        <a class="btn btn-link text-muted" href="registro.php">¡Registrate!</a>
                    </div>
                </form>

            </div>
            <div class="card-footer">
                <a href="" class="text-muted small">MANUAL DE OPERACION</a>
                <a href="./recuperar.php" class="float-end text-muted small">RECUPERA CONTRASEÑA</a>
            </div>
        </div>
    </div>
<?php require_once('./mod/js.php'); ?>
<script src="/tienda/js/login.js"></script>
</body>
</html>