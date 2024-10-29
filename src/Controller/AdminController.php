<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour les routes d'administration.
 */
#[Route('/admin')]
class AdminController extends AbstractController
{
    /**
     * Affiche le tableau de bord de l'administration.
     *
     * @return Response Une réponse HTTP qui rend le template backoffice/adminDashboard.html.twig.
     */
    #[Route('', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('backoffice/adminDashboard.html.twig');
    }
}