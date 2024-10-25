<?php

namespace App\Controller\Frontend;

use App\Form\AdminEditType;
use App\Form\AdminUtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour la gestion des utilisateurs dans le frontend.
 */
#[Route('/profil')]
class UtilisateurController extends AbstractController
{
    
}
