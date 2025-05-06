<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Admin\AdminCategoryType;
use App\Form\ProductQuantityType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    /**
     * Affiche les produits d'une catégorie spécifique.
     *
     * @param string             $slug               le slug de la catégorie
     * @param ProductRepository  $productRepository  le repository pour accéder aux données des produits
     * @param CategoryRepository $categoryRepository le repository pour accéder aux données des catégories
     *
     * @return Response Une réponse HTTP qui rend le template frontoffice/categorie/show.html.twig avec la catégorie et ses produits.
     */
    #[Route('/categories/{slug}', name: 'app_category_list', methods: ['GET'])]
    public function categoryList(string $slug, ProductRepository $productRepository, CategoryRepository $categoryRepository, SessionInterface $session): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]); // Utiliser le slug pour trouver la catégorie

        if (!$category) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas.');
        }

        // Utiliser l'ID de la catégorie pour trouver les produits associés
        $products = $productRepository->findBy(['category' => $category->getId()]);

        $forms = [];
        foreach ($products as $product) {
            $forms[$product->getId()] = $this->createForm(ProductQuantityType::class, null, [
                'action' => $this->generateUrl('add_to_cart', ['id' => $product->getId()]),
                'method' => 'POST',
            ])->createView();
        }

        return $this->render('frontoffice/categorie/show.html.twig', [
            'category' => $category,
            'products' => $products,
            'forms' => $forms,
        ]);
    }

    /**
     * Affiche une liste de catégories.
     *
     * @param Request            $request            L'objet de requête HTTP
     * @param CategoryRepository $categoryRepository le repository pour accéder aux données des catégories
     *
     * @return Response Une réponse HTTP qui rend le template backoffice/categorie/list.html.twig avec les catégories triées.
     */
    #[Route('/admin/category', name: 'app_admin_category', methods: ['GET'])]
    public function list(Request $request, CategoryRepository $categoryRepository): Response
    {
        $sort = $request->query->get('sort', 'nom');
        $direction = $request->query->get('direction', 'asc');

        $categories = $categoryRepository->findBy([], [$sort => $direction]);

        return $this->render('backoffice/categorie/list.html.twig', [
            'categories' => $categories,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * Crée une nouvelle catégorie.
     *
     * @param Request                $request la requête HTTP
     * @param EntityManagerInterface $manager le gestionnaire d'entités pour persister les données
     *
     * @return Response la réponse HTTP avec la vue du formulaire de création de catégorie
     */
    #[Route('/admin/category/create', name: 'app_admin_category_create', methods: ['GET', 'POST'])]
    public function createCategory(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();

        $form = $this->createForm(AdminCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'La catégorie a bien été créée');

            return $this->redirectToRoute('app_admin_category');
        }

        return $this->render('backoffice/categorie/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Édite une catégorie existante.
     *
     * @param Category               $category L'entité catégorie à éditer
     * @param Request                $request  la requête HTTP
     * @param EntityManagerInterface $manager  le gestionnaire d'entités pour persister les données
     *
     * @return Response la réponse HTTP avec la vue du formulaire d'édition de catégorie
     */
    #[Route('/admin/category/edit/{id}', name: 'app_admin_category_edit', methods: ['GET', 'POST'])]
    public function editCategory(Category $category, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AdminCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', 'La catégorie a bien été modifiée');

            return $this->redirectToRoute('app_admin_category', ['id' => $category->getId()]);
        }

        return $this->render('backoffice/categorie/edit.html.twig', [
            'form' => $form,
            'category' => $category,
        ]);
    }

    /**
     * Supprime une catégorie spécifique.
     *
     * @param Category               $category L'entité catégorie à supprimer
     * @param Request                $request  L'objet de requête HTTP
     * @param EntityManagerInterface $manager  L'EntityManager pour gérer les opérations de base de données
     *
     * @return Response une réponse HTTP qui redirige vers la liste des catégories après suppression
     */
    #[Route('/admin/category/{id}', name: 'app_admin_category_delete', methods: ['GET', 'POST'])]
    public function deleteCategory(Category $category, Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->get('_token'))) {
            $manager->remove($category);
            $manager->flush();

            $this->addFlash('success', 'La catégorie a bien été supprimée');

            return $this->redirectToRoute('app_admin_category');
        }

        $this->addFlash('error', 'Le token CSRF est invalide.');

        return $this->redirectToRoute('app_admin_category');
    }
}
