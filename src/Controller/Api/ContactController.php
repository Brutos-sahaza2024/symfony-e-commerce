<?php

namespace App\Controller\Api;

use App\Service\EmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route('/api/contact', methods: ['POST'])]
    public function contact(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);


        if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            return $this->json(['error' => 'Tous les champs sont requis.'], Response::HTTP_BAD_REQUEST);
        }

        $this->emailService->sendContactEmail($data['name'], $data['email'], $data['message']);

        return $this->json(['message' => 'Message reçu'], Response::HTTP_OK);
    }
}