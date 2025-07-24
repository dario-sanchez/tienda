<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../../bootstrap.php';
require_once '../miscelaneos.php';

use Models\Usuario;

ob_start();
session_start();
http_response_code(500);
if( !isset($_POST['email']) ) exit('error');
$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$user = Usuario::where('email',$email)->first();

if (!is_null($user)) {
    $nueva_clave = substr(md5(rand()), 0, 10); // generamos una nueva contraseña de forma aleatoria
    $user->update(['clave' => md5($nueva_clave)]);
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
        $mail->addAddress($_POST['email']);     //Add a recipient
        $mail->CharSet = 'UTF-8';

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recuperación de contraseña | TSPlus Latam';
        $mail->Body    = '
          <html>
          <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>A Simple Responsive HTML Email</title>
            <style type="text/css">
            body {margin: 0; padding: 0; min-width: 100%!important;}
            img {height: auto;}
            .content {width: 100%; max-width: 600px;}
            .header {padding: 40px 30px 20px 30px;}
            .innerpadding {padding: 30px 30px 30px 30px;}
            .borderbottom {border-bottom: 1px solid #f2eeed;}
            .subhead {font-size: 15px; color: #ffffff; font-family: sans-serif; letter-spacing: 10px;}
            .h1, .h2, .bodycopy {color: #ffffff; font-family: sans-serif;}
            .h1 {font-size: 33px; line-height: 38px; font-weight: bold;}
            .h2 {padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;}
            .bodycopy {font-size: 16px; line-height: 22px;}
            .button {text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;}
            .button a {color: #ffffff; text-decoration: none;}
            .footer {padding: 20px 30px 15px 30px;}
            .footercopy {font-family: sans-serif; font-size: 14px; color: #ffffff;}
            .footercopy a {color: #ffffff; text-decoration: underline;}

            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
            body[yahoo] .hide {display: none!important;}
            body[yahoo] .buttonwrapper {background-color: transparent!important;}
            body[yahoo] .button {padding: 0px!important;}
            body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
            body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
            }

            </style>
          </head>

          <body yahoo bgcolor="#f6f8f1">
          <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>
              
              <table bgcolor="#ffffff" class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td bgcolor="#385259" class="header">
                    <table width="220" align="left" border="0" cellpadding="0" cellspacing="0">  
                      <tr>
                      </tr>
                    </table>
              
                    <table class="col425" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 425px;">  
                      <tr>
                        <td height="70">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td class="subhead" style="padding: 0 0 0 3px;">
                                TSPlus-LATAM
                              </td>
                            </tr>
                            <tr>
                              <td class="h2" style="padding: 5px 0 0 0;">
                                Restaurar Contraseña
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                          </td>
                        </tr>
                    </table>
                    <![endif]-->
                  </td>
                </tr>
                <tr>
                  <td class="innerpadding borderbottom">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td style="color: #2C2D2E; font-family: sans-serif; padding: 0 0 15px 0; font-size: 24px; line-height: 28px; font-weight: bold;">
                          Estimado(a): ' . $user->nombre.' '.$user->apellido. '
                        </td>
                      </tr>
                      <tr>
                        <td style="color:#2C2D2E; font-size: 16px; line-height: 22px; font-family: sans-serif;">
                        Hemos recibido una solicitud para restaurar su contraseña de acceso.
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td class="innerpadding borderbottom">
                    <table width="115" align="left" border="0" cellpadding="0" cellspacing="0">  
                      <tr>
                        <td height="115" style="padding: 0 20px 20px 0;">
                          <img class="fix" src="icons/article1.png" width="115" height="115" border="0" alt="" />
                        </td>
                      </tr>
                    </table>
                    <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 380px;">  
                      <tr>
                        <td>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td style="color:#2C2D2E; font-size: 16px; line-height: 22px; font-family: sans-serif;">
                              Usuario: ' . $user->email . '<br/><br/>
                              Contraseña: ' . $nueva_clave . '
                              </td>
                            </tr>
                            <tr>
                              <td style="padding: 20px 0 0 0;">
                                <table class="buttonwrapper" bgcolor="#e05443" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td class="button" height="45">
                                      <a href="https://tsplus.mx/tienda">Entrar a TSPlus!</a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              
            
                <tr>
                  <td class="footer" bgcolor="#44525f">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" class="footercopy">
                          &reg; Neogenesys, TSplus 2016<br/>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" style="padding: 20px 0 0 0;">
                          <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="37" style="text-align: center; padding: 0 10px 0 10px;">
                                <a href="https://www.facebook.com/tspluslatam/">
                                  <img src="icons/facebook.png" width="37" height="37" alt="Facebook" border="0" />
                                </a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              </td>
            </tr>
          </table>
          </body>
          </html>
                  ';

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        exit("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
} else {
  exit('El correo especificado no esta en la base de datos.');
}

http_response_code(200);
echo 'success';
ob_end_flush();
