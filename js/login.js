$('#formLogin').on('submit',e=>{
    e.preventDefault();
    $("#btnEnviar").prop('disbled',true);
    let formData = new FormData(formLogin);

    axios({
        method: "post",
        url: '/tienda/inc/login.php',
        data: formData,
    })
    .then( res=>{
        window.location.href="/tienda";
    })
    .catch( error=>{
        console.error(error);
        alert(error.response.data);
        $("#btnEnviar").prop('disbled',false);
    });
});
