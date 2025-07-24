mostrarLoading(true);
let tablaOrden, costos, articulo;
let orden = {
  articulos: [],
  subTotal: null,
  descuento: null,
  descuentoPack: null,
  subtotal_descontado: null,
  cantidad_iva: null,
  total: null,
  tipo_cotizacion: 1, //1 cotizacion usd y mxn, 2 cotizacion usd sin iva, 3 orden de compra
  cupon: null,
  cupon_descuento: null,
  cupon_id: null,
  referencia: null,
  pack: false,
  comentarios: null,
  orden_antigua: null,
  id: null,
};

$(document).ready(function () {
  verificarGuardado();
  tablaOrden = $("#tablaOrden").DataTable({
    data: orden.articulos,
    // dom: 'Bfrtip',
    // buttons: [
    //   'pdf'
    // ],
    width: "100%",
    drawCallback: function (settings) {
      // Aplica colspan a la primera celda de cada fila
      $("#tablaOrden tbody tr").each(function () {
        $(this).find("td:first").attr("colspan", 2);
      });
      $("#tablaOrden tfoot tr").each(function () {
        $(this).find("td:first").attr("colspan", 2);
      });
    },
    columns: [
      {
        data: "producto_id",
        render: (data, type, row, meta) => {
          let producto,
            actualizacion = "",
            soporte = "",
            discont = "",
            costo = "",
            costoUpg = "";

          var html =
            '<table style="width: 100%;   border-spacing: 0;  border-collapse: collapse;"><tbody>';
          costo = costos.costos.filter((data) => data.id == row.costo_id);

          switch (row.tipo) {
            case 1:
              producto = `${row.producto_nombre}${
                row.edicion_nombre ? " - " + row.edicion_nombre : ""
              }${row.costo_nombre ? " - " + row.costo_nombre : ""}`;

              html +=
                '<tr style="border:solid 1px #ddd"><td style="width: 90%;border:solid 1px #ddd">' +
                producto +
                '</td> <td style="width: 10%; text-align: right;border:solid 1px #ddd">' +
                moneda.format(costo[0].precio.toFixed(2)) +
                "</td></tr>";
              break;
            case 2:
              producto = `Renovación: ${row.producto_nombre}${
                row.edicion_nombre ? " - " + row.edicion_nombre : ""
              }${row.costo_nombre ? " - " + row.costo_nombre : ""}`;

              html +=
                '<tr style="border:solid 1px #ddd"><td style="width: 90%;border:solid 1px #ddd">' +
                producto +
                '</td> <td style="width: 10%; text-align: right;border:solid 1px #ddd">' +
                moneda.format((0).toFixed(2)) +
                "</td></tr>";
              break;
            case 3:
              costoUpg = costos.costos.filter(
                (data) => data.id == row.upg_costo_id
              );

              producto = `<div class='text-primary'>Upgrade de producto:<br>
                            <p>${row.producto_nombre}${
                row.edicion_nombre ? " - " + row.edicion_nombre : ""
              }${row.costo_nombre ? " - " + row.costo_nombre : ""}</p></div>
                            <div class='text-success'>A nueva configuración:<br>
                            <p>${row.producto_nombre}${
                row.upg_edicion_nombre ? " - " + row.upg_edicion_nombre : ""
              }${
                row.upg_costo_nombre ? " - " + row.upg_costo_nombre : ""
              }</p></div>
                            `;

              let montoVal =
                (costoUpg[0].precio.toFixed(2) - costo[0].precio.toFixed(2)) *
                1.1;
              html +=
                '<tr style="border:solid 1px #ddd"><td style="width: 90%;border:solid 1px #ddd">' +
                producto +
                '</td> <td style="width: 10%; text-align: right;border:solid 1px #ddd">' +
                moneda.format(montoVal) +
                "</td></tr>";
              break;
          }

          if (row.actualizacion_years > 0) {
            // let porUpdate =
            //   costos.miscelaneos["soporte_year_" + row.actualizacion_years];
            // let updateCost = (
            //   row.costo_subtotal *
            //   (porUpdate / 100) *
            //   row.actualizacion_years
            // ).toFixed(2);

            actualizacion = `
                        <p class="mb-0">
                            Actualización: ${row.actualizacion_years + " años"}
                        </p>
                    `;

            html +=
              '<tr style="border:solid 1px #ddd"><td style="width: 90%;border:solid 1px #ddd">' +
              actualizacion +
              '</td> <td style="width: 10%; text-align: right;border:solid 1px #ddd">' +
              moneda.format(row.actualizacion_costo) +
              "</td></tr>";
          }

          if (row.soporte_hours > 0) {
            soporte = `<p class="mb-0">
              Soporte: ${row.soporte_hours + " horas"}
              </p>`;
            if (orden.orden_antigua || orden.orden_antigua == null) {
              html +=
                '<tr style="border:solid 1px #ddd"><td style="width: 90%;border:solid 1px #ddd">' +
                soporte +
                '</td> <td style="width: 10%; text-align: right;border:solid 1px #ddd">' +
                moneda.format(costos.miscelaneos["soporte_hora_1"].toFixed(2)) +
                "</td></tr>";
            } else {
              html +=
                '<tr style="border:solid 1px #ddd"><td style="width: 90%;border:solid 1px #ddd">' +
                soporte +
                '</td> <td style="width: 10%; text-align: right;border:solid 1px #ddd">' +
                moneda.format(
                  costos.miscelaneos[
                    "soporte_hora_" + row.soporte_hours
                  ].toFixed(2)
                ) +
                "</td></tr>";
            }
          }
          if (row.tipo == 1) {
            if (
              $.inArray(parseInt(row.producto_id), [2, 4, 6]) != -1 &&
              orden.pack
            ) {
              discont = '<p class="mb-0 fw-bold">Descuento: 10%</p>';

              html +=
                '<tr style="border:solid 1px #ddd"><td style="width: 90%;border:solid 1px #ddd">' +
                discont +
                '</td> <td style="width: 10%; text-align: right;border:solid 1px #ddd"></td></tr>';
            }
          }

          // return producto + actualizacion + soporte + discont;

          html += "</tbody></table>";
          return html;
        },
        defaultContent: "<i class='text-muted text-center d-block'> - </i>",
      },
      // {
      //   className: "text-center",
      //   data: null,
      //   visible: false,
      // },
      {
        className: "text-center",
        data: "cantidad",
      },
      {
        className: "text-end",
        data: "costo_producto_total",
        render: (data, type, row, meta) => {
          return moneda.format(data.toFixed(2));
        },
      },
      {
        className: "text-end",
        data: "costo_producto_total",
        render: (data, type, row, meta) => {
          return moneda.format(
            (data * costos.miscelaneos.precio_dollar).toFixed(2)
          );
        },
      },
      {
        className: "text-end",
        data: null,
        render: (data, type, row, meta) => {
          let url = new URL(window.location.href);
          let ver = url.searchParams.get("ver");
          if (ver) return;

          let btnData = `data-row = "${meta.row}"`;
          return `<button class="btn btn-sm btn-link text-muted btnEliminarArticulo" ${btnData}><i class="fas fa-times-circle"></i></button>`;
        },
        defaultContent: "",
      },
    ],
    searching: false,
    ordering: false,
    paging: false,
    info: false,
    processing: false,
    serverSide: false,
    lengthChange: false,
    responsive: true,
    language: {
      aria: {
        sortAscending: "Activar para ordenar la columna de manera ascendente",
        sortDescending: "Activar para ordenar la columna de manera descendente",
      },
      autoFill: {
        cancel: "Cancelar",
        fill: "Rellene todas las celdas con <i>%d</i>",
        fillHorizontal: "Rellenar celdas horizontalmente",
        fillVertical: "Rellenar celdas verticalmente",
      },
      buttons: {
        collection: "Colección",
        colvis: "Visibilidad",
        colvisRestore: "Restaurar visibilidad",
        copy: "Copiar",
        copyKeys:
          "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
        copySuccess: {
          1: "Copiada 1 fila al portapapeles",
          _: "Copiadas %d fila al portapapeles",
        },
        copyTitle: "Copiar al portapapeles",
        csv: "CSV",
        excel: "Excel",
        pageLength: {
          "-1": "Mostrar todas las filas",
          _: "Mostrar %d filas",
        },
        pdf: "PDF",
        print: "Imprimir",
        createState: "Crear Estado",
        removeAllStates: "Borrar Todos los Estados",
        removeState: "Borrar Estado",
        renameState: "Renombrar Estado",
        savedStates: "Guardar Estado",
        stateRestore: "Restaurar Estado",
        updateState: "Actualizar Estado",
      },
      infoThousands: ",",
      loadingRecords: "Cargando...",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior",
      },
      processing: "Procesando...",
      search: "Buscar:",
      searchBuilder: {
        add: "Añadir condición",
        button: {
          0: "Constructor de búsqueda",
          _: "Constructor de búsqueda (%d)",
        },
        clearAll: "Borrar todo",
        condition: "Condición",
        deleteTitle: "Eliminar regla de filtrado",
        leftTitle: "Criterios anulados",
        logicAnd: "Y",
        logicOr: "O",
        rightTitle: "Criterios de sangría",
        title: {
          0: "Constructor de búsqueda",
          _: "Constructor de búsqueda (%d)",
        },
        value: "Valor",
        conditions: {
          date: {
            after: "Después",
            before: "Antes",
            between: "Entre",
            empty: "Vacío",
            equals: "Igual a",
            not: "Diferente de",
            notBetween: "No entre",
            notEmpty: "No vacío",
          },
          number: {
            between: "Entre",
            empty: "Vacío",
            equals: "Igual a",
            gt: "Mayor a",
            gte: "Mayor o igual a",
            lt: "Menor que",
            lte: "Menor o igual a",
            not: "Diferente de",
            notBetween: "No entre",
            notEmpty: "No vacío",
          },
          string: {
            contains: "Contiene",
            empty: "Vacío",
            endsWith: "Termina con",
            equals: "Igual a",
            not: "Diferente de",
            startsWith: "Inicia con",
            notEmpty: "No vacío",
            notContains: "No Contiene",
            notEnds: "No Termina",
            notStarts: "No Comienza",
          },
          array: {
            equals: "Igual a",
            empty: "Vacío",
            contains: "Contiene",
            not: "Diferente",
            notEmpty: "No vacío",
            without: "Sin",
          },
        },
        data: "Datos",
      },
      searchPanes: {
        clearMessage: "Borrar todo",
        collapse: {
          0: "Paneles de búsqueda",
          _: "Paneles de búsqueda (%d)",
        },
        count: "{total}",
        emptyPanes: "Sin paneles de búsqueda",
        loadMessage: "Cargando paneles de búsqueda",
        title: "Filtros Activos - %d",
        countFiltered: "{shown} ({total})",
        collapseMessage: "Colapsar",
        showMessage: "Mostrar Todo",
      },
      select: {
        cells: {
          1: "1 celda seleccionada",
          _: "%d celdas seleccionadas",
        },
        columns: {
          1: "1 columna seleccionada",
          _: "%d columnas seleccionadas",
        },
      },
      thousands: ",",
      datetime: {
        previous: "Anterior",
        hours: "Horas",
        minutes: "Minutos",
        seconds: "Segundos",
        unknown: "-",
        amPm: ["am", "pm"],
        next: "Siguiente",
        months: {
          0: "Enero",
          1: "Febrero",
          10: "Noviembre",
          11: "Diciembre",
          2: "Marzo",
          3: "Abril",
          4: "Mayo",
          5: "Junio",
          6: "Julio",
          7: "Agosto",
          8: "Septiembre",
          9: "Octubre",
        },
        weekdays: [
          "Domingo",
          "Lunes",
          "Martes",
          "Miércoles",
          "Jueves",
          "Viernes",
          "Sábado",
        ],
      },
      editor: {
        close: "Cerrar",
        create: {
          button: "Nuevo",
          title: "Crear Nuevo Registro",
          submit: "Crear",
        },
        edit: {
          button: "Editar",
          title: "Editar Registro",
          submit: "Actualizar",
        },
        remove: {
          button: "Eliminar",
          title: "Eliminar Registro",
          submit: "Eliminar",
          confirm: {
            _: "¿Está seguro que desea eliminar %d filas?",
            1: "¿Está seguro que desea eliminar 1 fila?",
          },
        },
        multi: {
          title: "Múltiples Valores",
          restore: "Deshacer Cambios",
          noMulti:
            "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
          info: "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, haga click o toque aquí, de lo contrario conservarán sus valores individuales.",
        },
        error: {
          system:
            'Ha ocurrido un error en el sistema (<a target="\\" rel="\\ nofollow" href="\\"> Más información</a>).',
        },
      },
      decimal: ".",
      emptyTable: "Agrega algun producto a tu orden.",
      zeroRecords: "No se encontraron coincidencias",
      info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
      infoEmpty: "Mostrando 0 a 0 de 0 entradas",
      infoFiltered: "(Filtrado de _MAX_ total de entradas)",
      lengthMenu: "Mostrar _MENU_ entradas",
      stateRestore: {
        removeTitle: "Eliminar",
        creationModal: {
          search: "Buscar",
        },
      },
    },
  });

  cargarForm();
});

