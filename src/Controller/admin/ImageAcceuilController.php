<?php

namespace App\Controller\admin;

use App\Entity\ImageAcceuil;
use App\Form\ImageAcceuilType;
use App\Repository\ImageAcceuilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/imageacceuil')]
class ImageAcceuilController extends AbstractController
{
    #[Route('/', name: 'app_image_acceuil_index', methods: ['GET'])]
    public function index(ImageAcceuilRepository $imageAcceuilRepository): Response
    {
        return $this->render('admin/image_acceuil/index.html.twig', [
            'image_acceuils' => $imageAcceuilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_image_acceuil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $imageAcceuil = new ImageAcceuil();
        $form = $this->createForm(ImageAcceuilType::class, $imageAcceuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($imageAcceuil);
            $entityManager->flush();

            return $this->redirectToRoute('app_image_acceuil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/image_acceuil/new.html.twig', [
            'image_acceuil' => $imageAcceuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_acceuil_show', methods: ['GET'])]
    public function show(ImageAcceuil $imageAcceuil): Response
    {
        return $this->render('admin/image_acceuil/show.html.twig', [
            'image_acceuil' => $imageAcceuil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_image_acceuil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImageAcceuil $imageAcceuil, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImageAcceuilType::class, $imageAcceuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_image_acceuil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/image_acceuil/edit.html.twig', [
            'image_acceuil' => $imageAcceuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_image_acceuil_delete', methods: ['POST'])]
    public function delete(Request $request, ImageAcceuil $imageAcceuil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imageAcceuil->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($imageAcceuil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_image_acceuil_index', [], Response::HTTP_SEE_OTHER);
    }
}
