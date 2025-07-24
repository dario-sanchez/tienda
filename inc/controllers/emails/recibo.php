<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once '../../bootstrap.php';
require_once '../ordenes/recibo.php';

ob_start();
session_start();
http_response_code(500);

// $input = json_decode(file_get_contents("php://input"));

//Create an instance; passing `true` enables exceptions
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

    if($_POST['email'] === 'current'){
        $mail->addAddress( $_SESSION['usuario_email'] );
    } else {
        $emails = explode(',',$_POST['email']);
        
        foreach ($emails as $email) {
            $mail->addAddress($email);     //Add a recipient
        }
    }

    $mail->CharSet = 'UTF-8';

    //Attachments
    $recibo = new Recibo();
    $fileatt = $recibo->getFile($_POST['orden_id']);
    $filename = 'Cotización TSPlus.pdf';
    $encoding = 'base64';
    $type = 'application/pdf';

    $mail->AddStringAttachment($fileatt,$filename,$encoding,$type);

    //Content
    // $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Cotización de Soluciones | TSPlus Latam';
    $mail->Body    = "En este correo se adjunta la cotización.";

    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

http_response_code(200);
echo('success');
ob_end_flush();