$("#software").on("change", cargarEdiciones);

$("#edicion").on("change", cargarModalidades);

$("#modalidad").on("change", (e) => {
  if ($("#tipoArticulo").val() == 3) cargarUpgrades();
});

$("#formArticulo").on("change", cotizarProducto);

$("#formArticulo").on("submit", (e) => {
  e.preventDefault();
  orden.articulos.push(articulo);
  // checkPack();
  recargarTabla();
  $(e.currentTarget).trigger("reset");
  cotizarProducto();
});

$("#btnValidarCodigo").on("click", validarCodigo);

$("#tipoOrden").on("change", (e) => {
  orden.tipo_cotizacion = $(e.currentTarget).val();
  let column = tablaOrden.column(3);
  if (orden.tipo_cotizacion != "2") {
    column.visible(true);
    $("#rowIVA").show(200);
  } else {
    column.visible(false);
    $("#rowIVA").hide(200);
  }
  cotizarSubTotales();
});

$(document).on("click", ".btnEliminarArticulo", (e) => {
  orden.articulos.splice($(e.currentTarget).data("row"), 1);
  // checkPack();
  recargarTabla();
});

$("#btnGuardarOrden").on("click", (e) => {
  guardarOrden();
});

$("#btnPagarOrden").on("click", (e) => {
  if (orden.articulos.length) {
    new bootstrap.Modal($("#modalPago")).show();
  } else {
    alert("Debes agregar articulos a la orden.");
  }
});

