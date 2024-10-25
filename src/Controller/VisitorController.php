<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Visitor;
use App\Entity\Producer;
use App\Form\AdminEditType;
use App\Form\NewProducerType;
use App\Repository\VisitorRepository;
use App\Repository\ProducerRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     */
    public function __construct(
        private Security $security,
        private VisitorRepository $visitorRepository
    ) {
    }

    #[Route('/visitor', name: 'app_visitor')]
    public function index(): Response
    {
        return $this->render('visitor/index.html.twig', [
            'controller_name' => 'VisitorController',
        ]);
    }
    #[Route('/visitor/new', name: 'app_visitor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $producer = new Visitor();
        $form = $this->createForm(NewProducerType::class, $producer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $producer->setRoles(['ROLE_PRODUCER']);
            $producer->setStatus("pending");
            $em->persist($producer);
            $em->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('visitor/new.html.twig', [
            'form' => $form,
        ]);
    }

   
    /**
     * Affiche le profil de l'utilisateur connecté.
     *
     * @return Response Une réponse HTTP qui rend le template frontend/utilisateur/profil.html.twig avec les informations de l'utilisateur connecté.
     */
    #[Route('/profil', name: 'profil')]
    public function showProfil(): Response
    {
        $user = $this->security->getUser();

        return $this->render('frontend/utilisateur/profil.html.twig', [
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
        $form = $this->createForm(AdminEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }
        // dd($form);
        return $this->render('frontend/utilisateur/edit.html.twig', [
            'form' => $form,
            'title_heading' => 'Editez votre profil'
        ]);
    }
    
}
