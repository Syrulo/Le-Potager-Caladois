<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Form\NewProducerType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VisitorController extends AbstractController
{
    #[Route('/visitor', name: 'app_visitor')]
    public function index(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }
    #[Route('/visitor/new', name: 'app_visitor_new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $producer = new Visitor();
        $form = $this->createForm(NewProducerType::class, $producer);
        return $this->render('visitor/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
