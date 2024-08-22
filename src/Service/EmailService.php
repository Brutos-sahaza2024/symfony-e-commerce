<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactEmail($name, $email, $message)
    {
        $emailMessage = (new Email())
            ->from("$email")
            ->to('admin@e-commerce.com')
            ->subject('Nouveau message de contact')
            ->text("Nom: $name\nEmail: $email\nMessage: $message");

        $this->mailer->send($emailMessage);
    }
}