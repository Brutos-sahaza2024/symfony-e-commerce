<?php

namespace App\Controller\Admin;


use App\Entity\Logo;
use App\Form\LogoType;
use App\Repository\LogoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Psr\Log\LoggerInterface;

class LogoController extends AbstractController
{
    #[Route('/admin/logo', name: 'admin_logo')]
    public function edit(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, LogoRepository $logoRepository, LoggerInterface $logger): Response
    {
        $logo = $logoRepository->findOneBy([]) ?: new Logo();

        $form = $this->createForm(LogoType::class, $logo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('path')->getData();
            
            if ($logoFile) {
                $existingFile = $logo->getPath();
                if ($existingFile) {
                    $existingFilePath = $this->getParameter('logos_directory') . '/' . $existingFile;
                    if (file_exists($existingFilePath)) {
                        unlink($existingFilePath);
                        $logger->info('Existing file deleted successfully.', ['filename' => $existingFile]);
                    } else {
                        $logger->warning('Existing file not found for deletion.', ['filename' => $existingFile]);
                    }
                }

                $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logoFile->guessExtension();

                try {
                    $logoFile->move(
                        $this->getParameter('logos_directory'),
                        $newFilename
                    );
                    $logger->info('File uploaded successfully.', ['filename' => $newFilename]);
                } catch (FileException $e) {
                    $logger->error('Failed to upload file.', ['exception' => $e]);
                    $this->addFlash('error', 'Failed to upload file: ' . $e->getMessage());
                }

                $logo->setPath($newFilename);
            }

            $em->persist($logo);
            $em->flush();

            $this->addFlash('success', 'Logo updated successfully!');
            return $this->redirectToRoute('admin_logo');
        }

        return $this->render('admin/logo/edit.html.twig', [
            'form' => $form->createView(),
            'logo' => $logo, 
        ]);
    }
}
