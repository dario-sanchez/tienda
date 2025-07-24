$(document).ready(() => {
  mostrarLoading(true);
  cargarUsuario();
  $("#formUpdateUsuario").on("submit", (e) => {
    e.preventDefault();
    mostrarLoading(true);
    $("#btnEnviar").prop("disbled", true);
    let formData = new FormData(formUpdateUsuario);

    axios({
      method: "post",
      url: "/tienda/inc/controllers/usuarios/update.php",
      data: formData,
    })
      .then((res) => {
        notify.success({ msj: "La informacion se guardo correctamente." });
        mostrarLoading(false);
      })
      .catch((error) => {
        alert(error.response.data);
        $("#btnEnviar").prop("disbled", false);
        mostrarLoading(false);
      });
  });
});

function cargarUsuario() {
  mostrarLoading(true);
  axios.get(`/tienda/inc/controllers/usuarios/get.php`).then((res) => {
    $("#nombre").val(res.data.nombre);
    $("#apellido").val(res.data.apellido);
    $("#empresa_nombre").val(res.data.empresa);
    $("#telefono").val(res.data.telefono);
    $("#pais").val(res.data.pais);
    $("#direccion").val(res.data.direccion);
    $("#colonia").val(res.data.colonia);
    $("#ciudad").val(res.data.ciudad);
    $("#estado").val(res.data.estado);
    $("#zip").val(res.data.zip);
    $("#cupon").val(res.data.cupon);
    mostrarLoading(false);
  });
}
