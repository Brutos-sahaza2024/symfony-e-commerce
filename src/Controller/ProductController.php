<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Rating;
use App\Form\CommentType;
use App\Form\RatingType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function details(ProductRepository $productRepository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setProduct($product);
            $comment->setUser($this->getUser());
            $comment->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('product_details', ['id' => $product->getId()]);
        }

        $rating = new Rating();
        $ratingForm = $this->createForm(RatingType::class, $rating);
        $ratingForm->handleRequest($request);

        if ($ratingForm->isSubmitted() && $ratingForm->isValid()) {
            $rating->setProduct($product);
            $rating->setUser($this->getUser());
            $rating->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($rating);
            $entityManager->flush();

            return $this->redirectToRoute('product_details', ['id' => $product->getId()]);
        }

        return $this->render('product/details.html.twig', [
            'product' => $product,
            'commentForm' => $commentForm->createView(),
            'ratingForm' => $ratingForm->createView(),
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

