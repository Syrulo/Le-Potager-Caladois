<?php

namespace App\Controller\Backend;

use App\Entity\Produit;
use App\Entity\Utilisateur;
use App\Form\AddProductType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddProducteurController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/producteur/produit', name: 'app_producteur.produit', methods: ['GET', 'POST'])]
    public function listProduit(ProduitRepository $repoProduit): Response
    {
        $user = $this->security->getUser();

        if (!$user instanceof Utilisateur) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas un producteur.');
        }

        $producteur = $user->getProducteur();

        if (!$producteur) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas un producteur.');
        }

        $produits = $repoProduit->findBy(['producteur' => $producteur]);

        return $this->render('backend/addproducteur/dashboard.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/producteur/produit/ajouter', name: 'app_producteur.produit.ajouter', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_PRODUCTEUR')]
    public function ajouterProduit(Request $request, EntityManagerInterface $manager): Response
    {
        $user = $this->security->getUser();

        if (!$user instanceof Utilisateur || !$user->getProducteur()) {
            throw new \LogicException('L\'utilisateur connecté n\'est pas un producteur.');
        }

        $producteur = $user->getProducteur();
        $produit = new Produit();
        $form = $this->createForm(AddProductType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setProducteur($producteur); // Associe le produit au producteur connecté
            $manager->persist($produit);
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été ajouté');
            return $this->redirectToRoute('app_home_page');
        }

        return $this->render('backend/addproducteur/addProducteurProduct.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/producteur/produit/edit/{id}', name: 'app_producteur.produit.edit', methods: ['GET', 'POST'])]
    public function editProduit(Produit $produit, Request $request, EntityManagerInterface $manager): response
    {
        $form = $this->createForm(AddProductType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setUpdatedAt(new \DateTime());
            $manager->persist($produit);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('app_producteur.produit');
        }

        return $this->render('backend/addproducteur/producteurProductEdit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/producteur/produit/delete/{id}', name: 'app_producteur.produit.delete', methods: ['GET', 'POST'])]
    public function deleteProduit(Produit $produit, Request $request, EntityManagerInterface $manager): response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->get('_token'))) {
            $manager->remove($produit);
            $manager->flush();
            
            $this->addFlash('success', 'Le produit a bien été supprimé');
        
        return $this->redirectToRoute('app_producteur.produit');
        }
    }
}