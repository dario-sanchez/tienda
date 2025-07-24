const moneda = Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
});

$('#btnLogout').on('click',e=>{
    axios.get('/tienda/inc/logout.php')
        .then(res=>{
            if(res) window.location.href="/tienda";
        });
});

function mostrarLoading(param){
    if( param ) {
        $("body").addClass('noScroll');
        $('#loadingPane').removeClass('d-none');
    } else {
        $("body").removeClass('noScroll');
        $('#loadingPane').addClass('d-none');
    }
}