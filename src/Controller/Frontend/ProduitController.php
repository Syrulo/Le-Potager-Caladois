<?php

namespace App\Controller\Frontend;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produit')]
class ProduitController extends AbstractController
{
    
    #[Route('/details/{slug}', name: 'app_produit')]
    public function show(Produit $produit): Response
    {
        return $this->render('frontend/produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/list', name: 'app_produit_list', methods: ['GET'])]
    public function list(ProduitRepository $repoProduit, Request $request): Response
    {
        // Initialisation de la variable $produits
        $produits = [];

        $keyword = $request->get('search');
        if ($keyword !== null && $keyword !== '') {
            $searchType = $request->get('search_type');
            $produits = $repoProduit->search($keyword, $searchType);
            if (empty($produits)) {
                $this->addFlash('error', 'Aucun produit correspondant');
                return $this->redirectToRoute('app_produit_list');
            }
        } else {
            $this->addFlash('error', 'Veuillez fournir un critère de recherche.');
        }
        return $this->render('frontend/produit/list.html.twig', [
            'produits' => $produits,
        ]);
    }
}
