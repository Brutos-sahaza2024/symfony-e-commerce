<?php

namespace App\Controller\Admin;

use App\Repository\SupportTicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SupportTicketController extends AbstractController
{
    #[Route('/admin/support-tickets', name: 'app_admin_support')]
    public function index(SupportTicketRepository $supportTicketRepository): Response
    {
        $tickets = $supportTicketRepository->findAll();

        return $this->render('admin/support/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
}
