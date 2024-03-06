<?php

namespace App\Controller;

use App\Entity\Material;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\MaterialRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="app_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository, MaterialRepository $materialRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $materials = $form['materials']->getData();

            foreach($materials as $material) {
                $product->addMaterial($material);
            };
            
            if ($photo = $form['photo']->getData()) {
                $filename = md5(uniqid()).'.'.$photo->guessExtension();
                $photo->move(
                     $this->getParameter('photo_dir'),
                     $filename
                );
                $product->setPicture($filename);
            }

            $productRepository->add($product, true);

            return $this->renderForm('product/show.html.twig', [
                'product' => $product,
                'form' => $form,
            ]);
            }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);
            
            if ($photo = $form['photo']->getData()) {

                $filename = $this->getParameter('photo_dir').'/'.$product->getPicture();
                $fileSystem = new Filesystem();
                $fileSystem->remove($filename);
                        
                $filename = md5(uniqid()).'.'.$photo->guessExtension();
                $photo->move(
                     $this->getParameter('photo_dir'),
                     $filename
                );
                $product->setPicture($filename);
            }

            $productRepository->add($product, true);

            return $this->renderForm('product/show.html.twig', [
                'product' => $product,
                'form' => $form,
            ]);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
                $filename = $product->getPicture();
                $fileSystem = new Filesystem();
                $fileSystem->remove($this->getParameter('photo_dir').'/'.$filename);
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
