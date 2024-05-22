<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurDetails;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur/edition/{id}', name: 'app_utilisateur.edit')]
    public function edit(Utilisateur $utilisateur, UtilisateurDetails $utilisateurDetails, Request $request, EntityManagerInterface $manager): Response
    {   
        if(!$this->getUser()) {
            return $this->redirectToRoute('app_security.login');
        }
    
        if($this->getUser() !== $utilisateur) {
            return $this->redirectToRoute('app_security.login');
        }
        
        $form = $this->createForm(UtilisateurType::class, $utilisateurDetails);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $utilisateurDetails = $form->getData();
            $manager->persist($utilisateurDetails);
            $manager->flush();

            $this->addFlash('success',
                            'Votre profil a bien été mis à jour.'
            );
            return $this->redirectToRoute('app_security.login');
        }

        return $this->render('pages/utilisateur/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
