<?php

namespace App\Controller\Frontend;

use App\Entity\Producteur;
use App\Repository\ProduitRepository;
use App\Repository\ProducteurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour la gestion des producteurs dans le frontend.
 */
class ProducteurController extends AbstractController
{
    /**
     * Affiche les détails d'un producteur spécifique ainsi que ses produits.
     *
     * @param Producteur $producteur L'entité producteur dont les détails doivent être affichés.
     * @param ProduitRepository $repoProduit Le repository pour accéder aux données des produits.
     * @return Response Une réponse HTTP qui rend le template frontend/producteur/detailsProducteur.html.twig avec le producteur et ses produits.
     */
    #[Route('/producteur/{slug}', name: 'app_producteur.details', methods: ['GET'])]
    public function detailsProducteur(Producteur $producteur, ProduitRepository $repoProduit): Response
    {
        $produits = $repoProduit->findByProducteur($producteur->getId());
        return $this->render('frontend/producteur/detailsProducteur.html.twig', [
            'producteur' => $producteur,
            'produits' => $produits
        ]);
    }

    /**
     * Affiche la liste de tous les producteurs.
     *
     * @param ProducteurRepository $repoProducteur Le repository pour accéder aux données des producteurs.
     * @return Response Une réponse HTTP qui rend le template frontend/producteur/list.html.twig avec tous les producteurs.
     */
    #[Route('/producteur', name: 'app_producteur', methods: ['GET'])]
    public function listProducteur(ProducteurRepository $repoProducteur): Response
    {
        $producteurs = $repoProducteur->findAll();
        return $this->render('frontend/producteur/list.html.twig', [
            'producteurs' => $producteurs
        ]);
    }
}
