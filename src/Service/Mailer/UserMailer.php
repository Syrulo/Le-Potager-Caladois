<?php

namespace App\Service\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Visitor;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class UserMailer implements UserMailerInterface
{

    public function __construct(private readonly MailerInterface $mailer) {}

    public function newPendingProducer(Visitor $visitor) : void
    {
        $email = (new TemplatedEmail())
        ->to('tborestel@gmail.com')
        ->subject("Nouveau producteur {$visitor->getFirstname()} {$visitor->getLastname()} en attente de validation")
        ->htmlTemplate('email/admin/newPendingProducer.html.twig')
        ->context(['visitor' => $visitor]);

        $this->mailer->send($email);
    }

}