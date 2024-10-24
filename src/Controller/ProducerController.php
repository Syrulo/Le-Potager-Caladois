<?php

namespace App\Controller;

use App\Entity\Producer;
use App\Form\ProducerEditAsAdminType;
use App\Repository\ProductRepository;
use App\Repository\ProducerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProducerController extends AbstractController
{
    #[Route('/producer', name: 'app_producer')]
    public function index(ProducerRepository $producerRepository): Response
    {
        $producers = $producerRepository->findAll();
        return $this->render('frontend/producteur/list.html.twig', [
            'producers' => $producers
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

    #[Route('/producer/{slug}/details', name: 'app_producer_details', methods: ['GET'])]
    public function detailsProducteur(Producer $producer, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findByProducer($producer->getId());
        return $this->render('frontend/producteur/detailsProducteur.html.twig', [
            'producer' => $producer,
            'products' => $products
        ]);
    }
    // #[Route('/producer/validate/{id}', name: 'app_validate_producer')]
    // public function validate(Producer $producer, EntityManagerInterface $em): Response
    // {
    //     $producer->setStatus("confirmed");
    //     $em->flush();
    //     return $this->redirectToRoute('app_admin_producer');
    // }

    /**
     * Affiche une liste de producteurs.
     *
     * @param ProducerRepository $producerRepository Le repository pour accéder aux données des producteurs.
     * @param Request $request L'objet de requête HTTP.
     * @return Response Une réponse HTTP qui rend le template backend/producteur/list.html.twig avec les producteurs triés.
     */
    #[Route('/admin/producer', name: 'app_admin_producer', methods: ['GET'])]
    public function listProducteur(ProducerRepository $producerRepository, Request $request): Response
    {
        // Récupérer les paramètres de tri depuis la requête
        $sort = $request->query->get('sort', 'id'); // Trier par 'id' par défaut
        $direction = $request->query->get('direction', 'asc'); // Trier par ordre ascendant par défaut
    
        // Récupérer les producteurs triés depuis le repository
        $producers = $producerRepository->findBy([], [$sort => $direction]);
    
        return $this->render('adminProducer.html.twig', [
            'producers' => $producers,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

        /**
    * Édite un producteur existant.
    *
    * @param Producer $producer L'entité producer à éditer.
    * @param Request $request L'objet de requête HTTP.
    * @param EntityManagerInterface $manager L'EntityManager pour gérer les opérations de base de données.
    * @return Response Une réponse HTTP qui rend le formulaire d'édition de producteur ou redirige après la modification.
    */
    #[Route('/admin/producer/edit/{id}', name: 'app_admin_producer_edit', methods: ['GET', 'POST'])]
    public function editProducteur(Producer $producer, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProducerEditAsAdminType::class, $producer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($producer);
            $manager->flush();

            $this->addFlash('success', 'Le producteur a bien été modifié');
            
            return $this->redirectToRoute('app_admin_producer');
        }

        return $this->render('backend/producteur/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
