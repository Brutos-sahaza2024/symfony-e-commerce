<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    #[Route("/", name: "api_products_list", methods: ["GET"])]
    public function list(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $productRepository->findAll();
        $jsonProducts = $serializer->serialize($products, 'json', ['groups' => 'product:read']);

        return new JsonResponse($jsonProducts, 200, [], true);
    }


    #[Route("/search", name: "api_products_search", methods: ["GET"])]
    public function search(Request $request, ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $query = $request->query->get('query');

        if (!$query) {
            return new JsonResponse(['error' => 'Query parameter is required'], 400);
        }

        $results = $productRepository->searchByName($query);
        $jsonResults = $serializer->serialize($results, 'json', ['groups' => 'product:read']);

        return new JsonResponse($jsonResults, 200, [], true);
    }


    #[Route("/{id}", name: "api_products_show", methods: ["GET"])]
    public function show(int $id, ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $jsonProduct = $serializer->serialize($product, 'json', ['groups' => 'product:read']);

        return new JsonResponse($jsonProduct, 200, [], true);
    }
}
