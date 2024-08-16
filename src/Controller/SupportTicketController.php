<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\SupportTicket;
use App\Form\SupportTicketType;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportTicketController extends AbstractController
{

    #[Route(path:"/support-client", name:"app_support_client")]
    public function supportClient(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new SupportTicket();
        $form = $this->createForm(SupportTicketType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
            $ticket->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($ticket);
            $entityManager->flush();

            $notification = new Notification();
            $notification->setMessage('Un nouveau ticket de support a été créé : ' . $ticket->getSubject());
            $notification->setSupportTicket($ticket);
            $notification->setCreatdAt(new \DateTimeImmutable());
            $entityManager->persist($notification);
            $entityManager->flush();

            $this->addFlash('success', 'Votre ticket de support a été soumis avec succès.');

            return $this->redirectToRoute('app_support_client');
        }
        return $this->render('support/client.html.twig',
        [
            'form' => $form->createView(),
        ]);
    }
}
