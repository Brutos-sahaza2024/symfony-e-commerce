<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Entity\Rating;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RatingController extends AbstractController
{
    #[Route('/api/product/{id}/ratings', name: 'app_api_rating')]
    public function addRating(Product $product, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $rating = new Rating();
        $rating->setValue($data['value']);
        $rating->setProduct($product);
        $rating->setUser($this->getUser());
        $rating->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($rating);
        $entityManager->flush();

        $jsonRating = $serializer->serialize($rating, 'json', ['groups' => 'rating']);

        return new JsonResponse($jsonRating, 201, [], true);
    }
}