$("#tipoArticulo").on("change", (e) => {
  $("#cantidadBlock").removeClass("d-none");
  $("#cantidad").val(1);
  $("#upgradeBlock").addClass("d-none");
  if ($(e.currentTarget).val() == 3) {
    $("#upgradeBlock").removeClass("d-none");
    $("#cantidadBlock").addClass("d-none");
    $("#cantidad").val(1);
    cargarUpgrades();
  }
  cotizarProducto();
});

$("#edicionUpgrade").on("change", cargarModalidadesUpgrade);

$("#formEmailCotizacion").on("submit", (e) => {
  e.preventDefault();
  guardarOrden(false);
  mostrarLoading(true);
  let myForm = document.getElementById("formEmailCotizacion");
  let formData = new FormData(myForm);
  formData.append("orden_id", orden.id);
  axios
    .post(`/tienda/inc/controllers/emails/recibo.php`, formData)
    .then((res) => {
      notify.success({msj: "Cotizacion enviada"});
      mostrarLoading(false);
    })
    .catch((error) => {
      console.error(error.response.data);
      mostrarLoading(false);
    });
});

function cargarForm() {
  // if( $('#modificacion').length ) orden.tipo_cotizacion = parseInt( $('#modificacion').val() );
  axios
    .get("/tienda/inc/controllers/productos/get.php?query=all")
    .then(async (res) => {
      costos = await res.data;
      $("#software").empty();
      costos.productos.forEach((item) => {
        let opcion = `<option value='${item.id}'>${item.nombre}</option>`;
        $("#software").append(opcion);
      });
      $(".costoDolar").text(costos.miscelaneos.precio_dollar.toFixed(2));
      cargarEdiciones();
      cotizarProducto();
      cargarOrden();
      mostrarLoading(false);
    });
}

