<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Service\Mailer\UserMailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EmailController extends AbstractController
{
    public function __construct(private readonly UserMailerInterface $userMailer) {}

    #[Route('/test-email-new-pending-producer', name: 'test_email_new_pending_producer')]
    public function testNewPendingProducerEmail(): Response
    {
        $visitor = (object)[
            'firstname' => 'Jean',
            'lastname' => 'Jeannot'
        ];

        return $this->render('email/admin/newPendingProducer.html.twig', ['visitor' => $visitor]);
    }

    #[Route('/test-email-twig-new-validated-producer', name: 'test_email_twig_validated_new_producer')]
    public function testNewValidatedProducerEmail(): Response
    {
        $visitor = (object)[
            'firstname' => 'Jean',
            'lastname' => 'Jeannot'
        ];
        return $this->render('email/producer/newProducerValidated.html.twig', [
            'visitor' => $visitor
        ]);
    }

}
