// OpenPay.setId("mxtjhtm2utzuy2ddisef");
// OpenPay.setApiKey("pk_a32fa6822b6649379eb9087ecd26f166");
// OpenPay.setSandboxMode(true);
// var deviceSessionId = OpenPay.deviceData.setup("formPago", "hiddenOpenSession");
var orderPaypal;

// $("#formPago").on("submit", (e) => {
//   e.preventDefault();
//   guardarOrden();
//   setTimeout(() => {
//     return false;
//   }, 5000);
//   OpenPay.token.extractFormAndCreate(
//     $("#formPago"),
//     (res) => {
//       let formData = new FormData();
//       formData.append("token", res.data.id);
//       formData.append("orden_id", orden.id);
//       formData.append("metodo_pago", "openpay");
//       formData.append(
//         "orden_total",
//         (orden.total * costos.miscelaneos.precio_dollar).toFixed(2)
//       );
//       formData.append("device_session_id", deviceSessionId);
//       axios
//         .post(`/tienda/inc/controllers/ordenes/pagar.php`, formData)
//         .then((res) => {
//           window.location.href = "/tienda/ordenes/completado.php";
//         })
//         .catch((error) => {
//           console.error(error.response.data);
//           switch (error.data) {
//             case "The expiration date has expired":
//               alert("La tarjeta a expirado");
//               break;
//             default:
//               alert(
//                 "Ha ocurrido un problema inesperado: " + error.response.data
//               );
//               break;
//           }
//         });
//     },
//     (error) => {
//       switch (error.data.description) {
//         case "The expiration date has expired":
//           alert("La tarjeta a expirado");
//           break;
//         default:
//           alert(
//             "Ha ocurrido un problema inesperado, recibe sus datos e intente mas tarde."
//           );
//           break;
//       }
//     }
//   );
// });

paypal
  .Buttons({
    // onClick is called when the button is clicked
    onClick: () => {
      window.onbeforeunload = () => "";

      orderPaypal = {
        purchase_units: [
          {
            description: "TSPlus orden de compra - " + orden.id,
            amount: {
              currency: "MXN",
              value: (orden.total * costos.miscelaneos.precio_dollar).toFixed(
                2
              ),
            },
          },
        ],
        application_context: {
          shipping_preference: "NO_SHIPPING",
        },
      };
    },
    createOrder: (data, actions) => {
      // Set up the transaction
      return actions.order.create(orderPaypal);
    },
    onApprove: (data, actions) => {
      return actions.order.capture().then(function (details) {
        // // This function shows a transaction success message to your buyer.
        // alert('Transaction completed by ' + details.payer.name.given_name);
        console.log(details.purchase_units[0].payments.captures[0].id);

        let formData = new FormData();
        formData.append("orden_id", orden.id);
        formData.append("metodo_pago", "paypal");
        formData.append(
          "pago_id",
          details.purchase_units[0].payments.captures[0].id
        );
        axios
          .post(`/tienda/inc/controllers/ordenes/pagar.php`, formData)
          .then((res) => {
            window.onbeforeunload = null;
            window.location.href = "/tienda/ordenes/completado.php";
          })
          .catch((error) => {
            window.onbeforeunload = null;
            console.error(error.response.data);
          });
      });
    },
    onCancel: () => {
      window.onbeforeunload = null;
    },
  })
  .render("#paypalBtn");
