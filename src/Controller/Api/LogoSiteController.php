<?php

namespace App\Controller\Api;

use App\Repository\LogoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LogoSiteController extends AbstractController
{
    #[Route('api/logo/site', name: 'app_logo_site')]
    public function index(LogoRepository $logoRepository, SerializerInterface $serializerInterface): JsonResponse
    {

            $logo = $logoRepository->findOneBy([]);

            $jsonResults = $serializerInterface->serialize($logo, 'json', ['groups' => 'logo:read']);

            return new JsonResponse($jsonResults, 200, [], true);
    }
}
