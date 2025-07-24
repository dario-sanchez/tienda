$('#formRecuperacion').on('submit',e=>{
    e.preventDefault();
    mostrarLoading(true);
    $("#btnEnviar").prop('disbled',true);
    let formData = new FormData(formRecuperacion);

    axios({
        method: "post",
        url: '/tienda/inc/controllers/usuarios/recuperar.php',
        data: formData,
    })
    .then( res=>{
        alert('Se ha enviado un correo de recuperación a la dirección especificada');
        mostrarLoading(false);
        window.location.href="/tienda";
    })
    .catch( error=>{
        alert(error.response.data);
        $("#btnEnviar").prop('disbled',false);
        mostrarLoading(false);
    });
});