function cargarEdiciones() {
  $(
    "#blockModalidades, #blockEdiciones, #blockActualizaciones, #celdaActualizaciones"
  ).addClass("d-none");
  $("#edicion, #modalidad, #actualizaciones").prop("disabled", true);
  $("#edicion, #modalidad").empty();
  let value = costos.ediciones.filter(
    (data) => data.producto_id == $("#software").val()
  );
  if (value.length) {
    value.forEach((item) => {
      let opcion = `<option value='${item.id}'>${item.nombre}</option>`;
      $("#edicion").append(opcion);
    });
    $("#blockEdiciones").removeClass("d-none");
    $("#edicion").prop("disabled", false);

    let selectedProd = costos.productos.filter(
      (data) => data.id == $("#software").val()
    );
    console.log(selectedProd);
    if (selectedProd[0].puedeActualizar) {
      $("#blockActualizaciones, #celdaActualizaciones").removeClass("d-none");
      $("#actualizaciones").prop("disabled", false);
    }
  }
  cargarModalidades();
}

function cargarModalidades() {
  $("#blockModalidades").addClass("d-none");
  $("#modalidad").prop("disabled", true);
  $("#modalidad").empty();
  let value = costos.costos.filter(
    (data) => data.edicion_id == $("#edicion").val()
  );
  if (!value.length)
    value = costos.costos.filter(
      (data) => data.producto_id == $("#software").val()
    );

  if (value.length > 1) {
    value.forEach((item) => {
      let nombre;
      if (item.num_usuarios)
        nombre = `Licencia para ${item.num_usuarios} usuarios`;
      if (item.num_usuarios === 0) nombre = `Licencia para usuarios ilimitados`;
      if (item["2fa"]) nombre = "Two Factors Authentication (2FA)";
      let opcion = `<option value='${item.id}'>${nombre}</option>`;
      $("#modalidad").append(opcion);
    });
    $("#blockModalidades").removeClass("d-none");
    $("#modalidad").prop("disabled", false);
  }

  if ($("#tipoArticulo").val() == 3) cargarUpgrades();
}

function cargarUpgrades() {
  $("#blockModalidadesUpgrade, #blockEdicionesUpgrade").addClass("d-none");
  $("#modalidadUpgrade, #edicionUpgrade").prop("disabled", true);
  $("#edicionUpgrade, #modalidadUpgrade").empty();

  if ($("#edicion").val()) {
    let edicionSel = costos.ediciones.filter(
      (data) => data.id == $("#edicion").val()
    );
    let edicionesUp = costos.ediciones.filter((data) => {
      if (data.producto_id == edicionSel[0].producto_id)
        if (data.orden >= edicionSel[0].orden) return true;

      return false;
    });
    if (edicionesUp.length) {
      edicionesUp.forEach((item) => {
        let opcion = `<option value='${item.id}'>${item.nombre}</option>`;
        $("#edicionUpgrade").append(opcion);
      });
    }
  }

  if ($("#modalidad").val()) {
    let modSel = costos.costos.filter(
      (data) => data.id == $("#modalidad").val()
    );
    let modalidadesUp = costos.costos.filter((data) => {
      if (data.edicion_id == modSel[0].edicion_id)
        if (data.orden > modSel[0].orden) return true;
      return false;
    });

    if (modalidadesUp.length) {
      modalidadesUp.forEach((item) => {
        let nombre;
        if (item.num_usuarios)
          nombre = `Licencia para ${item.num_usuarios} usuarios`;
        if (item.num_usuarios === 0)
          nombre = `Licencia para usuarios ilimitados`;
        if (item["2fa"]) nombre = "Two Factors Authentication (2FA)";
        let opcion = `<option value='${item.id}'>${nombre}</option>`;
        $("#modalidadUpgrade").append(opcion);
      });
    }
  }

  if (!$("#blockEdiciones").hasClass("d-none"))
    $("#blockEdicionesUpgrade").removeClass("d-none");

  if (!$("#blockModalidades").hasClass("d-none"))
    $("#blockModalidadesUpgrade").removeClass("d-none");

  $("#edicionUpgrade").prop("disabled", $("#edicion").prop("disabled"));
  $("#modalidadUpgrade").prop("disabled", $("#modalidad").prop("disabled"));
}

