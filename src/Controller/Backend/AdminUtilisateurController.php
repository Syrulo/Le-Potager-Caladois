<?php

namespace App\Controller\Backend;

use App\Entity\Utilisateur;
use App\Form\AdminUtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour la gestion des utilisateurs dans l'administration.
 */
#[Route('/admin/utilisateur')]
class AdminUtilisateurController extends AbstractController
{
    /**
     * Affiche une liste d'utilisateurs, à l'exception des producteurs.
     *
     * @param UtilisateurRepository $repoUtilisateur Le repository pour accéder aux données des utilisateurs.
     * @return Response Une réponse HTTP qui rend le template backend/utilisateur/list.html.twig avec les utilisateurs.
     */
    #[Route('/', name: 'app_admin.utilisateur', methods: ['GET'])]
    public function listUtilisateur(UtilisateurRepository $repoUtilisateur): Response
    {
        return $this->render('backend/utilisateur/list.html.twig', [
            'utilisateurs' => $repoUtilisateur->findAllExceptProducteurs(),
        ]);
    }

    /**
     * Édite un utilisateur existant.
     *
     * @param Utilisateur $utilisateur L'entité utilisateur à éditer.
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités.
     * @param Security $security Le service de sécurité pour vérifier les rôles et l'utilisateur connecté.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/edition/{id}', name: 'app_admin_utilisateur.edit', methods: ['GET', 'POST'])]
    public function edit(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $form = $this->createForm(AdminUtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $role = $form->get('roles')->getData();

            // Vérifie si l'utilisateur actuellement connecté est le même que l'utilisateur que nous essayons de modifier
            if ($security->getUser() !== $utilisateur || $role !== 'ROLE_ADMIN' || in_array('ROLE_SUPER_ADMIN', $security->getUser()->getRoles())) {
                if ($role === 'ROLE_ADMIN') {
                    $utilisateur->setRoles(array_unique(array_merge($utilisateur->getRoles(), ['ROLE_ADMIN'])));
                } elseif ($role === 'ROLE_PRODUCTEUR') {
                    $utilisateur->setRoles(array_unique(array_merge($utilisateur->getRoles(), ['ROLE_PRODUCTEUR'])));
                } else {
                    $roles = $utilisateur->getRoles();
                    $roles = array_diff($roles, ['ROLE_ADMIN', 'ROLE_PRODUCTEUR']);
                    $roles = array_values($roles); // Réindexez le tableau
                    $utilisateur->setRoles($roles);
                }
            }

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
            return $this->redirectToRoute('app_admin.utilisateur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    /**
     * Supprime un utilisateur spécifique.
     *
     * @param Request $request La requête HTTP.
     * @param Utilisateur $utilisateur L'entité utilisateur à supprimer.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités.
     * @return Response Une réponse HTTP qui redirige vers la liste des utilisateurs après suppression.
     */
    #[Route('/{id}', name: 'app_admin_utilisateur_delete', methods: ['POST'])]
    public function deleteUtilisateur(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

        return $this->redirectToRoute('app_admin.utilisateur', [], Response::HTTP_SEE_OTHER);
        }
    }
}
