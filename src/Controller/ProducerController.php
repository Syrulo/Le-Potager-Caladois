<?php

namespace App\Controller;

use App\Entity\Producer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
