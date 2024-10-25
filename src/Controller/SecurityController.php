<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Gère la connexion des visitors.
     *
     * @param AuthenticationUtils $authenticationUtils Utilitaire d'authentification pour obtenir le dernier nom d'visitor et les erreurs.
     * @return Response Une réponse HTTP qui rend le template de connexion ou redirige vers la page d'accueil si l'visitor est déjà connecté.
     */
    #[Route('/connexion', name: 'app_security_login', methods: ['GET', 'POST'])]
    public function connexion(AuthenticationUtils $authenticationUtils): Response
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
     * Gère l'inscription des nouveaux visitors.
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui rend le template d'inscription ou redirige après l'inscription.
     */
    #[Route('/inscription', 'app_security_inscription', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('app_security_login');
        }    
        
        return $this->render('security/inscription.html.twig', [
            'form' => $form
        ]);
    }
}