function cargarModalidadesUpgrade() {
  $("#modalidadUpgrade").empty();
  let value;
  let modSel = costos.costos.filter((data) => data.id == $("#modalidad").val());

  if ($("#edicionUpgrade").val() == $("#edicion").val()) {
    value = costos.costos.filter((data) => {
      if (
        data.edicion_id == modSel[0].edicion_id &&
        data.orden > modSel[0].orden
      )
        return true;
    });
  } else {
    value = costos.costos.filter((data) => {
      if (
        data.edicion_id == $("#edicionUpgrade").val() &&
        data.orden >= modSel[0].orden
      ) {
        return true;
      }
    });
  }
  if (value.length >= 1) {
    value.forEach((item) => {
      let nombre;
      if (item.num_usuarios)
        nombre = `Licencia para ${item.num_usuarios} usuarios`;
      if (item.num_usuarios === 0) nombre = `Licencia para usuarios ilimitados`;
      if (item["2fa"]) nombre = "Two Factors Authentication (2FA)";
      let opcion = `<option value='${item.id}'>${nombre}</option>`;
      $("#modalidadUpgrade").append(opcion);
    });
  }
}

function cotizarProducto() {
  let url = new URL(window.location.href);
  let ver = url.searchParams.get("ver");
  if (ver) return false;
  $("#addArticulo").addClass("d-none").prop("disabled", true);

  $(
    "#descProdcuto, #costoProducto, #cantidadProducto, #subTotalProducto, #porcentajeAct, #cantAct, #costoAct, #porcentajeSop, #cantSop, #costoSop, #totalProdcuto"
  ).empty();
  let actualizacionesField = document.getElementById("#actualizaciones");

  articulo = {
    tipo: parseInt($("#tipoArticulo").val()),
    producto_id: $("#software").val(),
    producto_nombre: $("#software option:selected").text(),
    edicion_id: $("#edicion").val(),
    edicion_nombre: $("#edicion option:selected").text(),
    costo_id: $("#modalidad").val(),
    costo_nombre: $("#modalidad option:selected").text(),
    upg_edicion_id: $("#edicionUpgrade").val(),
    upg_edicion_nombre: $("#edicionUpgrade option:selected").text(),
    upg_costo_id: $("#modalidadUpgrade").val(),
    upg_costo_nombre: $("#modalidadUpgrade option:selected").text(),
    costo_precio: null,
    costo_subtotal: null,
    cantidad: $("#cantidad").val(),
    actualizacion_years: $("#actualizaciones").val(),
    actualizacion_years: !$("#actualizaciones").prop("disabled")
      ? $("#actualizaciones").val()
      : 0,
    actualizacion_porcentaje: 0,
    actualizacion_costo: 0,
    soporte_hours: $("#soporte").val(),
    soporte_costo: 0,
    clave: $("#clave").val(),
    costo_producto_total: null,
  };

  if (!articulo.costo_id) {
    if (articulo.edicion_id) {
      let value = costos.costos.filter(
        (data) => data.edicion_id == $("#edicion").val()
      );
      articulo.costo_id = value[0].id;
      articulo.costo_nombre = null;
    } else {
      let value = costos.costos.filter(
        (data) => data.producto_id == $("#software").val()
      );
      articulo.costo_id = value[0].id;
      articulo.costo_nombre = null;
    }
  }

  if (articulo.tipo == 3) {
    if (!articulo.upg_costo_id) {
      if (articulo.upg_edicion_id) {
        let value = costos.costos.filter(
          (data) => data.edicion_id == articulo.upg_edicion_id
        );
        articulo.upg_costo_id = value[0].id;
        articulo.upg_costo_nombre = null;
      } else {
        let value = costos.costos.filter(
          (data) => data.producto_id == articulo.producto_id
        );
        articulo.upg_costo_id = value[0].id;
        articulo.costo_nombre = null;
      }
    }
  }

  switch (articulo.tipo) {
    case 1:
    case 2:
      valor = costos.costos.filter((data) => data.id == articulo.costo_id);
      articulo.costo_precio = valor[0].precio;
      articulo.costo_subtotal = valor[0].precio * articulo.cantidad;
      break;
    case 3:
      valor = costos.costos.filter((data) => data.id == articulo.costo_id);
      valorUp = costos.costos.filter(
        (data) => data.id == articulo.upg_costo_id
      );
      articulo.costo_precio = (valorUp[0].precio - valor[0].precio) * 1.1;
      articulo.costo_subtotal = articulo.costo_precio;
      break;
  }

  if (articulo.actualizacion_years != 0) {
    articulo.actualizacion_porcentaje =
      costos.miscelaneos["soporte_year_" + articulo.actualizacion_years];
    if (articulo.tipo === 3) {
      articulo.actualizacion_costo =
        valorUp[0].precio *
        (articulo.actualizacion_porcentaje / 100) *
        articulo.actualizacion_years;
    } else {
      articulo.actualizacion_costo =
        articulo.costo_subtotal *
        (articulo.actualizacion_porcentaje / 100) *
        articulo.actualizacion_years;
    }
  }

  if (articulo.soporte_hours != 0)
    if (orden.orden_antigua || orden.orden_antigua == null) {
      articulo.soporte_costo =
        costos.miscelaneos["soporte_hora_1"] * articulo.soporte_hours;
    } else {
      articulo.soporte_costo =
        costos.miscelaneos["soporte_hora_" + articulo.soporte_hours];
    }

  //producto
  switch (articulo.tipo) {
    case 1:
      articulo.costo_producto_total =
        articulo.costo_subtotal +
        articulo.actualizacion_costo +
        articulo.soporte_costo;
      $("#descProdcuto").text(
        `${articulo.producto_nombre}${
          articulo.edicion_nombre ? " - " + articulo.edicion_nombre : ""
        }${articulo.costo_nombre ? " - " + articulo.costo_nombre : ""}`
      );
      break;
    case 2:
      articulo.costo_producto_total =
        articulo.actualizacion_costo + articulo.soporte_costo;
      $("#descProdcuto").text(
        `Renovacion: ${articulo.producto_nombre}${
          articulo.edicion_nombre ? " - " + articulo.edicion_nombre : ""
        }${articulo.costo_nombre ? " - " + articulo.costo_nombre : ""}`
      );
      break;
    case 3:
      descArticulo = `<div class='text-primary'>Upgrade de producto:<br>
            <p>${articulo.producto_nombre}${
        articulo.edicion_nombre ? " - " + articulo.edicion_nombre : ""
      }${articulo.costo_nombre ? " - " + articulo.costo_nombre : ""}</p></div>
            <div class='text-success'>A nueva configuracion:<br>
            <p>${articulo.producto_nombre}${
        articulo.upg_edicion_nombre ? " - " + articulo.upg_edicion_nombre : ""
      }${
        articulo.upg_costo_nombre ? " - " + articulo.upg_costo_nombre : ""
      }</p></div>
            `;
      articulo.costo_producto_total =
        articulo.costo_subtotal +
        articulo.actualizacion_costo +
        articulo.soporte_costo;
      $("#descProdcuto").html(descArticulo);
      break;
  }

  $("#costoProducto").text(
    articulo.tipo == 2 ? "$0" : moneda.format(articulo.costo_precio.toFixed(2))
  );
  $("#cantidadProducto").text("x " + articulo.cantidad);
  $("#subTotalProducto").text(
    articulo.tipo == 2
      ? "$0"
      : moneda.format(articulo.costo_subtotal.toFixed(2))
  );

  //actualisaciones
  $("#yearsAct").text(articulo.actualizacion_years + " años");
  $("#porcentajeAct").text(articulo.actualizacion_porcentaje + "%");
  $("#cantAct").text("x " + articulo.actualizacion_years);
  $("#costoAct").text(moneda.format(articulo.actualizacion_costo.toFixed(2)));

  //soporte
  // $('#yearsSop').text(articulo.soporte_hours+' horas');
  $("#cantSop").text(articulo.soporte_hours + " horas");
  $("#costoSop").text(moneda.format(articulo.soporte_costo.toFixed(2)));

  //total
  $("#totalProdcuto").text(
    moneda.format(articulo.costo_producto_total.toFixed(2))
  );

  verficaArticulo();
}

