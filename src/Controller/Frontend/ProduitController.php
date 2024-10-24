<?php

namespace App\Controller\Frontend;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour la gestion des produits dans le frontend.
 */
#[Route('/produit')]
class ProduitController extends AbstractController
{
    /**
     * Affiche les détails d'un produit spécifique.
     *
     * @param Produit $produit L'entité produit dont les détails doivent être affichés.
     * @return Response Une réponse HTTP qui rend le template frontend/produit/show.html.twig avec les détails du produit.
     */
    #[Route('/details/{slug}', name: 'app_produit')]
    public function show(Produit $produit): Response
    {
        return $this->render('frontend/produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    // /**
    //  * Affiche une liste de produits en fonction des critères de recherche.
    //  *
    //  * @param ProduitRepository $repoProduit Le repository pour accéder aux données des produits.
    //  * @param Request $request La requête HTTP.
    //  * @return Response Une réponse HTTP qui rend le template frontend/produit/list.html.twig avec les produits trouvés ou un message d'erreur.
    //  */
    // #[Route('/list', name: 'app_produit_list', methods: ['GET'])]
    // public function list(ProduitRepository $repoProduit, Request $request): Response
    // {
    //     // Initialisation de la variable $produits
    //     $produits = [];

    //     $keyword = $request->get('search');
    //     if ($keyword !== null && $keyword !== '') {
    //         $searchType = $request->get('search_type');
    //         // en fonction de la variable SearchType venant du formulaire, on fait une requête spécifique
    //         $produits = $repoProduit->search($keyword, $searchType);
    //         if (empty($produits)) {
    //             $this->addFlash('error', 'Aucun produit correspondant');
    //             return $this->redirectToRoute('app_produit_list');
    //         }
    //     } else {
    //         $this->addFlash('error', 'Veuillez fournir un critère de recherche.');
    //     }
    //     return $this->render('frontend/produit/list.html.twig', [
    //         'produits' => $produits,
    //     ]);
    // }
}
