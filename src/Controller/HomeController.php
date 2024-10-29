<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour la page d'accueil du frontoffice.
 */
class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil.
     *
     * @param CategoryRepository $categoryRepository Le repository pour accéder aux données des catégories.
     * @return Response Une réponse HTTP qui rend le template frontoffice/home/index.html.twig avec les catégories.
     */
    #[Route('/', name: 'app_home_page')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('frontoffice/home_page/home.html.twig', [
            'categories' => $categories
        ]);
    }
}