function cotizarSubTotales() {
  $("#rowDescuento").addClass("d-none");
  if (!orden.articulos.length) {
    $(".subTotales").empty();
    orden.subTotal = null;
    orden.descuento = null;
    orden.descuentoPack = null;
    orden.subtotal_descontado = null;
    orden.cantidad_iva = null;
    orden.total = null;
    return false;
  }

  let subTotal = 0,
    cantidadIva = 0,
    subTotalDescontado = 0,
    total = 0;

  orden.articulos.forEach((item) => {
    subTotal = subTotal + item.costo_producto_total;
  });

  // if (orden.pack) {
  //   $(".descontPack").removeClass("d-none");
  //   let totalPack = 0;
  //   orden.articulos.forEach((articulo) => {
  //     if (articulo.tipo === 1)
  //       if ($.inArray(parseInt(articulo.producto_id), [2, 4, 6]) != -1)
  //         totalPack = totalPack + articulo.costo_producto_total;
  //   });
  //   orden.descuentoPack = totalPack * 0.1;

  //   $("#descuentoPackUSD").text(
  //     "-" + moneda.format(orden.descuentoPack.toFixed(2))
  //   );
  //   $("#descuentoPackMXN").text(
  //     "-" +
  //       moneda.format(
  //         (orden.descuentoPack * costos.miscelaneos.precio_dollar).toFixed(2)
  //       )
  //   );
  // }

  descuento = orden.cupon_descuento ? subTotal * orden.cupon_descuento : 0;
  subTotalDescontado = subTotal - descuento;
  // if (orden.pack) subTotalDescontado = subTotalDescontado - orden.descuentoPack;
  if (orden.tipo_cotizacion != 2)
    cantidadIva = subTotalDescontado * (costos.miscelaneos.iva / 100);
  total = subTotalDescontado + cantidadIva;

  orden.subTotal = subTotal;
  orden.descuento = descuento;
  orden.subtotal_descontado = subTotalDescontado;
  orden.cantidad_iva = cantidadIva;
  orden.total = total;

  $("#subtotalOrdenUSD").text(moneda.format(orden.subTotal.toFixed(2)));
  $("#subtotalOrdenMXN").text(
    moneda.format(
      (orden.subTotal * costos.miscelaneos.precio_dollar).toFixed(2)
    )
  );

  if (orden.descuento > 0) {
    $("#rowDescuento").removeClass("d-none");
    $("#descuentoCuponUSD").text(
      "-" + moneda.format(orden.descuento.toFixed(2))
    );
    $("#descuentoCuponMXN").text(
      "-" +
        moneda.format(
          (orden.descuento * costos.miscelaneos.precio_dollar).toFixed(2)
        )
    );
  }

  $("#subtotalOrdenDescontadoUSD").text(
    moneda.format(orden.subtotal_descontado.toFixed(2))
  );
  $("#subtotalOrdenDescontadoMXN").text(
    moneda.format(
      (orden.subtotal_descontado * costos.miscelaneos.precio_dollar).toFixed(2)
    )
  );

  $("#ivaOrdenUSD").text(moneda.format(orden.cantidad_iva.toFixed(2)));
  $("#ivaOrdenMXN").text(
    moneda.format(
      (orden.cantidad_iva * costos.miscelaneos.precio_dollar).toFixed(2)
    )
  );

  $("#totalOrdeUSD").text(moneda.format(orden.total.toFixed(2)));
  $("#totalOrdeMXN").text(
    moneda.format((orden.total * costos.miscelaneos.precio_dollar).toFixed(2))
  );
  $(".totalPago").text(
    moneda.format((orden.total * costos.miscelaneos.precio_dollar).toFixed(2))
  );
}

