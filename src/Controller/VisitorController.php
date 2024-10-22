<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Entity\Producer;
use App\Form\NewProducerType;
use App\Repository\VisitorRepository;
use App\Repository\ProducerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $producer = new Visitor();
        $form = $this->createForm(NewProducerType::class, $producer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $producer->setRoles(['ROLE_PRODUCER']);
            $producer->setStatus("pending");
            $em->persist($producer);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('visitor/new.html.twig', [
            'form' => $form,
        ]);
    }

    
}
