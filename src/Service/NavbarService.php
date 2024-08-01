<?php
// src/Service/NavbarService.php
namespace App\Service;

use App\Repository\ImageAcceuilRepository;
use Doctrine\ORM\EntityManagerInterface;

class NavbarService
{
    private $entityManager;
    private $yourEntityRepository;

    public function __construct(EntityManagerInterface $entityManager, ImageAcceuilRepository $yourEntityRepository)
    {
        $this->entityManager = $entityManager;
        $this->yourEntityRepository = $yourEntityRepository;
    }

    public function getNavbarData()
    {
        return $this->yourEntityRepository->findAll();
    }
}