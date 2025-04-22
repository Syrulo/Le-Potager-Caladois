<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Product;
use App\Entity\Producer;
use App\Service\PriceChecker;
use App\Form\Producer\ProducerType;
use App\Form\Admin\AdminProductType;
use App\Repository\ProductRepository;
use App\Repository\VisitorRepository;
use App\Repository\ProducerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\Admin\ProductEditAsAdminType;
use App\Form\Producer\NewProductProducerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Producer\ProductEditAsProducerType;
use App\Service\Mailer\ProductPriceDropMailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    /**
     * @param ProductPriceDropMailerInterface $productPriceDropMailerInterface injection du service d'envoi de mail lors d'une baisse de prix de 30% minimum
     * @param PriceCkecker $priceChecker injection du service de vérification de la baisse de 30% du prix d'un produit
     */
    public function __construct(
        private ProductPriceDropMailerInterface $productPriceDropMailerInterface,
        private PriceChecker $priceChecker
        ) {}

    /**
     * Affiche le tableau de bord du producteur et gère la création d'un producteur.
     *
     * @param Request $request La requête HTTP
     * @param EntityManagerInterface $em L'EntityManager pour interagir avec la base de données
     * @param VisitorRepository $visitorRepository Le repository des visiteurs
     * @return Response La réponse HTTP
     */
    #[Route('/product', name: 'app_product')]
    public function index(Request $request, EntityManagerInterface $em, VisitorRepository $visitorRepository): Response
    {
        $producer = new Producer();
        $address = new Address();
        $form = $this->createForm(ProducerType::class, $producer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $producer->setVisitor($this->getUser());
            $em->persist($producer);
            $em->flush();
            return $this->redirectToRoute('app_producer_show', ['id' => $producer->getId()]);
        }
        return $this->render('backoffice/producteur/producerDashboard.html.twig', [
            'visitor' => $visitorRepository->findAllWithProducerAndProducts(["id" => $this->getUser()->getId()])[0],
            'form' => $form,
        ]);
    }

    /**
     * Affiche les détails d'un produit spécifique.
     *
     * @param Product $product L'entité produit dont les détails doivent être affichés.
     * @return Response Une réponse HTTP qui rend le template frontoffice/produit/show.html.twig avec les détails du produit.
     */
    #[Route('/product/details/{slug}', name: 'app_product_details')]
    public function show(Product $product): Response
    {
        return $this->render('frontoffice/produit/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * Affiche une liste de produits en fonction des critères de recherche.
     *
     * @param ProductRepository $productRepository Le repository pour accéder aux données des produits.
     * @param Request $request La requête HTTP.
     * @return Response Une réponse HTTP qui rend le template frontoffice/produit/list.html.twig avec les produits trouvés ou un message d'erreur.
     */
    #[Route('/product/list', name: 'app_product_list', methods: ['GET'])]
    public function search(ProductRepository $productRepository, Request $request): Response
    {
        // Initialisation de la variable $products
        $products = [];

        $keyword = $request->get('search');
        if ($keyword !== null && $keyword !== '') {
            $searchType = $request->get('search_type');
            // en fonction de la variable SearchType venant du formulaire, on fait une requête spécifique
            $products = $productRepository->search($keyword, $searchType);
            if (empty($products)) {
                $this->addFlash('error', 'Aucun produit correspondant');
                return $this->redirectToRoute('app_product_list');
            }
        } else {
            $this->addFlash('error', 'Veuillez fournir un critère de recherche.');
        }
        return $this->render('frontoffice/produit/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Crée un nouveau produit.
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/product/create', name: 'app_producer_product_add', methods: ['GET', 'POST'])]
    public function createProducerProduct(Request $request, EntityManagerInterface $manager, ProducerRepository $producerRepository): Response
    {
        $product = new Product();
        $producer = $producerRepository->findBy(["visitor" => $this->getUser()->getId()]);
        $product->setProducer($producer[0]);
        $form = $this->createForm(NewProductProducerType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été crée');
            return $this->redirectToRoute('app_product');
        }

        return $this->render('backoffice/produit/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Édite un produit existant.
     *
     * @param Product $product L'entité produit à éditer.
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/product/edit/{id}', name: 'app_producer_product_edit', methods: ['GET', 'POST'])]
    public function editProducerProduct(
        Product $product,
        Request $request, 
        EntityManagerInterface $manager, 
        ProducerRepository $producerRepository
        ): Response
    {
        $oldPrice = $product->getPrix();

        $producer = $producerRepository->findBy(["visitor" => $this->getUser()->getId()]);
        $product->setProducer($producer[0]);

        $form = $this->createForm(ProductEditAsProducerType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTimeImmutable());

            $percentageVariation = $this->priceChecker->calculatePriceVariation($oldPrice, $product->getPrix());

            if($percentageVariation) {
                $this->productPriceDropMailerInterface->sendPriceAlert($product, $oldPrice, $product->getPrix());
                $this->addFlash('warning', 'La baisse de prix est égale ou supérieure à 30%');
            }

            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié');

            return $this->redirectToRoute('app_product');
        }

        return $this->render('backoffice/produit/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Supprime un produit.
     *
     * @param Product $product L'entité produit à supprimer.
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/product/delete/{id}', name: 'app_product_delete', methods: ['GET', 'POST'])]
    public function deleteProducerProduct(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('_token'))) {
            $manager->remove($product);
            $manager->flush();

            $this->addFlash('success', 'Le produit a bien été supprimé');
            
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin_product');
            }

            return $this->redirectToRoute('app_product');
        }
    }

    /**
     * Affiche la liste des produits.
     *
     * @param ProductRepository $productRepository Le dépôt des produits.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/admin/product', name: 'app_admin_product', methods: ['GET', 'POST'])]
    public function list(Request $request, ProductRepository $productRepository): Response
    {
        $sort = $request->query->get('sort', 'nom');
        $direction = $request->query->get('direction', 'asc');

        $products = $productRepository->findBy([], [$sort => $direction]);

        return $this->render('backoffice/produit/list.html.twig', [
            'products' => $products,
            'sort' => $sort,
            'direction' => $direction,
        ]);
    }

    /**
     * Crée un nouveau produit.
     *
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/admin/product/create', name: 'app_admin_product_create', methods: ['GET', 'POST'])]
    public function createProduct(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product();

        $form = $this->createForm(AdminProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été crée');
            return $this->redirectToRoute('app_admin_product');
        }

        return $this->render('backoffice/produit/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Édite un produit existant.
     *
     * @param Product $product L'entité produit à éditer.
     * @param Request $request La requête HTTP.
     * @param EntityManagerInterface $manager Le gestionnaire d'entités.
     *
     * @return Response La réponse HTTP.
     */
    #[Route('/admin/product/edit/{id}', name: 'app_admin_product_edit', methods: ['GET', 'POST'])]
    public function editProduct(Product $product, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProductEditAsAdminType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié');
            return $this->redirectToRoute('app_admin_product');
        }

        return $this->render('backoffice/produit/edit.html.twig', [
            'form' => $form,
        ]);
    }
}
