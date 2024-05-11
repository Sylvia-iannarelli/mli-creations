<?php

namespace App\Controller\Api;

use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MaterialController extends AbstractController
{
    /**
     * @Route("/api/materials", name="app_api_material_getMaterials", methods={"GET"})
     */
    public function getMaterials(MaterialRepository $materialRepository): JsonResponse
    {
        $materials = $materialRepository->findAll();

        return $this->json($materials, Response::HTTP_OK, [], ["groups" => "material_index"]);
    }
}
