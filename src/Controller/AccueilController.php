<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ProductRepository $productRepository): Response
    {
        $featuredProducts = $productRepository->findBy(['isFeatured' => true]);
        $newArrivals = $productRepository->findBy(['isNewArrival' => true]);
        
        $currentDate = new \DateTimeImmutable();
        $promotions = $productRepository->createQueryBuilder('p')
            ->where('p.isOnPromotion = :isOnPromotion')
            ->andWhere('p.promotionStartDate <= :currentDate')
            ->andWhere('p.promotionEndDate >= :currentDate')
            ->setParameter('isOnPromotion', true)
            ->setParameter('currentDate', $currentDate)
            ->getQuery()
            ->getResult();

        return $this->render('accueil/index.html.twig', [
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $newArrivals,
            'promotions' => $promotions,
        ]);
    }
}
