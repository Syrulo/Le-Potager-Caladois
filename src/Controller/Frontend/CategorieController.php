<?php

namespace App\Controller\Frontend;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{slug}', name: 'app_categorie.details', methods: ['GET'])]
    public function detailsCategorie(Categorie $categorie, ProduitRepository $repoProduit): Response
    {
        $produits = $repoProduit->findByCategorie($categorie->getId());
        return $this->render('frontend/categorie/detailsCategorie.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits
        ]);
    }

    #[Route('/categorie', name: 'app_categorie', methods: ['GET'])]
    public function listCategorie(CategorieRepository $repoCategorie): Response
    {
        $categories = $repoCategorie->findAll();
        return $this->render('frontend/categorie/list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categories/{slug}', name: 'app_categorie', methods: ['GET'])]
    public function listeCategorie(string $slug, ProduitRepository $repoProduit, CategorieRepository $repoCategorie): Response
    {
        $categorie = $repoCategorie->findOneBy(['slug' => $slug]); // Utiliser le slug pour trouver la catégorie

        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
        }

        // Utiliser l'ID de la catégorie pour trouver les produits associés
        $produits = $repoProduit->findByCategorie($categorie->getId());

        return $this->render('frontend/categorie/show.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits
        ]);
    }
}
