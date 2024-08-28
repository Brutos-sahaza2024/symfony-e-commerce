<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{
    #[Route('api/product/{id}/comment', name: 'product_comment', methods: ['POST'])]
    public function addComment(ProductRepository $productRepository, int $id, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $product = $productRepository->find($id);

        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $comment = new Comment();
        $comment->setContent($data['content']);
        $comment->setProduct($product);
        $comment->setUser($this->getUser());
        $comment->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($comment);
        $entityManager->flush();

        $jsonComment = $serializer->serialize($comment, 'json', ['groups' => 'comment']);

        return new JsonResponse($jsonComment, 201, [], true);
    }

    #[Route('/comment/{id}/edit', name: 'comment_edit')]
    #[IsGranted('EDIT', subject: 'comment')]
    public function edit(Request $request, Comment $comment, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('product_details', ['id' => $comment->getProduct()->getId()]);
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
}
