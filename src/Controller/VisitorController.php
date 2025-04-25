<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Visitor;
use App\Form\Visitor\VisitorEditType;
use App\Repository\VisitorRepository;
use App\Form\Producer\NewProducerType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Admin\VisitorEditAsAdminType;
use App\Service\Mailer\UserMailerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VisitorController extends AbstractController
{
    /**
     * Constructeur pour le contrôleur UtilisateurController.
     *
     * @param Security $security Le service de sécurité pour gérer les utilisateurs et les rôles.
     * @param VisitorRepository $visitorRepository Le repository pour accéder aux données des utilisateurs.
     * @param UserMailerInterface $userMailer Le service pour envoyé un mail pour la validation d'un nouveau producteur
     */
    public function __construct(
        private Security $security,
        private VisitorRepository $visitorRepository,
        private readonly UserMailerInterface $userMailer
    ) {}

    /**
     * Crée un nouveau producteur et affiche le formulaire de création.
     *
     * @param Request $request La requête HTTP
     * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données
     * @return Response La réponse HTTP
     */
    #[Route('/visitor/new', name: 'app_visitor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $visitor = new Visitor();
        $form = $this->createForm(NewProducerType::class, $visitor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $visitor->setRoles(['ROLE_PRODUCER']);
            $visitor->setStatus("pending");
            $em->persist($visitor);
            $em->flush();
            $this->userMailer->newPendingProducer($visitor);
            return $this->redirectToRoute('app_login');
        }
        return $this->render('/frontoffice/utilisateur/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Affiche le profil de l'utilisateur connecté.
     *
     * @return Response Une réponse HTTP qui rend le template frontoffice/utilisateur/profil.html.twig avec les informations de l'utilisateur connecté.
     */
    #[Route('/profil', name: 'profil')]
    public function showProfil(): Response
    {
        $user = $this->security->getUser();

        return $this->render('frontoffice/utilisateur/profil.html.twig', [
            'visitor' => $user,
        ]);
    }

    /**
     * Édite le profil d'un utilisateur.
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $em Le gestionnaire d'entités pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui rend le formulaire d'édition de profil ou redirige après la modification.
     */
    #[Route('/profil/edit', name: 'profil_edit', methods: ['GET', 'POST'])]
    public function editProfil(Request $request, EntityManagerInterface $em): Response
    {

        $user = $this->security->getUser();
        $address = new Address();
        $form = $this->createForm(VisitorEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }
        // dd($form);
        return $this->render('frontoffice/utilisateur/edit.html.twig', [
            'form' => $form,
            'title_heading' => 'Editez votre profil'
        ]);
    }

    /**
     * Affiche une liste d'utilisateurs, à l'exception des producteurs.
     *
     * @param UtilisateurRepository $repoUtilisateur Le repository pour accéder aux données des utilisateurs.
     * @return Response Une réponse HTTP qui rend le template backoffice/utilisateur/list.html.twig avec les utilisateurs.
     */
    #[Route('/admin/visitor/', name: 'app_admin_visitor', methods: ['GET'])]
    public function listUtilisateur(VisitorRepository $visitorRepository): Response
    {
        return $this->render('backoffice/utilisateur/list.html.twig', [
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
    #[Route('/admin/visitor/edition/{id}', name: 'app_admin_visitor_edit', methods: ['GET', 'POST'])]
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
            return $this->redirectToRoute('app_admin_visitor', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backoffice/utilisateur/edit.html.twig', [
            'utilisateur' => $visitor,
            'form' => $form,
        ]);
    }

    /**
     * Valide un visiteur en changeant son statut à "confirmed".
     *
     * @param Visitor $visitor L'entité Visitor à valider
     * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données
     * @return Response La réponse HTTP
     */
    #[Route('/admin/visitor/validate/{id}', name: 'app_validate_visitor')]
    public function validateVisitor(Visitor $visitor, EntityManagerInterface $em): Response
    {
        $visitor->setStatus("confirmed");
        $em->flush();
        $this->userMailer->newProducerValidated($visitor);

        $this->addFlash('success', 'L\'utilisateur a bien été validé');
        return $this->redirectToRoute('app_admin_visitor');
    }

    /**
     * Supprime un utilisateur spécifique.
     *
     * @param Request $request La requête HTTP.
     * @param Utilisateur $utilisateur L'entité utilisateur à supprimer.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités.
     * @return Response Une réponse HTTP qui redirige vers la liste des utilisateurs après suppression.
     */
    #[Route('/admin/visitor/{id}', name: 'app_admin_visitor_delete', methods: ['POST'])]
    public function deleteVisitor(Request $request, Visitor $visitor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $visitor->getId(), $request->request->get('_token'))) {
            $entityManager->remove($visitor);
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été supprimé');

            return $this->redirectToRoute('app_admin_visitor', [], Response::HTTP_SEE_OTHER);
        }
    }
}
