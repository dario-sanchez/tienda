mostrarLoading(true);
let requireEdiciones = 0;
let productos = [];
let ediciones = [];
let costos = [];
let edicionesProdSel = [];
let costosProdSel = [];
let codigos = [];
let miscelaneos = {
  dolar: 0,
  congelarDolar: 0,
  iva: 0,
  actualizacion1: 0,
  actualizacion2: 0,
  actualizacion3: 0,
  soporte1: 0,
  soporte5: 0,
  soporte10: 0,
  soporte20: 0,
};

let productoData = {
  id: null,
  nombre: "",
  orden: 99,
  por_usuario: 0,
  activo: 1,
  index: null,
};

let edicionData = {
  id: null,
  nombre: "",
  orden: 99,
  producto_id: 1,
  activo: 1,
  index: null,
};

let costoData = {
  id: null,
  producto_id: null,
  edicion_id: null,
  num_usuarios: null,
  precio: 0,
  orden: 99,
  index: null,
};

let codigoData = {
  id: null,
  codigo: "",
  monto: 0.1,
  activo: 1,
  index: null,
};
let view = null;

axios.get("/tienda/inc/controllers/productos/get.php?query=all").then((res) => {
  productos = res.data.productos;
  codigos = res.data.codigos;
  ediciones = res.data.ediciones;
  costos = res.data.costos;
  miscelaneos.dolar = res.data.miscelaneos.precio_dollar;
  miscelaneos.congelarDolar = res.data.miscelaneos.congelarDolar;
  miscelaneos.iva = res.data.miscelaneos.iva;
  miscelaneos.actualizacion1 = res.data.miscelaneos.soporte_year_1;
  miscelaneos.actualizacion2 = res.data.miscelaneos.soporte_year_2;
  miscelaneos.actualizacion3 = res.data.miscelaneos.soporte_year_3;
  miscelaneos.soporte1 = res.data.miscelaneos.soporte_hora_1;
  miscelaneos.soporte5 = res.data.miscelaneos.soporte_hora_5;
  miscelaneos.soporte10 = res.data.miscelaneos.soporte_hora_10;
  miscelaneos.soporte20 = res.data.miscelaneos.soporte_hora_20;

  view = tinybind.bind($("#app"), {
    requireEdiciones: requireEdiciones,
    productos: productos,
    edicionesProdSel: edicionesProdSel,
    edicionData: edicionData,
    costosProdSel: costosProdSel,
    costoData: costoData,
    miscelaneos: miscelaneos,
    codigos: codigos,
    productoData: productoData,
    codigoData: codigoData,
  });
  mostrarLoading(false);
});

$("#formMiscelaneos").on("submit", (e) => {
  e.preventDefault();
  console.log("enviado");
  axios
    .post("/tienda/inc/controllers/gestion/updateMiscelaneos.php", miscelaneos)
    .then((res) => {
      notify.success({
        msj: res.data,
      });
    })
    .catch((error) => {
      console.log(error);
    });
});

$("#productoSelect").on("change", (e) => {
  $("#edicionPanel").hide(200);
  $("#costosProducto").hide(200);
  $("#costoPanel").hide(200);
  requireEdiciones = 0;
  //   $("#checkEdiciones").hide(200);
  loadEdiciones();
  cleanEdicionData();
  loadCostos();
  cleanCostoData();

  $("#productoPanel").hide(200);
  cleanProductoData();
  if ($(e.currentTarget).val() === "") return;
  if ($(e.currentTarget).val() !== "new") {
    let id = $(e.currentTarget).val();
    let selProd = productos.filter((producto) => producto.id == id)[0];
    let index = productos.indexOf(selProd);
    productoData.id = selProd.id;
    productoData.nombre = selProd.nombre;
    productoData.orden = selProd.orden;
    productoData.por_usuario = selProd.por_usuario;
    productoData.activo = selProd.activo;
    productoData.index = index;

    // if (!productos[index].por_usuario) $("#checkEdiciones").show(200);
  }

  $("#productoPanel").show(200);
  $("#costosProducto").show(200);
});

$("#formProducto").on("submit", (e) => {
  e.preventDefault();
  axios
    .post("/tienda/inc/controllers/productos/save.php", productoData)
    .then((res) => {
      notify.success({
        msj: res.data.message,
      });
      if (res.data.action == "update")
        productos[productoData.index] = res.data.producto;
      if (res.data.action == "create") {
        productos.push(res.data.producto);
        productoData.id = res.data.producto.id;
        productoData.index = productos.length - 1;
      }
      view.sync();
      $("#productoSelect").val(res.data.producto.id);
    })
    .catch((error) => {
      console.log(error);
    });
});

