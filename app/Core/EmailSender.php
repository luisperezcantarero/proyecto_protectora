<?php
namespace App\Core;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailSender {
    private $transport;
    private $mailer;
    function __construct() {
        // Configuración del transporte de correo
        $this->transport = Transport::fromDsn($_ENV['SMTP_SERVER']);
        // Inicialización del Mailer
        $this->mailer = new Mailer($this->transport);
    }

    public function sendConfirmationEmail($name, $surname, $email, $token) {
        $email = (new Email())
            ->from('luisperezcantarero01@gmail.com')
            ->to($email)
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Confirmación de cuenta')
            ->html("<p>Hola $name $surname,</p>
                     <p>Por favor, confirma tu cuenta haciendo clic en el siguiente enlace:</p>
                     <p><a href='http://protectora.local/verificacion/$token'>Confirmar cuenta</a></p>");

        $this->mailer->send($email);
    }
}
?>