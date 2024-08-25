<?php

namespace App\Controller\Backend;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminCategorieController extends AbstractController
{
    /**
     * Crée une nouvelle catégorie.
     * 
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités pour persister les données.
     * @return Response La réponse HTTP avec la vue du formulaire de création de catégorie.
     */
    #[Route('/categorie/create', name: 'app_admin.categorie.create', methods: ['GET', 'POST'])]
    public function createCategorie(Request $request, EntityManagerInterface $manager): Response
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            $this->addFlash('success', 'La catégorie a bien été créée');
            return $this->redirectToRoute('app_admin.categorie');
        }

        return $this->render('backend/categorie/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Édite une catégorie existante.
     * 
     * @param Categorie $categorie L'entité catégorie à éditer.
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités pour persister les données.
     * @return Response La réponse HTTP avec la vue du formulaire d'édition de catégorie.
     */
    #[Route('/categorie/edit/{id}', name: 'app_admin.categorie.edit', methods: ['GET', 'POST'])]
    public function editCategorie( Categorie $categorie, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            
            $this->addFlash('success', 'La catégorie a bien été modifiée');

            return $this->redirectToRoute('app_admin.categorie', ['id' => $categorie->getId()]);
        }

        return $this->render('backend/categorie/edit.html.twig', [
            'form' => $form,
            'categorie' => $categorie,
        ]);
    }

    /**
     * Affiche une liste de catégories.
     * 
     * @param Request $request L'objet de requête HTTP.
     * @param CategorieRepository $categorieRepository Le repository pour accéder aux données des catégories.
     * @return Response Une réponse HTTP qui rend le template backend/categorie/list.html.twig avec les catégories triées.
     */
    #[Route('/categorie', name: 'app_admin.categorie', methods: ['GET'])]
    public function list(Request $request, CategorieRepository $categorieRepository): Response
    {
        $sort = $request->query->get('sort', 'nom');
        $direction = $request->query->get('direction', 'asc');
    
        $categories = $categorieRepository->findBy([], [$sort => $direction]);
    
        return $this->render('backend/categorie/list.html.twig', [
            'categories' => $categories,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * Supprime une catégorie spécifique.
     *
     * @param Categorie $categorie L'entité catégorie à supprimer.
     * @param Request $request L'objet de requête HTTP.
     * @param EntityManagerInterface $manager L'EntityManager pour gérer les opérations de base de données.
     * @return Response Une réponse HTTP qui redirige vers la liste des catégories après suppression.
     */
    #[Route('/categorie/{id}', name: 'app_admin.categorie.delete', methods: ['GET', 'POST'])]
    public function deleteCategorie(Categorie $categorie, Request $request, EntityManagerInterface $manager): response
    {
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->get('_token'))) {
            $manager->remove($categorie);
            $manager->flush();
            
            $this->addFlash('success', 'La catégorie a bien été supprimée');
        
        return $this->redirectToRoute('app_admin.categorie');
        }
    }
}
