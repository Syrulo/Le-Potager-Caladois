<?php

namespace App\Controller\Backend;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminProduitController extends AbstractController
{
    /**
     * Crée un nouveau produit.
     *
     * @Route("/produit/create", name="app_admin.produit.create", methods={"GET", "POST"})
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/produit/create', name: 'app_admin.produit.create', methods: ['GET', 'POST'])]
    public function createProduit(Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été crée');
            return $this->redirectToRoute('app_admin.produit');
        }

        return $this->render('backend/produit/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Édite un produit existant.
     *
     * @Route("/produit/edit/{id}", name="app_admin.produit.edit", methods={"GET", "POST"})
     *
     * @param Produit $produit L'entité produit à éditer.
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/produit/edit/{id}', name: 'app_admin.produit.edit', methods: ['GET', 'POST'])]
    public function editProduit(Produit $produit, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setUpdatedAt(new \DateTime());
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('app_admin.produit');
        }

        return $this->render('backend/produit/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Affiche la liste des produits.
     *
     * @Route("/produit", name="app_admin.produit", methods={"GET", "POST"})
     *
     * @param ProduitRepository $repoProduit Le dépôt des produits.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/produit', name: 'app_admin.produit', methods: ['GET', 'POST'])]
    public function listProduit(ProduitRepository $repoProduit): Response
    {
        $produits = $repoProduit->findAll();
        return $this->render('backend/produit/list.html.twig', [
            'produits' => $produits,
        ]);
    }

    /**
     * Supprime un produit.
     *
     * @Route("/produit/delete/{id}", name="app_admin.produit.delete", methods={"GET", "POST"})
     *
     * @param Produit $produit L'entité produit à supprimer.
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/produit/delete/{id}', name: 'app_admin.produit.delete', methods: ['GET', 'POST'])]
    public function deleteProduit(Produit $produit, Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->get('_token'))) {
            $manager->remove($produit);
            $manager->flush();
            
            $this->addFlash('success', 'Le produit a bien été supprimé');
        
        return $this->redirectToRoute('app_admin.produit');
        }
    }
}