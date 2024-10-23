<?php

namespace App\Controller\Backend;

use App\Entity\Visitor;
use App\Entity\Producer;
use App\Entity\Utilisateur;
use App\Form\VisitorEditAsAdminType;
use App\Repository\VisitorRepository;
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
#[Route('/admin/visitor')]
class VisitorController extends AbstractController
{
    /**
     * Affiche une liste d'utilisateurs, à l'exception des producteurs.
     *
     * @param UtilisateurRepository $repoUtilisateur Le repository pour accéder aux données des utilisateurs.
     * @return Response Une réponse HTTP qui rend le template backend/utilisateur/list.html.twig avec les utilisateurs.
     */
    #[Route('/', name: 'app_admin.visitor', methods: ['GET'])]
    public function listUtilisateur(VisitorRepository $visitorRepository): Response
    {
        return $this->render('backend/utilisateur/list.html.twig', [
            'visitors' => $visitorRepository->findAll(),
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
    #[Route('/edition/{id}', name: 'app_admin_visitor.edit', methods: ['GET', 'POST'])]
    public function edit(Visitor $visitor, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $form = $this->createForm(VisitorEditAsAdminType::class, $visitor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les rôles de l'utilisateur
            $role = $form->get('roles')->getData();

            // Vérifie si l'utilisateur actuellement connecté est le même que l'utilisateur que nous essayons de modifier
            if ($security->getUser() !== $visitor || $role !== 'ROLE_ADMIN' || in_array('ROLE_SUPER_ADMIN', $security->getUser()->getRoles())) {
                // Ajoute le role à l'utilisateur connecté, fusionne et supprime les doublons
                if ($role === 'ROLE_ADMIN') {
                    $visitor->setRoles(array_unique(array_merge($visitor->getRoles(), ['ROLE_ADMIN'])));
                } elseif ($role === 'ROLE_PRODUCTEUR') {
                    $visitor->setRoles(array_unique(array_merge($visitor->getRoles(), ['ROLE_PRODUCTEUR'])));
                } else {
                    // Supprime le role ROLE_ADMIN et ROLE_PRODUCTEUR
                    $roles = $visitor->getRoles();
                    $roles = array_diff($roles, ['ROLE_ADMIN', 'ROLE_PRODUCTEUR']);
                    $roles = array_values($roles); // Réindexez le tableau
                    $visitor->setRoles($roles);
                }
            }

            $entityManager->persist($visitor);
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
            return $this->redirectToRoute('app_admin.visitor', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend/utilisateur/edit.html.twig', [
            'utilisateur' => $visitor,
            'form' => $form,
        ]);
    }

    #[Route('/validate/{id}', name: 'app_validate_visitor')]
    public function validateVisitor(Visitor $visitor, EntityManagerInterface $em): Response
    {
        $visitor->setStatus("confirmed");
        $em->flush();
        return $this->redirectToRoute('app_admin.visitor');
    }

    /**
     * Supprime un utilisateur spécifique.
     *
     * @param Request $request La requête HTTP.
     * @param Utilisateur $utilisateur L'entité utilisateur à supprimer.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités.
     * @return Response Une réponse HTTP qui redirige vers la liste des utilisateurs après suppression.
     */
    #[Route('/{id}', name: 'app_admin_visitor_delete', methods: ['POST'])]
    public function deleteVisitor(Request $request, Visitor $visitor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $visitor->getId(), $request->request->get('_token'))) {
            $entityManager->remove($visitor);
            $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

        return $this->redirectToRoute('app_admin.visitor', [], Response::HTTP_SEE_OTHER);
        }
    }


}