function validarCodigo() {
  axios
    .get(
      `/tienda/inc/controllers/codigos/get.php?codigo=${$(
        "#codigoDescuento"
      ).val()}`
    )
    .then((res) => {
      if (res.data) {
        orden.cupon = res.data.codigo;
        orden.cupon_descuento = res.data.monto;
        orden.cupon_id = res.data.id;
        $("#indicadorCodigoDesc").removeClass("d-none");
        $("#labelCodigo").text(
          orden.cupon + " - " + orden.cupon_descuento * 100 + "%"
        );
      } else {
        orden.cupon = null;
        orden.cupon_descuento = null;
        orden.cupon_id = null;
        $("#indicadorCodigoDesc").addClass("d-none");
        $("#labelCodigo").empty();
      }
      cotizarSubTotales();
    });
}

function recargarTabla() {
  tablaOrden.clear();
  tablaOrden.rows.add(orden.articulos).draw();
  cotizarSubTotales();
}

function guardarOrden(show = true) {
  if (show) mostrarLoading(true);
  orden.comentarios = $("#comentarios").val();
  let url = orden.id
    ? `/tienda/inc/controllers/ordenes/update.php`
    : `/tienda/inc/controllers/ordenes/create.php`;
  axios
    .post(url, orden)
    .then((res) => {
      if (orden.id) {
        if (show) notify.success({msj: res.data});
        if (show) mostrarLoading(false);
      } else {
        sessionStorage.setItem("store_success", true);
        window.location.replace(window.location.href + "?orden=" + res.data.id);
      }
    })
    .catch((error) => {
      console.log(error);
      if (show) mostrarLoading(false);
    });
}

