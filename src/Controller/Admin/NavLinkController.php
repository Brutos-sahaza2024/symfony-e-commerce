<?php

namespace App\Controller\Admin;

use App\Entity\NavLink;
use App\Form\NavLinkType;
use App\Repository\NavLinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/navlink')]
class NavLinkController extends AbstractController
{
    #[Route('/', name: 'app_nav_link_index', methods: ['GET'])]
    public function index(NavLinkRepository $productNavlinkRepository): Response
    {
        return $this->render('admin/nav_link/index.html.twig', [
            'nav_links' => $productNavlinkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nav_link_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $navLink = new NavLink();
        $form = $this->createForm(NavLinkType::class, $navLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($navLink);
            $entityManager->flush();

            return $this->redirectToRoute('app_nav_link_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/nav_link/new.html.twig', [
            'nav_link' => $navLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nav_link_show', methods: ['GET'])]
    public function show(NavLink $navLink): Response
    {
        return $this->render('admin/nav_link/show.html.twig', [
            'nav_link' => $navLink,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nav_link_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NavLink $navLink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NavLinkType::class, $navLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nav_link_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/nav_link/edit.html.twig', [
            'nav_link' => $navLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nav_link_delete', methods: ['POST'])]
    public function delete(Request $request, NavLink $navLink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$navLink->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($navLink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nav_link_index', [], Response::HTTP_SEE_OTHER);
    }
}
