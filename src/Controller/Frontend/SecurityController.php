<?php

namespace App\Controller\Frontend;

use App\Entity\Visitor;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Contrôleur pour la gestion de la sécurité (connexion, déconnexion, inscription).
 */
class SecurityController extends AbstractController
{
    /**
     * Gère la connexion des visitors.
     *
     * @param AuthenticationUtils $authenticationUtils Utilitaire d'authentification pour obtenir le dernier nom d'visitor et les erreurs.
     * @return Response Une réponse HTTP qui rend le template de connexion ou redirige vers la page d'accueil si l'visitor est déjà connecté.
     */
    #[Route('/connexion', name: 'app_security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * Gère la déconnexion des visitors.
     *
     * Cette méthode peut être vide - elle sera interceptée par le pare-feu de déconnexion de Symfony.
     */
    #[Route('/deconnexion', 'app_security.logout')]
    public function logout()
    {
        
    }

    /**
     * Gère l'inscription des nouveaux visitors.
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui rend le template d'inscription ou redirige après l'inscription.
     */
    #[Route('/inscription', 'app_security.inscription', methods: ['GET', 'POST'])]
    public function inscription(Request $request, EntityManagerInterface $manager) : Response
    {

        $visitor = new Visitor();
        $form = $this->createForm(InscriptionType::class, $visitor);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($visitor);
            $manager->flush();
            $this->addFlash(
                'success',
                'Votre compte a bien été crée.'
            );

            return $this->redirectToRoute('app_security.login');
        }    
        
        return $this->render('security/inscription.html.twig', [
            'form' => $form
        ]);
    }
}
