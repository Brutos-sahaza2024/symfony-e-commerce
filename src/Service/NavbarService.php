<?php
// src/Service/NavbarService.php
namespace App\Service;

use App\Repository\ImageAcceuilRepository;
use App\Repository\LogoRepository;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Core\Number;

class NavbarService
{
    private $entityManager;
    private $yourEntityRepository;
    private $logo;
    private $notificationRepository;

    public function __construct(EntityManagerInterface $entityManager, ImageAcceuilRepository $yourEntityRepository, LogoRepository $logo, NotificationRepository $notificationRepository)
    {
        $this->entityManager = $entityManager;
        $this->yourEntityRepository = $yourEntityRepository;
        $this->logo = $logo;
        $this->notificationRepository = $notificationRepository;
    }

    public function getNavbarData()
    {
        return $this->yourEntityRepository->findAll();
    }

    public function getLogo(): ?string
    {
        $logo = $this->logo->findOneBy([]);
        return $logo ? $logo->getPath() : null;
    }

    public function getNotification(): ?int
    {
        return $this ->notificationRepository->count(['isRead' => null]);
    }
}
