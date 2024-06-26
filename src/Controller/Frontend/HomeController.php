<?php

namespace App\Controller\Frontend;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(CategorieRepository $repoCategorie): Response
    {
        $categories = $repoCategorie->findAll();
        return $this->render('frontend/home_page/home.html.twig', [
            'controller_name' => 'HomeController',
            'categories' => $categories
        ]);
    }
}
