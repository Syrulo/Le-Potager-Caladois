<?php

namespace App\Controller;

use App\Entity\Producer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProducerController extends AbstractController
{
    #[Route('/producer', name: 'app_producer')]
    public function index(): Response
    {
        return $this->render('producer/index.html.twig', [
            'controller_name' => 'ProducerController',
        ]);
    }
    #[Route('/producer/{id}', name: 'app_producer_show')]
    public function show(Producer $producer): Response
    {
        return $this->render('producerDashboard.html.twig', [
            'producer' => $producer,
            'visitor' => $this->getUser(),
        ]);
    }
    #[Route('/producer/validate/{id}', name: 'app_validate_producer')]
    public function validate(Producer $producer, EntityManagerInterface $em): Response
    {
        $producer->setStatus("confirmed");
        $em->flush();
        return $this->redirectToRoute('app_admin.producer');
    }
}
