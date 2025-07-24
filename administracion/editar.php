<?php
require_once('../inc/checkSession.php');
$title = 'Editar precios y paquetes';
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
        <button
          class="btn btn-link text-muted float-start"
          onclick="history.back()">
          <i class="fa-solid fa-circle-chevron-left"></i> Regresar
        </button>
        <h5 class="d-inline-block mb-0">
          Modificar Cotizaciones y Ordenes de Compra
        </h5>
      </div>
      <div class="card-body p-5" id="app">
        <h5 class="text-tsplus">Costos misceláneos</h5>
        <form id="formMiscelaneos">
          <div class="row g-1">
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control text-end"
                    id="porcientoIva"
                    placeholder="Porcentaje IVA"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.iva" />
                  <label for="porcientoIva" class="text-muted">Porcentaje IVA</label>
                </div>
                <span class="input-group-text">%</span>
              </div>
            </div>
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control"
                    id="actualizacion1"
                    placeholder="Costo actualización 1 año"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.actualizacion1" />
                  <label for="actualizacion1" class="text-muted">Costo actualización 1 año</label>
                </div>
              </div>
              <small class="text-muted">Costo por año</small>
            </div>
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control"
                    id="actualizacion2"
                    placeholder="Costo actualización 2 años"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.actualizacion2" />
                  <label for="actualizacion2" class="text-muted">Costo actualización 2 año</label>
                </div>
              </div>
              <small class="text-muted">Costo por año</small>
            </div>
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control"
                    id="actualizacion3"
                    placeholder="Costo actualización 3 años"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.actualizacion3" />
                  <label for="actualizacion3" class="text-muted">Costo actualización 3 año</label>
                </div>
              </div>
              <small class="text-muted">Costo por año</small>
            </div>
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control"
                    id="soporteHora1"
                    placeholder="Costo 1 hora de soporte"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.soporte1" />
                  <label for="soporteHora1" class="text-muted">Costo 1 hora de soporte</label>
                </div>
              </div>
            </div>
            <!-- <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control"
                    id="soporteHora5"
                    placeholder="Costo 5 horas de soporte"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.soporte5" />
                  <label for="soporteHora5" class="text-muted">Costo 5 horas de soporte</label>
                </div>
              </div>
            </div>
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control"
                    id="soporteHora10"
                    placeholder="Costo 10 horas de soporte"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.soporte10" />
                  <label for="soporteHora10" class="text-muted">Costo 10 horas de soporte</label>
                </div>
              </div>
            </div>
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input
                    type="number"
                    class="form-control"
                    id="soporteHora20"
                    placeholder="Costo 20 horas de soporte"
                    step="0.01"
                    min="1"
                    required
                    rv-value="miscelaneos.soporte20" />
                  <label for="soporteHora20" class="text-muted">Costo 20 horas de soporte</label>
                </div>
              </div>
            </div> -->
            <div class="col-md-2 mb-1">
              <div class="input-group">
                <span class="input-group-text">$</span>
                <div class="form-floating">
                  <input type="number" class="form-control" id="preciDolar" step="0.1" min="1" rv-value="miscelaneos.dolar" />
                  <label for="preciDolar" class="text-muted">Precio dólar</label>
                </div>
              </div>
              <div class="small">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" rv-checked="miscelaneos.congelarDolar" id="flexCheckChecked" />
                  <label class="form-check-label" for="flexCheckChecked">
                    Congelar Dólar
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </form>
        <hr />

        <div class="row">
          <div class="col-md-8">
            <h5>Costos productos</h5>
            <div class="row">
              <div class="col-md-6">
                <h6>Productos</h6>
                <div class="form-floating mb-3">
                  <select class="form-select" id="productoSelect">
                    <option selected value="">Seleccionar producto...</option>
                    <option
                      rv-each-producto="productos"
                      rv-value="producto.id">
                      {producto.nombre}
                    </option>
                    <option value="new">Crear nuevo</option>
                  </select>
                  <label for="productoSelect">Producto</label>
                </div>
                <div
                  class="alert alert-secondary"
                  style="display: none"
                  id="productoPanel">
                  <h6>Datos del producto</h6>
                  <form id="formProducto">
                    <div class="row g-1">
                      <div class="col-8 mb-1">
                        <div class="form-floating">
                          <input
                            type="text"
                            rv-value="productoData.nombre"
                            class="form-control"
                            id="nombreProducto"
                            placeholder="Nombre producto"
                            required />
                          <label for="nombreProducto">Nombre producto</label>
                        </div>
                      </div>
                      <div class="col-md-4 mb-1">
                        <div class="form-floating">
                          <input
                            type="number"
                            rv-value="productoData.orden"
                            step="1"
                            min="0"
                            max="99"
                            class="form-control"
                            id="ordenProducto"
                            placeholder="Orden en la lista"
                            required />
                          <label for="ordenProducto">Orden en la lista</label>
                        </div>
                      </div>
                      <div class="col-md-4 mb-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            rv-checked="productoData.por_usuario"
                            value="1"
                            id="usuarioProducto" />
                          <label
                            class="form-check-label"
                            for="usuarioProducto">
                            Usuario único
                          </label>
                        </div>
                      </div>
                      <div class="col-md-4 mb-1">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            rv-checked="productoData.activo"
                            value="1"
                            id="activoProducto" />
                          <label
                            class="form-check-label"
                            for="activoProducto">
                            Activo
                          </label>
                        </div>
                      </div>
                      <div class="col-12">
                        <input
                          type="submit"
                          class="btn btn-success"
                          value="Guardar" />
                        <button
                          type="button"
                          class="btn btn-danger float-end"
                          id="borrarProducto"
                          title="borrar producto"
                          rv-if="productoData.id">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <h5>Configuración del producto</h5>
                <div class="form-check" id="checkEdiciones">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    rv-checked="requireEdiciones"
                    value="1"
                    id="requireEdiciones" />
                  <label class="form-check-label" for="requireEdiciones">
                    Tendrá ediciones
                  </label>
                </div>
                <hr />
                <div
                  id="confEdiciones"
                  rv-class-d-block="requireEdiciones"
                  style="display: none">
                  <h6>Ediciones</h6>
                  <div class="form-floating mb-3">
                    <select class="form-select" id="edicionSelect">
                      <option selected value="">
                        Seleccionar edición...
                      </option>
                      <option
                        rv-each-edicion="edicionesProdSel"
                        rv-value="edicion.id">
                        {edicion.nombre}
                      </option>
                      <option value="new">Crear nueva edición</option>
                    </select>
                    <label for="productoSelect">Ediciones</label>
                  </div>
                  <div
                    class="alert alert-secondary"
                    style="display: none"
                    id="edicionPanel">
                    <h6>Datos de la edición</h6>
                    <form id="formEdicion">
                      <div class="row g-1">
                        <div class="col-8 mb-1">
                          <div class="form-floating">
                            <input
                              type="text"
                              rv-value="edicionData.nombre"
                              class="form-control"
                              id="nombreEdicion"
                              placeholder="Nombre edicion"
                              required />
                            <label for="nombreProducto">Nombre edicion</label>
                          </div>
                        </div>
                        <div class="col-md-4 mb-1">
                          <div class="form-floating">
                            <input
                              type="number"
                              rv-value="edicionData.orden"
                              step="1"
                              min="0"
                              max="99"
                              class="form-control"
                              id="ordenEdicion"
                              placeholder="Orden en la lista"
                              required />
                            <label for="ordenEdicion">Orden en la lista</label>
                          </div>
                        </div>
                        <div class="col-md-4 mb-1">
                          <div class="form-check">
                            <input
                              class="form-check-input"
                              type="checkbox"
                              rv-checked="edicionData.activo"
                              value="1"
                              id="activoEdicion" />
                            <label
                              class="form-check-label"
                              for="activoEdicion">
                              Activa
                            </label>
                          </div>
                        </div>
                        <div class="col-12">
                          <input
                            type="submit"
                            class="btn btn-success"
                            value="Guardar" />
                          <button
                            type="button"
                            class="btn btn-danger float-end"
                            id="borrarEdicion"
                            title="borrar edicion"
                            rv-if="edicionData.id">
                            <i class="fa-solid fa-trash-can"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <hr />

                <div id="costosProducto" style="display: none">
                  <div class="mb-1">
                    <h6 class="d-inline-block">Costos</h6>
                    <button class="btn btn-sm btn-info" id="agregarCosto">
                      agregar
                    </button>
                  </div>

                  <div
                    class="alert alert-secondary"
                    id="costoPanel"
                    style="display: none">
                    <form id="formCosto">
                      <div class="row g-1">
                        <div class="col-4 mb-1">
                          <div class="form-floating">
                            <input
                              type="number"
                              rv-value="costoData.num_usuarios"
                              class="form-control"
                              id="numUsuariosCosto"
                              placeholder="Numero de usuarios"
                              required />
                            <label for="numUsuariosCosto">Numero de usuarios</label>
                          </div>
                        </div>
                        <div class="col-md-4 mb-1">
                          <div class="form-floating">
                            <input
                              type="number"
                              rv-value="costoData.precio"
                              step="0.01"
                              min="1"
                              class="form-control"
                              id="precioCosto"
                              placeholder="Precio"
                              required />
                            <label for="precioCosto">Precio</label>
                          </div>
                        </div>
                        <div class="col-md-4 mb-1">
                          <div class="form-floating">
                            <input
                              type="number"
                              rv-value="costoData.orden"
                              step="1"
                              min="0"
                              max="99"
                              class="form-control"
                              id="ordeCosto"
                              placeholder="Orden"
                              required />
                            <label for="ordeCosto">Orden</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <input
                            type="submit"
                            class="btn btn-success"
                            value="Guardar" />
                          <button
                            type="button"
                            class="btn btn-danger float-end"
                            id="borrarCosto"
                            title="borrar costo"
                            rv-if="costoData.id">
                            <i class="fa-solid fa-trash-can"></i>
                          </button>
                        </div>
                        <small>Indique 0 en el numero de usuarios para especificar
                          usuarios ilimitados.</small>
                      </div>
                    </form>
                  </div>

                  <ul class="list-group list-group-flush">
                    <li
                      class="list-group-item d-flex justify-content-between align-items-center"
                      rv-each-costo="costosProdSel">
                      Precio: ${costo.precio} - Usuarios: {costo.num_usuarios}
                      <div class="btn-group btn-group-sm" role="group">
                        <button
                          type="button"
                          class="btn btn-info editarCosto"
                          title="editar"
                          rv-data-id="costo.id">
                          <i class="fa-solid fa-edit"></i>
                        </button>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div
            class="col-md-4 border-start border-secondary"
            style="--bs-border-opacity: 0.5">
            <h5>Códigos descuento</h5>
            <div class="form-floating mb-3">
              <select class="form-select" id="codigoSelect">
                <option selected value="">Seleccionar producto...</option>
                <option rv-each-codigo="codigos" rv-value="codigo.id">
                  {codigo.codigo}
                </option>
                <option disabled>------------</option>
                <option value="new">Crear nuevo</option>
              </select>
              <label for="codigoSelect">Código de descuento</label>
            </div>
            <div
              class="alert alert-secondary"
              style="display: none"
              id="codigoPanel">
              <h6>Datos del codigo</h6>
              <form id="formCodigo">
                <div class="row g-1">
                  <div class="col-6 mb-1">
                    <div class="form-floating">
                      <input
                        type="text"
                        rv-value="codigoData.codigo"
                        class="form-control"
                        id="codigoDescuento"
                        placeholder="Codigo"
                        required />
                      <label for="codigoDescuento">Codigo</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-1">
                    <div class="form-floating">
                      <input
                        type="number"
                        rv-value="codigoData.monto"
                        step="0.01"
                        min="0.01"
                        max="1"
                        class="form-control"
                        id="montoDescuento"
                        placeholder="Orden en la lista"
                        required />
                      <label for="montoDescuento">Cantidad descuento</label>
                    </div>
                    <small class="text-muted">La cantidad se define en decimales para ser convertido
                      a porcentaje despues</small>
                  </div>
                  <div class="col-md-4 mb-1">
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        rv-checked="codigoData.activo"
                        value="1"
                        id="activoCodigo" />
                      <label class="form-check-label" for="activoCodigo">
                        Activo
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <input
                      type="submit"
                      class="btn btn-success"
                      value="Guardar" />
                    <button
                      type="button"
                      class="btn btn-danger float-end"
                      id="borrarCodigo"
                      title="borrar producto"
                      rv-if="codigoData.id">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div
    class="d-flex w-100 h-100 bg-dark bg-opacity-50 text-light position-absolute justify-content-center text-center d-none"
    style="top: 0; left: 0; z-index: 9999"
    id="loadingPane">
    <div class="align-self-center">
      <div class="spinner-border" role="status"></div>
      <br />
      Procesando...
    </div>
  </div>
  <?php require_once('../mod/js.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/tinybind@1.0.0/dist/tinybind.min.js"></script>
  <script src="/tienda/js/editorPrecios.js"></script>
</body>

</html>