function cargarOrden() {
  let url = new URL(window.location.href);
  let id = url.searchParams.get("orden");
  if (id) {
    axios
      .get(`/tienda/inc/controllers/ordenes/get.php?orden=${id}`)
      .then((res) => {
        orden.orden_antigua = res.data.orden_antigua;
        orden.tipo_cotizacion = res.data.tipo_cotizacion;
        orden.cupon = res.data.codigo_descuento
          ? res.data.codigo_descuento.codigo
          : null;
        orden.cupon_descuento = res.data.codigo_descuento
          ? res.data.codigo_descuento.monto
          : null;
        orden.cupon_id = res.data.codigo_descuento_id;
        orden.referencia = res.data.referencia;
        if (res.data.comentarios) {
          orden.comentarios = res.data.comentarios;
          $("#comentarios").val(res.data.comentarios);
        }
        if (res.data.estatus === 1) {
          $("#btnPagarOrden").removeClass("d-none");
        }
        orden.id = res.data.id;

        res.data.articulos.forEach((element) => {
          let nombreCosto = null;
          if (element.costo.num_usuarios)
            nombreCosto = `Licencia para ${element.costo.num_usuarios} usuarios`;
          if (element.costo.num_usuarios === 0)
            nombreCosto = `Licencia para usuarios ilimitados`;
          if (element.costo["2fa"])
            nombreCosto = "Two Factors Authentication (2FA)";

          let upgNombreCosto = null;
          if (element.tipo == 3) {
            if (element.costo_upg.num_usuarios)
              upgNombreCosto = `Licencia para ${element.costo_upg.num_usuarios} usuarios`;
            if (element.costo_upg.num_usuarios === 0)
              upgNombreCosto = `Licencia para usuarios ilimitados`;
            if (element.costo_upg["2fa"])
              upgNombreCosto = "Two Factors Authentication (2FA)";
          }

          articuloTemp = {
            id: element.id,
            orden_id: element.orden_id,
            tipo: element.tipo,
            producto_id: element.producto_id,
            producto_nombre: element.producto ? element.producto.nombre : null,
            edicion_id: element.edicion_id,
            edicion_nombre: element.edicion ? element.edicion.nombre : null,
            costo_id: element.costo_producto_id,
            costo_nombre: nombreCosto,
            upg_edicion_id: element.upg_edicion_id,
            upg_edicion_nombre: element.edicion_upg
              ? element.edicion_upg.nombre
              : null,
            upg_costo_id: element.upg_costo_producto_id,
            upg_costo_nombre: upgNombreCosto,
            costo_precio: null,
            costo_subtotal: null,
            cantidad: element.cantidad,
            actualizacion_years: element.anos_actualizacion,
            actualizacion_porcentaje: 0,
            actualizacion_costo: 0,
            soporte_hours: element.horas_soporte,
            soporte_costo: 0,
            clave: element.clave_activacion,
            costo_producto_total: null,
          };

          switch (articuloTemp.tipo) {
            case 1:
            case 2:
              valor = costos.costos.filter(
                (data) => data.id == articuloTemp.costo_id
              );
              articuloTemp.costo_precio = valor[0].precio;
              articuloTemp.costo_subtotal =
                valor[0].precio * articuloTemp.cantidad;
              break;
            case 3:
              valor = costos.costos.filter(
                (data) => data.id == articuloTemp.costo_id
              );
              valorUp = costos.costos.filter(
                (data) => data.id == articuloTemp.upg_costo_id
              );
              articuloTemp.costo_precio =
                (valorUp[0].precio - valor[0].precio) * 1.1;
              articuloTemp.costo_subtotal = articuloTemp.costo_precio;
              break;
          }

          if (articuloTemp.actualizacion_years != 0) {
            articuloTemp.actualizacion_porcentaje =
              costos.miscelaneos[
                "soporte_year_" + articuloTemp.actualizacion_years
              ];

            if (articuloTemp.tipo === 3) {
              articuloTemp.actualizacion_costo =
                valorUp[0].precio *
                (articuloTemp.actualizacion_porcentaje / 100) *
                articuloTemp.actualizacion_years;
            } else {
              articuloTemp.actualizacion_costo =
                articuloTemp.costo_subtotal *
                (articuloTemp.actualizacion_porcentaje / 100) *
                articuloTemp.actualizacion_years;
            }
          }
          if (articuloTemp.soporte_hours != 0) {
            if (orden.orden_antigua) {
              articuloTemp.soporte_costo =
                costos.miscelaneos["soporte_hora_1"] *
                articuloTemp.soporte_hours;
            } else {
              articuloTemp.soporte_costo =
                costos.miscelaneos[
                  "soporte_hora_" + articuloTemp.soporte_hours
                ];
            }
          }

          articuloTemp.costo_producto_total =
            articuloTemp.costo_subtotal +
            articuloTemp.actualizacion_costo +
            articuloTemp.soporte_costo;

          //producto
          switch (articuloTemp.tipo) {
            case 1:
              articuloTemp.costo_producto_total =
                articuloTemp.costo_subtotal +
                articuloTemp.actualizacion_costo +
                articuloTemp.soporte_costo;
              break;
            case 2:
              articuloTemp.costo_producto_total =
                articuloTemp.actualizacion_costo + articuloTemp.soporte_costo;
              break;
            case 3:
              articuloTemp.costo_producto_total =
                articuloTemp.costo_subtotal +
                articuloTemp.actualizacion_costo +
                articuloTemp.soporte_costo;
              break;
          }

          orden.articulos.push(articuloTemp);
        });

        let column = tablaOrden.column(3);
        if (orden.tipo_cotizacion != "2") {
          column.visible(true);
          $("#rowIVA").show(200);
        } else {
          column.visible(false);
          $("#rowIVA").hide(200);
        }

        $("#tipoOrden").val(orden.tipo_cotizacion);

        // checkPack();
        recargarTabla();

        let pagar = url.searchParams.get("pagar");
        if (pagar) {
          if (orden.articulos.length) {
            new bootstrap.Modal($("#modalPago")).show();
          } else {
            alert("Debes agregar articulos a la orden.");
          }
        }
        if (res.data.estatus === 1) {
          guardarOrden(false);
        }
      })
      .catch((error) => {
        console.log(error);
      });
  }
}

function verificarGuardado() {
  if (sessionStorage.getItem("store_success")) {
    notify.success({msj: "La información se guardo correctamente."});
    sessionStorage.removeItem("store_success");
  }
}

function verficaArticulo() {
  if (articulo.costo_producto_total < 1) return false;
  if (articulo.costo_precio <= 0) return false;
  $("#addArticulo").removeClass("d-none").prop("disabled", false);
}

function checkPack() {
  return false;
  // let pack = false;

  // orden.articulos.forEach((articulo) => {
  //   if (articulo.producto_id === "1" && articulo.tipo === 1) pack = true;
  //   if (articulo.producto_id === 1 && articulo.tipo === 1) pack = true;
  // });

  // orden.pack = pack;
}
