<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShoppingCartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);

        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            if ($product) {
                $cartWithData[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }

        $total = array_reduce($cartWithData, function($carry, $item) {
            return $carry + ($item['product']->getPrice() * $item['quantity']);
        }, 0);

        return $this->render('shopping_cart_controllers/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = 0;
        }

        $cart[$id]++;

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove($id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/update/{id}', name: 'app_cart_update', methods: ['POST'])]
    public function update($id, Request $request, SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);
        $quantity = $request->request->get('quantity');

        if (!is_numeric($quantity) || $quantity < 0) {
            $this->addFlash('danger', 'Quantité invalide.');
            return $this->redirectToRoute('app_cart');
        }

        if (!isset($cart[$id])) {
            $this->addFlash('danger', 'Produit non trouvé dans le panier.');
            return $this->redirectToRoute('app_cart');
        }

        if ($quantity == 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = (int) $quantity;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('app_cart');
    }
}
