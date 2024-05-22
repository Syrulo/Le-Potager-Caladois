<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('', name: 'app_admin')]
    public function index(ProduitRepository $repoProduit, CategorieRepository $repoCategorie): Response
    {
        // // Récupérer toutes les catégories
        $categories = $repoCategorie->findAll();

        // Récupérer tous les produits
        $produits = $repoProduit->findAll();

        return $this->render('admin/adminDashboard.html.twig', [
            'produits' => $produits,
            'categories' => $categories,
        ]);
    }
}