<?php

use Models\Orden;
use Models\Usuario;
use Openpay\Data\Openpay;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
if (!isset($_POST['orden_id'])) exit('Información incompleta.');

$usuario = Usuario::findOrFail($_SESSION['usuario_id']);
$orden = Orden::findOrFail($_POST['orden_id']);

switch ($_POST['metodo_pago']) {
	case 'openpay':
		// Openpay::setProductionMode(true);
		Openpay::setId($_ENV['OPENPAY_ID']);
		Openpay::setApiKey($_ENV['OPENPAY_API_KEY']);
		Openpay::setCountry('MX');
		$openpay = Openpay::getInstance();

		if (is_null($usuario->customer_openpay)) {
			$customerData = [
				'name' => $usuario->nombre,
				'last_name' => $usuario->apellido,
				'email' => $usuario->email
			];
			$customer = $openpay->customers->add($customerData);
			$usuario->update(['customer_openpay' => $customer->id]);
		}

		$chargeData = [
			'method' => 'card',
			'source_id' => $_POST['token'],
			'device_session_id' => $_POST['device_session_id'],
			'amount' => $_POST['orden_total'],
			'description' => 'Cargo por orden a TSPlus',
			'order_id' => $orden->id . '-z'
		];

		try {
			$customer = $openpay->customers->get($usuario->customer_openpay);
			$charge = $customer->charges->create($chargeData);

			$orden->update([
				'estatus' => '2',
				'metodo_pago' => 1,
				'pago_id' => $charge->id,
				'fecha_pago' => date("Y-m-d H:i:s"),
			]);
		} catch (OpenpayApiTransactionError $e) {
			exit($e->getMessage());
		} catch (OpenpayApiRequestError $e) {
			exit('ERROR on the request: ' . $e->getMessage());
		} catch (OpenpayApiConnectionError $e) {
			exit('ERROR while connecting to the API: ' . $e->getMessage());
		} catch (OpenpayApiAuthError $e) {
			exit('ERROR on the authentication: ' . $e->getMessage());
		} catch (OpenpayApiError $e) {
			exit('ERROR on the API: ' . $e->getMessage());
		} catch (Exception $e) {
			exit('Error on the script: ' . $e->getMessage());
		}
		break;
	case 'paypal':
		$orden->update([
			'estatus' => '2',
			'metodo_pago' => 2,
			'pago_id' => $_POST['pago_id'],
			'fecha_pago' => date("Y-m-d H:i:s"),
		]);
		break;
	case 'stripe':
		// This is a sample test API key. Sign in to see examples pre-filled with your key.
		$stripe = new \Stripe\StripeClient('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');
		$charge = null;
		if (!isset($_POST['orden_id'])) exit('Información incompleta.');

		try {

			$charge = $stripe->charges->create([
				'amount' => $_POST['orden_total'] * 100,
				'currency' => 'mxn',
				'source' => $_POST['token'],
				'description' => 'Pago TSPlus Orden #' . $orden->id,
				'receipt_email' => $usuario->email,
			]);
		} catch (\Stripe\Exception\CardException | Exception $e) {
			$error = [
				'status' => $e->getHttpStatus(),
				'type' => $e->getError()->type,
				'code' => $e->getError()->code,
				'param' => $e->getError()->param,
				'message' => $e->getError()->message,
			];

			die(json_encode($error));
		}

		if ($charge->status === 'succeeded' || $charge->status === 'active') {

			$orden->update([
				'estatus' => '2',
				'metodo_pago' => 3,
				'pago_id' => $charge->id,
				'fecha_pago' => date("Y-m-d H:i:s"),
			]);
		} else {
			die(json_encode($charge));
		}
		break;
}

$mail = new PHPMailer(true);

try {
	//Server settings
	// $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username   = $_ENV['MAIL_USERNAME'];                     //SMTP username
	$mail->Password   = $_ENV['MAIL_PASSWORD'];                              //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	$mail->Port       = $_ENV['MAIL_PORT'];                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	//Recipients
	$mail->setFrom($_ENV['MAIL_USERNAME'], 'TSPlus Latam');
	$mail->addAddress($usuario->email);
	$mail->addBCC('laura.morales@neogenesys.com.mx');
	$mail->addBCC('luis.perez@neogenesys.com.mx');

	$mail->CharSet = 'UTF-8';

	//Content
	// $mail->isHTML(true);                                  //Set email format to HTML
	$mail->Subject = "Nuevo Pago en la Orden #{$orden->id} | TSPlus Latam";
	$mail->Body    = "Se a realizado el pago de la orden #{$orden->id} por medio de: " . $_POST['metodo_pago'];

	$mail->send();
	// echo 'Message has been sent';
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


http_response_code(200);
echo json_encode($charge, JSON_NUMERIC_CHECK);
ob_end_flush();
