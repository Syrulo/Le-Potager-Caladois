<?php

namespace App\Controller\Backend;

use App\Entity\Producteur;
use App\Entity\Utilisateur;
use App\Form\ProducteurType;
use App\Form\InscriptionProducteurType;
use App\Repository\ProducteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminProducteurController extends AbstractController
{
    #[Route('/producteur/create', name: 'app_admin.producteur.create', methods: ['GET', 'POST'])]
    public function createProducteur(Request $request, EntityManagerInterface $manager): Response
    {
        $producteur = new Producteur();
        $utilisateur = new Utilisateur();

        $form = $this->createForm(InscriptionProducteurType::class, [
            'utilisateur' => $utilisateur,
            'producteur' => $producteur
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $utilisateur = $data['utilisateur'];
            $producteur = $data['producteur'];

            $utilisateur->setRoles(['ROLE_PRODUCTEUR']);
            $utilisateur->setProducteur($producteur);
            $manager->persist($utilisateur);
            $manager->persist($producteur);
            $manager->flush();

            $this->addFlash('success', 'Le producteur a bien été ajouté');

            return $this->redirectToRoute('app_admin.producteur');
        }

        return $this->render('backend/producteur/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/producteur/edit/{id}', name: 'app_admin.producteur.edit', methods: ['GET', 'POST'])]
    public function editProducteur( Producteur $producteur, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProducteurType::class, $producteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($producteur);
            $manager->flush();

            $this->addFlash('success', 'Le producteur a bien été modifié');
            
            return $this->redirectToRoute('app_admin.producteur');
        }

        return $this->render('backend/producteur/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/producteur', name: 'app_admin.producteur', methods: ['GET'])]
    public function listProducteur(ProducteurRepository $repoProducteur, Request $request): Response
    {
        // Récupérer les paramètres de tri depuis la requête
        $sort = $request->query->get('sort', 'id'); // Trier par 'id' par défaut
        $direction = $request->query->get('direction', 'asc'); // Trier par ordre ascendant par défaut
    
        // Récupérer les producteurs triés depuis le repository
        $producteurs = $repoProducteur->findBy([], [$sort => $direction]);
    
        return $this->render('backend/producteur/list.html.twig', [
            'producteurs' => $producteurs,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    #[Route('/producteur/{id}', name: 'app_admin.producteur.delete', methods: ['GET', 'POST'])]
    public function deleteProducteur(Producteur $producteur, Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $producteur->getId(), $request->get('_token'))) {
            // Supprimer les produits associés
            foreach ($producteur->getProduits() as $produit) {
                $manager->remove($produit);
            }
    
            // Supprimer le producteur
            $manager->remove($producteur);
            $manager->flush();
    
            $this->addFlash('success', 'Le producteur et ses produits ont bien été supprimés de la liste');
            
            return $this->redirectToRoute('app_admin.producteur');
        }
    
        return $this->redirectToRoute('app_admin.producteur');
    }

}
