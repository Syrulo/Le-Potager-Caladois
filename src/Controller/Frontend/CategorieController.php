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

    #[Route('/categories/legumes', name: 'app_categorie_legumes', methods: ['GET'])]
    public function listeLegumes(ProduitRepository $repoProduit, CategorieRepository $repoCategorie): Response
    {
        $categorieLegumes = $repoCategorie->findOneBy(['slug' => 'Légumes']); // Assurez-vous que le slug est correct

        // Utiliser l'ID de la catégorie des légumes pour trouver les produits associés
        $produits = $repoProduit->findByCategorie($categorieLegumes->getId());

        return $this->render('frontend/categorie/legumes.html.twig', [
            'categorie' => $categorieLegumes,
            'produits' => $produits
        ]);
    }

    #[Route('/categories/fruits', name: 'app_categorie_fruits', methods: ['GET'])]
    public function listeFruits(ProduitRepository $repoProduit, CategorieRepository $repoCategorie): Response
    {
        $categorieFruits = $repoCategorie->findOneBy(['slug' => 'Fruits']); // Assurez-vous que le slug est correct

        // Utiliser l'ID de la catégorie des fruits pour trouver les produits associés
        $produits = $repoProduit->findByCategorie($categorieFruits->getId());

        return $this->render('frontend/categorie/fruits.html.twig', [
            'categorie' => $categorieFruits,
            'produits' => $produits
        ]);
    }

    #[Route('/categories/boissons', name: 'app_categorie_boissons', methods: ['GET'])]
    public function listeBoissons(ProduitRepository $repoProduit, CategorieRepository $repoCategorie): Response
    {
        $categorieBoissons = $repoCategorie->findOneBy(['slug' => 'Boissons']); // Assurez-vous que le slug est correct

        // Utiliser l'ID de la catégorie des boissons pour trouver les produits associés
        $produits = $repoProduit->findByCategorie($categorieBoissons->getId());

        return $this->render('frontend/categorie/boissons.html.twig', [
            'categorie' => $categorieBoissons,
            'produits' => $produits
        ]);
    }
}
