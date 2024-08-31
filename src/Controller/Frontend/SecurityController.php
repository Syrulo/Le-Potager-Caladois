<?php

namespace App\Controller\Frontend;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurDetails;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Contrôleur pour la gestion de la sécurité (connexion, déconnexion, inscription).
 */
class SecurityController extends AbstractController
{
    /**
     * Gère la connexion des utilisateurs.
     *
     * @param AuthenticationUtils $authenticationUtils Utilitaire d'authentification pour obtenir le dernier nom d'utilisateur et les erreurs.
     * @return Response Une réponse HTTP qui rend le template de connexion ou redirige vers la page d'accueil si l'utilisateur est déjà connecté.
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
     * Gère la déconnexion des utilisateurs.
     *
     * Cette méthode peut être vide - elle sera interceptée par le pare-feu de déconnexion de Symfony.
     */
    #[Route('/deconnexion', 'app_security.logout')]
    public function logout()
    {
        
    }

    /**
     * Gère l'inscription des nouveaux utilisateurs.
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui rend le template d'inscription ou redirige après l'inscription.
     */
    #[Route('/inscription', 'app_security.inscription', methods: ['GET', 'POST'])]
    public function inscription(Request $request, EntityManagerInterface $manager) : Response
    {

        $utilisateur = new Utilisateur();
        $utilisateurDetails = new UtilisateurDetails();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();            
            $utilisateur->setActive(true);
            $utilisateur->setRoles(['ROLE_USER']);
            $this->addFlash(
                'success',
                'Votre compte a bien été crée.'
            );

            $manager->persist($utilisateur);
            $manager->flush();
             // Récupération de l'identifiant de l'utilisateur
            $lastId = $utilisateur->getId();
            $utilisateurDetails->setUtilisateur($utilisateur);
            $manager->persist($utilisateurDetails);
            $manager->flush();



            return $this->redirectToRoute('app_security.login');
        }    
        
        return $this->render('security/inscription.html.twig', [
            'form' => $form
        ]);
    }
}
