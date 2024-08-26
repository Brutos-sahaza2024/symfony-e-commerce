<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/product/{id}/comment', name: 'product_comment', methods: ['POST'])]
    public function addComment(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        return $this->render('base.html.twig',[]);
    }
}
