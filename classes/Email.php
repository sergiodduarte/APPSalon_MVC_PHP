<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail-> isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail -> setFrom('sdduarte87@gmail.com');
        $mail -> addAddress('sdduarte87@gmail.com','AppSalon.com');
        $mail -> Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre." </strong>, Por favo confirma tu cuenta para asignar tu cita con nosotros.</p>";
        $contenido .= "<p>Presiona aqui: <a href='". $_ENV['PROJECT_URL'] ."/confirmar-cuenta?token=". $this->token ."'>Confirmar cuenta</a></p>";
        $contenido .= "<p> Si no solicitaste esta cuenta, puedes ignorar el mensaje";
        $contenido .= "</html>";

        $mail -> Body = $contenido;

        //enviar email
        $mail -> send();
    }

    public function enviarInstrucciones() {
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail-> isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail -> setFrom('sdduarte87@gmail.com');
        $mail -> addAddress('sdduarte87@gmail.com','AppSalon.com');
        $mail -> Subject = 'Reestablece tu password';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre." </strong>, haz solicitado reestablecer tu password, sigue el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aqui: <a href='". $_ENV['PROJECT_URL'] ."/recuperar?token=". $this->token ."'>Reestablecer password</a></p>";
        $contenido .= "<p> Si no solicitaste esta accion, puedes ignorar el mensaje";
        $contenido .= "</html>";

        $mail -> Body = $contenido;

        //enviar email
        $mail -> send();
    }
}