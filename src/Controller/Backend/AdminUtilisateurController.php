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

#[Route('/admin/utilisateur')]
class AdminUtilisateurController extends AbstractController
{

    #[Route('/', name: 'app_admin.utilisateur', methods: ['GET'])]
    public function listUtilisateur(UtilisateurRepository $repoUtilisateur): Response
    {
        return $this->render('backend/utilisateur/list.html.twig', [
            'utilisateurs' => $repoUtilisateur->findAll(),
        ]);
    }

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
                } else {
                    $roles = $utilisateur->getRoles();
                    $roles = array_diff($roles, ['ROLE_ADMIN']);
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
