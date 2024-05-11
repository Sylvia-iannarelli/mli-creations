<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/products", name="app_api_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        return $this->json($products, Response::HTTP_OK, [], ["groups" => "product_index"]);
    }
}
