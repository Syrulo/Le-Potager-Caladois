<?php

namespace App\Service\Mailer;

use App\Entity\Visitor;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class UserMailer implements UserMailerInterface
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function newPendingProducer(Visitor $visitor): void
    {
        $email = (new TemplatedEmail())
        ->to('tborestel@gmail.com')
        ->subject("Nouveau producteur {$visitor->getFirstname()} {$visitor->getLastname()} en attente de validation")
        ->htmlTemplate('email/admin/newPendingProducer.html.twig')
        ->context(['visitor' => $visitor]);

        $this->mailer->send($email);
    }

    public function newProducerValidated(Visitor $visitor): void
    {
        $email = (new TemplatedEmail())
        ->to('tborestel@gmail.com')
        ->subject('Demande de statut producteur validée')
        ->htmlTemplate('email/producer/newProducerValidated.html.twig')
        ->context(['visitor' => $visitor]);

        $this->mailer->send($email);
    }
}
