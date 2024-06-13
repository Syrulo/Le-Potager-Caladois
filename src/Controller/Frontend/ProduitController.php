<?php

namespace App\Controller\Frontend;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
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

    #[Route('/list', name: 'app_produit_list')]
    public function list(ProduitRepository $repoProduit): Response
    {
        $produits = $repoProduit->findAll();
        return $this->render('frontend/produit/list.html.twig', [
            'produits' => $produits
        ]);
    }
}
