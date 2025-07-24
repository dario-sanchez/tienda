<?php
require_once('../inc/checkSession.php');
$title = 'Cotizacion';
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
                <h3 class="d-inline-block mb-0">
                    Cotización de Soluciones
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!isset($_GET['ver'])) : ?>
                        <div class="col-xl-3 col-lg-5 ">
                            <div class="border rounded-3 mb-2 p-2">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text">Agregar:</span>
                                    <select name="tipoArticulo" id="tipoArticulo" class="form-select">
                                        <option value="1">Nuevo software</option>
                                        <option value="2">Renovación de software</option>
                                        <option value="3">Upgrade de software</option>
                                    </select>
                                </div>
                                <form id="formArticulo">
                                    <p class="text-center mb-2 text-primary titleUpgrade d-none">Selecciona tu Configuración Actual</p>
                                    <div class="row">
                                        <div class="col-md mb-2">
                                            <label for="software">Software</label>
                                            <select name="software" id="software" class="form-select form-select-sm">
                                            </select>
                                        </div>
                                        <div class="col-md mb-2 d-none" id="blockEdiciones">
                                            <label for="edicion">Edicion</label>
                                            <select name="edicion" id="edicion" class="form-select form-select-sm" disabled>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8 mb-2 d-none" id="blockModalidades">
                                            <label for="modalidad">Modalidaes</label>
                                            <select name="modalidad" id="modalidad" class="form-select form-select-sm" disabled>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-2" id="cantidadBlock">
                                            <label for="cantidad">Cantidad</label>
                                            <input type="number" class="form-control form-control-sm" id="cantidad" name="cantidad" step="1" value="1" min="1" max="99" required>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label for="clave">Clave de Activación</label>
                                            <input type="text" class="form-control form-control-sm" id="clave" name="clave" placeholder="Ingresar serial number">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="upgradeBlock" class="d-none">
                                            <p class="text-center mb-2 text-success titleUpgrade">Selecciona las mejoras.</p>
                                            <div class="row">
                                                <div class="col-md mb-2 d-none" id="blockEdicionesUpgrade">
                                                    <label for="edicionUpgrade">Edicion</label>
                                                    <select name="edicionUpgrade" id="edicionUpgrade" class="form-select form-select-sm" disabled></select>
                                                </div>
                                                <div class="col-md mb-2 d-none" id="blockModalidadesUpgrade">
                                                    <label for="modalidadUpgrade">Modalidaes</label>
                                                    <select name="modalidadUpgrade" id="modalidadUpgrade" class="form-select form-select-sm" disabled></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="col-12 mb-2 d-none" id="blockActualizaciones">
                                                <label for="actualizaciones">Actualizaciones</label>
                                                <select name="actualizaciones" id="actualizaciones" class="form-select form-select-sm" disabled>
                                                    <option value="1">1 año</option>
                                                    <option value="2">2 Años</option>
                                                    <option value="3">3 Años</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <label for="soporte">Soporte</label>
                                                <select name="soporte" id="soporte" class="form-select form-select-sm">
                                                    <option value="1">1 hora</option>
                                                    <option value="5" selected>5 horas</option>
                                                    <option value="10">10 horas</option>
                                                    <option value="20">20 horas</option>
                                                    <option value="0">Sin soporte</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <table class="table table-sm small">
                                                    <tbody class="small">
                                                        <tr class="small">
                                                            <td class="fw-bold" id="descProdcuto" style="width: 50%;"></td>
                                                            <td id="costoProducto" class="text-center"></td>
                                                            <td id="cantidadProducto" class="fw-bold text-center"></td>
                                                            <td id="subTotalProducto" class="text-center"></td>
                                                        </tr>
                                                        <tr class="small d-none" id="celdaActualizaciones">
                                                            <td class="fw-bold">
                                                                Actualizaciones: <span class="fw-normal" id="yearsAct"></span>
                                                            </td>
                                                            <td id="porcentajeAct" class="text-center"></td>
                                                            <td id="cantAct" class="fw-bold text-center"></td>
                                                            <td id="costoAct" class="text-center"></td>
                                                        </tr>
                                                        <tr class="small">
                                                            <td class="fw-bold">
                                                                Soporte: <span class="fw-normal" id="yearsSop"></span>
                                                            </td>
                                                            <td id="porcentajeSop" class="text-center"></td>
                                                            <td id="cantSop" class="fw-bold text-center"></td>
                                                            <td id="costoSop" class="text-center"></td>
                                                        </tr>
                                                        <tr class="small">
                                                            <td class="fw-bold">Total</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td id="totalProdcuto" class="text-center"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mb-2 col-12">
                                                <small class="text-muted small">*Precios en USD 1x $<span class="fw-bold costoDolar"></span> MXN</small>
                                            </div>
                                            <div class="col-12">
                                                <input type="submit" id='addArticulo' class="btn btn-tsplus float-end d-none" value="Agregar producto" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-xl-9 col-lg-7 mx-auto">
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 mb-2">
                                <?php if (!isset($_GET['ver'])) : ?>
                                    <label for="tipoOrden">Elige alguna de las opciones:</label>
                                    <select name="tipoOrden" id="tipoOrden" class="form-select form-select-sm">
                                        <option value="1">Cotizacion (MXN y USD)</option>
                                        <option value="2">Cotizacion (USD sin IVA)</option>
                                        <option value="3">Orden de compra (MXN y USD)</option>
                                    </select>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="codigoDescuento">Código de descuento</label>
                                <div class="input-group input-group-sm">
                                    <input id="codigoDescuento" type="text" class="form-control" placeholder="Ingresa tu codigo">
                                    <button class="btn btn-info" type="button" id="btnValidarCodigo">validar</button>
                                </div>
                            </div>
                        </div>
                        <div class="row table-responsive-md px-2">
                            <div>
                                <img src="/image/logo.png" alt="" class="mb-3" style="height: 65px; width: auto;">
                                <p class="float-end my-3">
                                    <strong>Fecha:</strong> <?php echo strftime("%e de %B %Y"); ?><br>
                                    <strong>Cliente:</strong> <?php echo $_SESSION['usuario_nombre'] ?>
                                </p>
                            </div>
                            <table class="table table-sm table-striped mb-0 w-100" id="tablaOrden">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th style="width: 60%;">Concepto</th>
                                        <th style="width: 10%;">Precio unitario</th>
                                        <th style="width: 10%;">Cantidad</th>
                                        <th style="width: 10%;">Precio (USD)</th>
                                        <th style="width: 10%;">Precio (MXN)</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                </tbody>

                                <tfoot class="small">
                                    <tr>
                                        <td></td>
                                        <td class="fw-bold text-end" style="text-align: right !important;">SubTotal antes de descuento</td>
                                        <td class="text-end subTotales" id="subtotalOrdenUSD"></td>
                                        <td class="text-end subTotales" id="subtotalOrdenMXN"></td>
                                        <td></td>
                                    </tr>
                                    <tr class="d-none descontPack">
                                        <td></td>
                                        <td class="fw-bold text-end">Descuento de arma tu paquete</td>
                                        <td class="text-end text-danger subTotales" id="descuentoPackUSD"></td>
                                        <td class="text-end text-danger subTotales " id="descuentoPackMXN"></td>
                                        <td></td>
                                    </tr>
                                    <tr class="d-none" id='rowDescuento'>
                                        <td></td>
                                        <td class="fw-bold text-end">Descuento por cupón</td>
                                        <td class="text-end text-danger subTotales" id="descuentoCuponUSD"></td>
                                        <td class="text-end text-danger subTotales " id="descuentoCuponMXN"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="fw-bold text-end">SubTotal</td>
                                        <td class="text-end subTotales" id="subtotalOrdenDescontadoUSD"></td>
                                        <td class="text-end subTotales" id="subtotalOrdenDescontadoMXN"></td>
                                        <td></td>
                                    </tr>
                                    <tr id="rowIVA">
                                        <td></td>
                                        <td class="fw-bold text-end">IVA</td>
                                        <td class="text-end subTotales" id="ivaOrdenUSD"></td>
                                        <td class="text-end subTotales" id="ivaOrdenMXN"></td>
                                        <td></td>
                                    </tr>
                                    <tr class="alert-secondary">
                                        <td>
                                            <small class="text-muted small">*Precios en USD 1x $<span class="fw-bold costoDolar"></span> MXN</small>
                                            <p class="small d-none mb-0" id="indicadorCodigoDesc">
                                                Codigo: <span id="labelCodigo"></span>
                                            </p>
                                        </td>
                                        <td class="fw-bold text-end">Total</td>
                                        <td class="text-end subTotales fw-bold" id="totalOrdeUSD"></td>
                                        <td class="text-end subTotales fw-bold" id="totalOrdeMXN"></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <?php if (isset($_GET['orden'])) : ?>
                                    <form id="formEmailCotizacion">
                                        <div class="input-group mb-1">
                                            <span class="input-group-text" id="inputGroup-sizing-default">Enviar al correo</span>
                                            <input type="email" multiple class="form-control" name="email" required placeholder="Indique el email...">
                                            <button class="btn btn-success" type="submit">Enviar</button>
                                            <a href="/tienda/ordenes/recibo.php?orden=<?php echo $_GET['orden'] ?>" target="_blank" class="btn btn-tsplus">Descargar cotizacion</a>
                                        </div>
                                        <span class="small text-muted">Puedes enviar la cotización a varias direcciones de correo separandolas con "coma".</span>
                                    </form>
                                <?php endif; ?>
                                <?php if (isset($_GET['orden']) && $_SESSION['usuario_tipo'] == 2) : ?>
                                    <div class="mt-3 border p-2 alert-secondary">
                                        <label for="comentarios">Comentarios de la orden</label>
                                        <textarea id="comentarios" class="form-control" style="height: 80px;"></textarea>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <div class="btn-group float-end" role="group">
                                    <?php if (!isset($_GET['ver'])) : ?>
                                        <button type="button" class="btn btn-info" id="btnGuardarOrden">Guardar cotizacion</button>
                                    <?php endif; ?>
                                    <?php if (isset($_GET['orden'])) : ?>
                                        <button type="button" class="btn btn-tsplus d-none" id='btnPagarOrden'>Pagar orden</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" tabindex="-1" id="modalPago">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <h5 class="modal-title">Pagar orden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav class="nav nav-pills nav-fill mb-3">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#cobroStripe" type="button">Tarjeta debito/credito</button>
                        <!-- <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cobroOpenpay" type="button">Tarjeta debito/credito opcion 2</button> -->
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cobroPaypal" type="button">PayPal</button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cobroBanco" type="button">Pago referenciado</button>
                    </nav>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="cobroStripe" role="tabpanel">
                            <form id='formStripe' autocomplete="off">
                                <div class="row">
                                    <div class="col-12 px-1 mb-2">
                                        <div class="form-floating">
                                            <input type="text" id='nombre' name='nombre' class="form-control" placeholder='Nombre' required maxlength="255">
                                            <label for="nombre" class="text-muted">Nombre del titular</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mb-2 px-1">
                                        <div class="form-floating">
                                            <div id='numtarjeta' class="form-control"></div>
                                            <label for="numtarjeta" class="text-muted">Numero de tarjeta</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-6 mb-2 px-1">
                                        <div class="form-floating">
                                            <div id='cadtarjeta' class="form-control"></div>
                                            <label for="cadtarjeta" class="text-muted">Fecha Exp.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-6 mb-2 px-1">
                                        <div class="form-floating">
                                            <div id='cvvStripe' class="form-control"></div>
                                            <label for="cadtarjeta" class="text-muted">CVV</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 mb-2 px-1 d-none d-sm-flex">
                                        <div class="align-self-center">
                                            <img src="/tienda/img/iconos-tarjetas.png" alt="tarjetas" style="height: auto;width: 180px;">
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="fs-2 fw-medium text-muted">Total a pagar: <span class="totalPago"></span></p>
                                    </div>
                                    <div class="col-12 d-grid gap-2 text-center mb-3">
                                        <input class="btn btn-lg btn-success" type="submit" value="Pagar">
                                    </div>

                                </div>

                            </form>
                            <img src="/tienda/img/stripe-logo.png" alt="stripe" class="mx-auto d-block" style="width: 150px; height: auto;">
                        </div>

                        <!-- <div class="tab-pane fade show" id="cobroOpenpay" role="tabpanel">
                            <form id='formPago' autocomplete="off">
                                <input type="hidden" id='hiddenOpenSession' name='hiddenOpenSession'>
                                <div class="row">
                                    <div class="col-12 px-1 mb-2">
                                        <div class="form-floating">
                                            <input type="text" data-openpay-card="holder_name" id='nombre' name='nombre' class="form-control" placeholder='Nombre' required maxlength="255">
                                            <label for="nombre" class="text-muted">Nombre del titular</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2 px-1">
                                        <div class="form-floating">
                                            <input type="text" data-openpay-card="card_number" id='numtarjeta' name='numtarjeta' class="form-control" placeholder='Numero de tarjeta' required maxlength="16" pattern="[0-9]+">
                                            <label for="numtarjeta" class="text-muted">Numero de tarjeta</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2 mb-2 px-1">
                                        <div class="form-floating">
                                            <select data-openpay-card="expiration_month" name="mesTarjeta" id="mesTarjeta" class="form-select">
                                                <?php
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $m = sprintf("%02d", $i);
                                                    echo "<option value='{$i}'>{$m}</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="mesTarjeta" class="text-muted">Mes Exp.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2 px-1">
                                        <div class="form-floating">
                                            <select data-openpay-card="expiration_year" name="anoTarjeta" id="anoTarjeta" class="form-select">
                                                <?php
                                                $year = date("y");
                                                for ($i = 1; $i <= 10; $i++) {
                                                    echo "<option value='{$year}'>{$year}</option>";
                                                    $year++;
                                                }
                                                ?>
                                            </select>
                                            <label for="anoTarjeta" class="text-muted">Año Exp.</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mb-2 px-1">
                                        <div class="form-floating">
                                            <input data-openpay-card="cvv2" type="text" id='cvv' name='cvv' class="form-control" placeholder='CVV' required maxlength="3" pattern="[0-9]+">
                                            <label for="cvv" class="text-muted">CVV</label>
                                        </div>
                                    </div>
                                    <div class="col-3 mb-2 px-1">
                                        <div class="align-self-center">
                                            <img src="/tienda/img/iconos-tarjetas.png" alt="tarjetas" style="height: auto;width: 180px;">
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="fs-2 fw-medium text-muted">Total a pagar: <span class="totalPago"></span></p>
                                    </div>
                                    <div class="col-12 d-grid gap-2 text-center">
                                        <input id="makeRequestCard" class="btn btn-lg btn-success" type="submit" value="Pagar">
                                        <img src="/tienda/img/openpay-color.png" alt="openpay" class="mx-auto" style="width: 90px; height: auto;">
                                    </div>
                                </div>
                            </form>
                        </div> -->

                        <div class="tab-pane fade" id="cobroPaypal">
                            <!-- <h4 class="text-tsplus">Pago mediante PayPal</h4> -->
                            <div class="w-100 text-center">
                                <p class="fs-2 fw-medium text-muted">Total a pagar: <span class="totalPago"></span></p>
                            </div>
                            <div id="paypalBtn"></div>
                        </div>
                        <div class="tab-pane fade" id="cobroBanco">
                            <h4 class="text-tsplus">Pago referenciado (Transferencia SPEI, Depósito en efectivo/cheque)</h4>
                            <ul>
                                <li>Recibimos transferencias electrónicas SPEI desde cualquier banco y depósitos en efectivo/cheque.</li>
                                <li>Una ves realizado el pago debera enviarse el comprobante al correo: hola@mundo.com para comprobar el pago.</li>
                            </ul>
                            <p>Cada cliente recibe datos bancarios personalizados para efectuar su pago vía correo electrónico al momento de colocar su pedido.</p>
                            <a href="/tienda/ordenes/recibo.php?orden=<?php echo $_GET['orden'] ?>" target="_blank" class="btn btn-lg btn-tsplus w-100">Descargar orden de pago</a>
                        </div>
                    </div>

                </div>
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
    <script src="https://www.paypal.com/sdk/js?client-id=AS9ha2PR37B3d_-Cm-GUl6Z_JKpq5n7UoeRH7_hXST6siDxYqpeLgtFSGCyF3fOGNV-6h8TQvjHQE64E&currency=MXN&locale=es_MX&disable-funding=credit,card""></script>
    <script src=" https://js.stripe.com/v3/"></script>
    <script src=" /tienda/js/cotizador.js?r=<?php echo rand(1000, 9999); ?>"></script>
    <script src="/tienda/js/cobro.js?r=<?php echo rand(1000, 9999); ?>"></script>
    <script src="/tienda/js/cobro-stripe.js?r=<?php echo rand(1000, 9999); ?>"></script>
</body>

</html>