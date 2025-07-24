const stripe = Stripe(
  "pk_live_UtR1V8rt4P8Umpg5dCrepUQA"
);
const elements = stripe.elements();
// Custom Styling
const style = {
  base: {
    color: "#3d3d3d",
    background: "#fff",
    lineHeight: "1.5",
    fontFamily: "Ideal Sans, system-ui, sans-serif",
    fontSmoothing: "antialiased",
    fontSize: "16px",
    "::placeholder": {
      color: "#ADADAD",
      lineHeight: "1.5",
      fontSmoothing: "antialiased",
      fontSize: "16px",
    },
  },
  invalid: {
    color: "#FF786C",
    iconColor: "#fa755a",
    "::placeholder": {
      color: "#FF786C",
    },
  },
};

// Create an instance of the card Element
const cardNumberElement = elements.create("cardNumber", {
  style: style,
  placeholder: "1234 1234 1234 1234",
});
const cardExpiryElement = elements.create("cardExpiry", { style: style });
const cardCvcElement = elements.create("cardCvc", {
  style: style,
  placeholder: "CVV",
});

cardNumberElement.mount("#numtarjeta");
cardExpiryElement.mount("#cadtarjeta");
cardCvcElement.mount("#cvvStripe");

let formStripe = document.getElementById("formStripe");

formStripe.addEventListener("submit", (e) => {
  e.preventDefault();
  mostrarLoading(true);
  guardarOrden(false);
  setTimeout(() => {
    return false;
  }, 3000);
  //pone el boton en loading
  let subBtn = e.currentTarget.querySelectorAll("input[type=submit]")[0];
  subBtn.disabled = true;

  let formData = new FormData(formStripe);

  stripe.createToken(cardNumberElement).then((result) => {
    console.log(result);
    if (result.error) {
      subBtn.disabled = false;
      switch (result.error.code) {
        case "incomplete_number":
          cardNumberElement.focus();
          break;
        case "incomplete_expiry":
          cardExpiryElement.focus();
          break;
        case "incomplete_cvc":
          cardCvcElement.focus();
          break;
      }
      notify.danger({ msj: result.error.message });

      mostrarLoading(false);
      return false;
    }

    formData.append("token", result.token.id);
    formData.append("orden_id", orden.id);
    formData.append("metodo_pago", "stripe");
    formData.append(
      "orden_total",
      (orden.total * costos.miscelaneos.precio_dollar).toFixed(2)
    );

    axios({
      method: "post",
      url: `/tienda/inc/controllers/ordenes/pagar.php`,
      data: formData,
      responseType: "json",
    })
      .then((response) => {
        window.location.replace("/tienda/ordenes/completado.php");
        mostrarLoading(false);
      })
      .catch((error) => {
        if (!error.response.data.code) alert(error.response.data.message);
        subBtn.disabled = false;

        switch (error.response.data.code) {
          case "card_declined":
            alert(
              "Su tarjeta fue declinada, póngase en contacto con el banco emisor para ver el motivo"
            );
            break;
          case "expired_card":
            alert("Su tarjeta ha expirado, intente con una diferente.");
            break;
          case "incorrect_cvc":
            alert(
              "El código de seguridad de su tarjeta es incorrecto, revíselo y vuelva a intentar."
            );
            break;
          case "incorrect_number":
            alert("El numero de su tarjeta es incorrecto.");
            break;
          case "processing_error":
            alert(
              "Ocurrió un error al intentar procesar el cargo a su tarjeta, inténtelo de nuevo mas tarde."
            );
            break;
        }
        mostrarLoading(false);
      });
  });
});
