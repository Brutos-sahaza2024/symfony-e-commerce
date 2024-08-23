<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends AbstractController
{
    #[Route('/api/payment', name: 'api_payment', methods: ['POST'])]
    public function createPaymentIntent(Request $request): Response
    {
        Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $data = json_decode($request->getContent(), true);
        $cart = $data['cart'];
        $amount = 0;
        $currency = 'usd';

        foreach ($cart as $item) {
            $amount += $item['price'] * $item['quantity'];
        }

        $amount = (int) round($amount * 100);

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
            ]);

            return new Response(json_encode(['clientSecret' => $paymentIntent->client_secret]), 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return new Response(json_encode(['error' => $e->getMessage()]), 500, ['Content-Type' => 'application/json']);
        }
    }
}