$(document).on("click", "#borrarProducto", borrarProducto);

$("#edicionSelect").on("change", (e) => {
  $("#edicionPanel").hide(200);
  cleanEdicionData();
  loadCostos();

  if ($(e.currentTarget).val() === "") return;

  edicionData.producto_id = $("#productoSelect").val();
  if ($(e.currentTarget).val() !== "new") {
    let id = $(e.currentTarget).val();
    let selEd = ediciones.filter((producto) => producto.id == id)[0];
    let index = ediciones.indexOf(selEd);

    edicionData.id = selEd.id;
    edicionData.nombre = selEd.nombre;
    edicionData.orden = selEd.orden;
    edicionData.producto_id = selEd.producto_id;
    edicionData.activo = selEd.activo;
    edicionData.index = index;
  }

  $("#edicionPanel").show(200);
});

$("#formEdicion").on("submit", (e) => {
  e.preventDefault();
  axios
    .post("/tienda/inc/controllers/ediciones/save.php", edicionData)
    .then((res) => {
      notify.success({
        msj: res.data.message,
      });
      if (res.data.action == "update")
        ediciones[edicionData.index] = res.data.edicion;
      if (res.data.action == "create") {
        ediciones.push(res.data.edicion);
        edicionData.id = res.data.edicion.id;
        edicionData.index = ediciones.length - 1;
      }
      view.sync();
      loadEdiciones();
      $("#edicionSelect").val(res.data.edicion.id);
    })
    .catch((error) => {
      console.log(error);
    });
});

$(document).on("click", "#borrarEdicion", borrarEdicion);

$("#formCosto").on("submit", (e) => {
  e.preventDefault();
  axios
    .post("/tienda/inc/controllers/costos/save.php", costoData)
    .then((res) => {
      notify.success({
        msj: res.data.message,
      });
      if (res.data.action == "update") costos[costoData.index] = res.data.costo;
      if (res.data.action == "create") {
        costos.push(res.data.costo);
        costoData.id = res.data.costo.id;
        costoData.index = costos.length - 1;
      }
      view.sync();
      $("#costoPanel").hide(200);
      cleanCostoData();
      loadCostos();
    })
    .catch((error) => {
      console.log(error);
    });
});
$("#agregarCosto").on("click", newCosto);

$(document).on("click", "#borrarEdicion", borrarEdicion);

$("#codigoSelect").on("change", (e) => {
  $("#codigoPanel").hide(200);
  cleanCodigoData();
  if ($(e.currentTarget).val() === "") return;
  if ($(e.currentTarget).val() !== "new") {
    let id = $(e.currentTarget).val();
    let selCodigo = codigos.filter((producto) => producto.id == id)[0];
    let index = codigos.indexOf(selCodigo);

    codigoData.id = selCodigo.id;
    codigoData.codigo = selCodigo.codigo;
    codigoData.monto = selCodigo.monto;
    codigoData.activo = selCodigo.activo;
    codigoData.index = index;
  }
  $("#codigoPanel").show(200);
});

$("#formCodigo").on("submit", (e) => {
  e.preventDefault();
  axios
    .post("/tienda/inc/controllers/codigos/save.php", codigoData)
    .then((res) => {
      notify.success({
        msj: res.data.message,
      });
      if (res.data.action == "update")
        codigos[codigoData.index] = res.data.codigo;
      if (res.data.action == "create") {
        codigos.push(res.data.codigo);
        codigoData.id = res.data.codigo.id;
        codigoData.index = codigos.length - 1;
      }
      view.sync();
      $("#codigoSelect").val(res.data.codigo.id);
    })
    .catch((error) => {
      console.log(error);
    });
});

$(document).on("click", "#borrarCodigo", borrarCodigo);

$(document).on("click", ".editarCosto", (e) => {
  selectCosto(e);
});
$(document).on("click", "#borrarCosto", borrarCosto);

