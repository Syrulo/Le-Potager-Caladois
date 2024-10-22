<?php

namespace App\Controller\Backend;

use App\Entity\Producer;
use App\Entity\Producteur;
use App\Entity\Utilisateur;
use App\Form\ProducteurType;
use App\Form\InscriptionProducteurType;
use App\Repository\ProducerRepository;
use App\Repository\ProducteurRepository;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur pour la gestion des producteurs dans l'administration.
 */
#[Route('/admin')]
class AdminProducteurController extends AbstractController
{
    /**
     * Crée un nouveau producteur.
     *
     * @param Request $request L'objet de requête HTTP.
     * @param EntityManagerInterface $manager L'EntityManager pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui rend le formulaire de création de producteur ou redirige après la création.
     */
    #[Route('/producteur/create', name: 'app_admin.producer.create', methods: ['GET', 'POST'])]
    public function createProducteur(Request $request, EntityManagerInterface $manager): Response
    {
        $producteur = new Producteur();
        $utilisateur = new Utilisateur();

        $form = $this->createForm(InscriptionProducteurType::class, [
            'utilisateur' => $utilisateur,
            'producteur' => $producteur
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $utilisateur = $data['utilisateur'];
            $producteur = $data['producteur'];

            $utilisateur->setRoles(['ROLE_PRODUCTEUR']);
            $utilisateur->setProducteur($producteur);
            $manager->persist($utilisateur);
            $manager->persist($producteur);
            $manager->flush();

            $this->addFlash('success', 'Le producteur a bien été ajouté');

            return $this->redirectToRoute('app_admin.producteur');
        }

        return $this->render('backend/producteur/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
    * Édite un producteur existant.
    *
    * @param Producteur $producteur L'entité producteur à éditer.
    * @param Request $request L'objet de requête HTTP.
    * @param EntityManagerInterface $manager L'EntityManager pour gérer les opérations de base de données.
    * @return Response Une réponse HTTP qui rend le formulaire d'édition de producteur ou redirige après la modification.
    */
    #[Route('/producteur/edit/{id}', name: 'app_admin.producer.edit', methods: ['GET', 'POST'])]
    public function editProducteur(Producer $producer, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProducteurType::class, $producer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($producer);
            $manager->flush();

            $this->addFlash('success', 'Le producteur a bien été modifié');
            
            return $this->redirectToRoute('app_admin.producteur');
        }

        return $this->render('backend/producteur/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Affiche une liste de producteurs.
     *
     * @param ProducteurRepository $repoProducteur Le repository pour accéder aux données des producteurs.
     * @param Request $request L'objet de requête HTTP.
     * @return Response Une réponse HTTP qui rend le template backend/producteur/list.html.twig avec les producteurs triés.
     */
    #[Route('/producer', name: 'app_admin.producer', methods: ['GET'])]
    public function listProducteur(ProducerRepository $producerRepository, Request $request): Response
    {
        // Récupérer les paramètres de tri depuis la requête
        $sort = $request->query->get('sort', 'id'); // Trier par 'id' par défaut
        $direction = $request->query->get('direction', 'asc'); // Trier par ordre ascendant par défaut
    
        // Récupérer les producteurs triés depuis le repository
        $producers = $producerRepository->findBy([], [$sort => $direction]);
    
        return $this->render('adminProducer.html.twig', [
            'producers' => $producers,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * Supprime un producteur spécifique ainsi que ses produits associés.
     *
     * @param Producteur $producteur L'entité producteur à supprimer.
     * @param Request $request L'objet de requête HTTP.
     * @param EntityManagerInterface $manager L'EntityManager pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui redirige vers la liste des producteurs après suppression.
     */
    #[Route('/producer/{id}', name: 'app_admin.producer.delete', methods: ['GET', 'POST'])]
    public function deleteProducteur(Producteur $producteur, Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $producteur->getId(), $request->get('_token'))) {
            // Supprimer les produits associés
            foreach ($producteur->getProduits() as $produit) {
                $manager->remove($produit);
            }
    
            // Supprimer le producteur
            $manager->remove($producteur);
            $manager->flush();
    
            $this->addFlash('success', 'Le producteur et ses produits ont bien été supprimés de la liste');
            
            return $this->redirectToRoute('app_admin.producteur');
        }
    
        return $this->redirectToRoute('app_admin.producteur');
    }

}
