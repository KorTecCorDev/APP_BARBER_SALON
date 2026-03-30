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
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'acca0baa2bd718';
        $phpmailer->Password = '0a2af72ec80f4f';

        $phpmailer->setFrom('cuentas@appsalon.com');
        $phpmailer->addAddress('cuentas@appsalon.com','AppSalon.com');
        $phpmailer-> Subject = 'Confirma tu cuenta';

        //Set HTML
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta esn App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "Presiona aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $phpmailer->Body = $contenido;

        //Enviar el email
        $phpmailer->send();
    }
}