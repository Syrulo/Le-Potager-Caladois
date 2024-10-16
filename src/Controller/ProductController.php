<?php

namespace App\Controller;

use App\Entity\Producer;
use App\Form\ProducerType;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(Request $request, EntityManagerInterface $em, VisitorRepository $visitorRepository): Response
    {
        $producer = new Producer(); 
        $form = $this->createForm(ProducerType::class, $producer);  
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $producer->setVisitor($this->getUser());
            $em->persist($producer);
            $em->flush();

            $visitor = $visitorRepository->find($this->getUser()->getId());
            $visitor->setStatus("confirmed");
            $em->flush();
            
            return $this->redirectToRoute('app_producer_show', ['id' => $producer->getId()]);
        }
        return $this->render('producerDashboard.html.twig', [
            'visitor' => $this->getUser(),
            'form' => $form,
        ]);
    }
}
