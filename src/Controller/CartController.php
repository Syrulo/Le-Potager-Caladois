<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductQuantityType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/add-to-cart/{id}', name: 'add_to_cart')]
    public function addToCart(Product $product, Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(ProductQuantityType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quantity = $form->get('quantity')->getData();
            $cart = $session->get('cart', []);

            if (empty($cart[$product->getId()])) {
                $cart[$product->getId()] = $quantity;
            } else {
                $cart[$product->getId()] += $quantity;
            }

            $session->set('cart', $cart);
        }

        return $this->redirectToRoute('app_category_list', ['slug' => $product->getCategory()->getSlug()]);
    }

    #[Route('/cart', name: 'cart')]
    public function show(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            $products[] = $product;
            $total += $product->getprix() * $quantity;
        }

        return $this->render('frontoffice/cart/index.html.twig', [
            'products' => $products,
            'totalPrice' => $total,
        ]);
    }
}
