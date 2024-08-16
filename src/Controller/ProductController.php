<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_show')]
    public function show(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/buy', name: 'product_buy')]
    public function buy(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }
        

        return $this->render('product/buy.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/details', name: 'product_details')]
    public function details(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('product/details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/products/{categoryName}', name: 'products_by_category')]
    public function productsByCategory(
        string $categoryName, 
        ProductRepository $productRepository, 
        CategoryRepository $categoryRepository
    ): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        
        if (!$category) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas');
        }

        $products = $productRepository->findBy(['category' => $category]);

        return $this->render('product/category.html.twig', [
            'products' => $products,
            'category' => $categoryName
        ]);
    }

}

