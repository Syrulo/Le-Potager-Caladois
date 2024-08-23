<?php

namespace App\Controller\Frontend;

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
    /**
     * Constructeur pour le contrôleur UtilisateurController.
     *
     * @param Security $security Le service de sécurité pour gérer les utilisateurs et les rôles.
     * @param UtilisateurRepository $repo Le repository pour accéder aux données des utilisateurs.
     */
    public function __construct(
        private Security $security,
        private UtilisateurRepository $repo
    ) {
    }

    /**
     * Affiche le profil de l'utilisateur connecté.
     *
     * @return Response Une réponse HTTP qui rend le template frontend/utilisateur/profil.html.twig avec les informations de l'utilisateur connecté.
     */
    #[Route('', name: 'profil')]
    public function showProfil(): Response
    {
        $user = $this->security->getUser();

        return $this->render('frontend/utilisateur/profil.html.twig', [
            'utilisateur' => $user,
        ]);
    }

    /**
     * Édite le profil d'un utilisateur.
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $em Le gestionnaire d'entités pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui rend le formulaire d'édition de profil ou redirige après la modification.
     */
    #[Route('/edit', name: 'profil.edit', methods: ['GET', 'POST'])]
    public function editProfil(Request $request, EntityManagerInterface $em): Response 
    {

        $user = $this->security->getUser();

        $form = $this->createForm(AdminUtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('frontend/utilisateur/edit.html.twig', [
            'utilisateur' => $user,
            'form' => $form,
            'title_heading' => 'Editez votre profil'
        ]);
    }
}
