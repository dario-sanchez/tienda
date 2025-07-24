let tablaOrdenes,
  ordenes = [],
  costos;

$(document).ready(function () {
  axios
    .get("/tienda/inc/controllers/productos/get.php?query=all")
    .then((res) => {
      costos = res.data;
    });

  tablaOrdenes = $("#tablaOrdenes").DataTable({
    data: ordenes,
    columns: [
      {
        className: "text-center",
        data: "id",
      },
      {
        className: "text-center",
        data: "created_at",
        render: (data, type, row, meta) => {
          return dayjs(data).format("DD/MM/YYYY");
        },
      },
      {
        className: "text-center",
        data: "updated_at",
        render: (data, type, row, meta) => {
          return dayjs(data).format("DD/MM/YYYY");
        },
      },
      {
        className: "text-center",
        data: "total",
        render: (data, type, row, meta) => {
          if (row.tipo_cotizacion === 1) return moneda.format(data.toFixed(2));

          if (row.tipo_cotizacion === 2)
            return moneda.format(row.total_no_iva.toFixed(2));
        },
        defaultContent: "<i class='text-muted text-center d-block'> - </i>",
      },
      {
        className: "text-center",
        data: "total",
        render: (data, type, row, meta) => {
          if (row.tipo_cotizacion === 1)
            return moneda.format(
              (data * costos.miscelaneos.precio_dollar).toFixed(2)
            );

          if (row.tipo_cotizacion === 2)
            return moneda.format(
              (row.total_no_iva * costos.miscelaneos.precio_dollar).toFixed(2)
            );
        },
        defaultContent: "<i class='text-muted text-center d-block'> - </i>",
      },
      {
        className: "text-center",
        data: "estatus",
        render: (data, type, row, meta) => {
          return data > 1 ? "Pagado" : "Cotizado";
        },
        defaultContent: "<i class='text-muted text-center d-block'> - </i>",
      },
      {
        className: "text-center",
        data: "id",
        render: (data, type, row, meta) => {
          if (row.estatus > 2) return null;

          if (row.estatus == 2) {
            return `
            <div class="btn-group btn-group-sm" role="group">
            <a class='btn btn-warning' href='/tienda/ordenes/cotizacion.php?orden=${data}&ver=1' title='ver'>
            <i class="fa-solid fa-eye"></i>
            </a>
            </div>`;
          }

          if (row.orden_antigua) {
            return `
                    <div class="btn-group btn-group-sm" role="group">
                        <a class='btn btn-info ${
                          row.root ? "" : "d-none"
                        }' href='/tienda/ordenes/cotizacion.php?orden=${data}' title='editar'>
                            <i class="fa-solid fa-file-pen"></i>
                        </a>
                        <a class='btn btn-warning ${
                          !row.root ? "" : "d-none"
                        }' href='/tienda/ordenes/cotizacion.php?orden=${data}&ver=1' title='ver'>
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a class='btn btn-success' href='/tienda/ordenes/cotizacion_old.php?orden=${data}&pagar=1&ver=1' title='pagar'>
                            <i class="fa-solid fa-dollar-sign"></i>
                        </a>
                        <button class='btn btn-primary enviarCotizacion' title='enviar por email' data-id='${data}'>
                            <i class="fa-solid fa-envelope"></i>
                        </button>
                    </div>`;
          } else {
            return `
                    <div class="btn-group btn-group-sm" role="group">
                        <a class='btn btn-info ${
                          row.root ? "" : "d-none"
                        }' href='/tienda/ordenes/cotizacion_old.php?orden=${data}' title='editar'>
                            <i class="fa-solid fa-file-pen"></i>
                        </a>
                        <a class='btn btn-warning ${
                          !row.root ? "" : "d-none"
                        }' href='/tienda/ordenes/cotizacion_old.php?orden=${data}&ver=1' title='ver'>
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a class='btn btn-success' href='/tienda/ordenes/cotizacion.php?orden=${data}&pagar=1&ver=1' title='pagar'>
                            <i class="fa-solid fa-dollar-sign"></i>
                        </a>
                        <button class='btn btn-primary enviarCotizacion' title='enviar por email' data-id='${data}'>
                            <i class="fa-solid fa-envelope"></i>
                        </button>
                    </div>`;
          }
        },
        defaultContent: "<i class='text-muted text-center d-block'> - </i>",
      },
    ],
    searching: true,
    ordering: false,
    paging: true,
    info: false,
    processing: false,
    serverSide: false,
    lengthChange: true,
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
  cargarOrdenes();
});

$(document).on("click", ".enviarCotizacion", (e) => {
  let ordenId = $(e.currentTarget).data("id");
  enviarOrden(ordenId);
});

function cargarOrdenes() {
  mostrarLoading(true);
  axios.get(`/tienda/inc/controllers/ordenes/get.php`).then((res) => {
    ordenes = res.data;
    tablaOrdenes.clear();
    tablaOrdenes.rows.add(ordenes).draw();
    mostrarLoading(false);
  });
}

function enviarOrden(ordenId) {
  mostrarLoading(true);
  let formData = new FormData();
  formData.append("orden_id", ordenId);
  formData.append("email", "current");
  axios
    .post(`/tienda/inc/controllers/emails/recibo.php`, formData)
    .then((res) => {
      notify.success({msj: "Cotización enviada"});
      mostrarLoading(false);
    })
    .catch((error) => {
      console.error(error.response.data);
      mostrarLoading(false);
    });
}
