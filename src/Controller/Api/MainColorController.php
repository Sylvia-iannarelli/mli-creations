<?php

namespace App\Controller\Api;

use App\Repository\MainColorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainColorController extends AbstractController
{
    /**
     * @Route("/api/maincolors", name="app_api_maincolor_index", methods={"GET"})
     */
    public function index(MainColorRepository $mainColorRepository): JsonResponse
    {
        $mainColors = $mainColorRepository->findAll();

        return $this->json($mainColors, Response::HTTP_OK, [], ["groups" => "maincolor_index"]);
    }
}