function selectCosto(e) {
  let id = $(e.currentTarget).data("id");
  $("#costoPanel").hide(200);
  cleanCostoData();
  let costoSel = costos.find((item) => item.id == id);
  let index = costos.indexOf(costoSel);

  costoData.id = costoSel.id;
  costoData.producto_id = costoSel.producto_id;
  costoData.edicion_id = costoSel.edicion_id;
  costoData.num_usuarios = costoSel.num_usuarios;
  costoData.precio = costoSel.precio;
  costoData.orden = costoSel.orden;
  costoData.index = index;

  $("#costoPanel").show(200);
}

function newCosto() {
  $("#costoPanel").hide(200);

  cleanCostoData();
  if (edicionData.id) {
    costoData.edicion_id = edicionData.id;
  } else {
    costoData.producto_id = productoData.id;
  }
  $("#costoPanel").show(200);
}

function borrarProducto() {
  if (confirm("Estas seguro de borrar el producto: " + productoData.nombre)) {
    axios
      .get(
        "/tienda/inc/controllers/productos/delete.php?producto=" +
          productoData.id
      )
      .then((res) => {
        notify.success({
          msj: res.data.message,
        });
        productos.splice(productoData.index, 1);

        cleanProductoData();
        $("#productoPanel").hide(200);

        view.sync();
      })
      .catch((error) => {
        console.log(error);
      });
  }
  return;
}

function borrarEdicion() {
  if (confirm("Estas seguro de borrar la edicion: " + edicionData.nombre)) {
    axios
      .get(
        "/tienda/inc/controllers/ediciones/delete.php?edicion=" + edicionData.id
      )
      .then((res) => {
        notify.success({
          msj: res.data.message,
        });
        ediciones.splice(edicionData.index, 1);

        loadEdiciones();
        cleanEdicionData();
        $("#edicionPanel").hide(200);

        view.sync();
      })
      .catch((error) => {
        console.log(error);
      });
  }
  return;
}

function borrarCosto() {
  if (confirm("¿Estas seguro de borrar el costo?")) {
    axios
      .get("/tienda/inc/controllers/costos/delete.php?costo=" + costoData.id)
      .then((res) => {
        notify.success({
          msj: res.data.message,
        });
        costos.splice(costoData.index, 1);

        loadCostos();
        cleanCostoData();
        $("#costoPanel").hide(200);

        view.sync();
      })
      .catch((error) => {
        console.log(error);
      });
  }
  return;
}

function borrarCodigo() {
  if (confirm("Estas seguro de borrar el codigo: " + codigoData.codigo)) {
    axios
      .get("/tienda/inc/controllers/codigos/delete.php?codigo=" + codigoData.id)
      .then((res) => {
        notify.success({
          msj: res.data.message,
        });
        codigos.splice(codigoData.index, 1);

        cleanCodigoData();
        $("#codigoPanel").hide(200);

        view.sync();
      })
      .catch((error) => {
        console.log(error);
      });
  }
  return;
}

function cleanProductoData() {
  productoData.id = null;
  productoData.nombre = "";
  productoData.orden = 99;
  productoData.por_usuario = 0;
  productoData.activo = 1;
  productoData.index = null;
}

function cleanEdicionData() {
  edicionData.id = null;
  edicionData.nombre = "";
  edicionData.producto_id = null;
  edicionData.orden = 99;
  edicionData.activo = 1;
  edicionData.index = null;
}

function cleanCostoData() {
  costoData.id = null;
  costoData.producto_id = null;
  costoData.edicion_id = null;
  costoData.num_usuarios = null;
  costoData.precio = 0;
  costoData.orden = 90;
  costoData.index = null;
}

function cleanCodigoData() {
  codigoData.id = null;
  codigoData.codigo = "";
  codigoData.monto = 0;
  codigoData.activo = 1;
  codigoData.index = null;
}

function loadEdiciones() {
  edicionesProdSel.splice(0, edicionesProdSel.length);

  ediciones
    .filter((edicion) => edicion.producto_id == $("#productoSelect").val())
    .forEach((item) => {
      edicionesProdSel.push(item);
    });
  view.models.requireEdiciones = edicionesProdSel.length;
  loadCostos();
}

function loadCostos() {
  costosProdSel.splice(0, costosProdSel.length);
  if (edicionesProdSel.length) {
    costos
      .filter((costo) => costo.edicion_id == $("#edicionSelect").val())
      .forEach((item) => {
        costosProdSel.push(item);
      });
  } else {
    costos
      .filter((costo) => costo.producto_id == $("#productoSelect").val())
      .forEach((item) => {
        costosProdSel.push(item);
      });
  }
}
