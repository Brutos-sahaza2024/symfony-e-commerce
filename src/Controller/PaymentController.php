<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function checkout(SessionInterface $session, ProductRepository $productRepository): Response
    {
        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $cart = $session->get('cart', []);
        $lineItems = [];

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            if ($product) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->getName(),
                        ],
                        'unit_amount' => $product->getPrice() * 100,
                    ],
                    'quantity' => $quantity,
                ];
            }
        }

        $successUrl = $this->generateUrl('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $cancelUrl = $this->generateUrl('payment_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
        return $this->redirect($checkoutSession->url);
    }

    #[Route('/payment/success', name: 'payment_success')]
    public function success(): Response
    {
        return $this->render('payment/success.html.twig');
    }

    #[Route('/payment/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }

    #[Route('/webhook', name: 'stripe_webhook')]
    public function webhook(Request $request): Response
    {
        $endpointSecret = $this->getParameter('stripe_endpoint_secret');
        $payload = @file_get_contents('php://input');
        $sigHeader = $request->headers->get('stripe-signature');
        $event = null;
    
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch(\UnexpectedValueException $e) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }
    
 
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSession($session);
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }
    
        return new Response('', Response::HTTP_OK);
    }

    private function handleCheckoutSession($session)
    {
        // Fulfill the purchase
        // Retrieve the session. If you require line items in the response, you may include them by expanding line_items.
        $session = \Stripe\Checkout\Session::retrieve($session->id, [
            'expand' => ['line_items'],
        ]);
    
        // Process the payment (e.g., mark order as paid)
    }

}
