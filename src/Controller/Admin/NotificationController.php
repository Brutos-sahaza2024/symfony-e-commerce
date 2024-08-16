<?php

namespace App\Controller\Admin;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotificationController extends AbstractController
{
    #[Route('/admin/notification', name: 'app_admin_notification')]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $notifications = $notificationRepository->findAll();

        return $this->render('admin/notification/index.html.twig', [
            'notifications' => $notifications,
        ]);
    }
    #[Route("/notification/mark-as-read/{id}", name: "notification_mark_as_read")]
    public function markAsRead(Notification $notification, EntityManagerInterface $entityManager): Response
    {
        $notification->setRead(true);
        $entityManager->persist($notification);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_notification');
    }
}
