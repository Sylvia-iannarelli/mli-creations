<?php

namespace App\Controller;

use App\Entity\MainColor;
use App\Form\MainColorType;
use App\Repository\MainColorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mainColor")
 */
class MainColorController extends AbstractController
{
    /**
     * @Route("/", name="app_mainColor_index", methods={"GET"})
     */
    public function index(MainColorRepository $mainColorRepository): Response
    {
        return $this->render('mainColor/index.html.twig', [
            'mainColors' => $mainColorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_mainColor_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MainColorRepository $mainColorRepository): Response
    {
        $mainColor = new MainColor();
        $form = $this->createForm(MainColorType::class, $mainColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mainColorRepository->add($mainColor, true);

            return $this->redirectToRoute('app_mainColor_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mainColor/new.html.twig', [
            'mainColor' => $mainColor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_mainColor_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MainColor $mainColor, MainColorRepository $mainColorRepository): Response
    {
        $form = $this->createForm(MainColorType::class, $mainColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mainColorRepository->add($mainColor, true);

            return $this->redirectToRoute('app_mainColor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mainColor/edit.html.twig', [
            'mainColor' => $mainColor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_mainColor_delete", methods={"POST"})
     */
    public function delete(Request $request, MainColor $mainColor, MainColorRepository $mainColorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mainColor->getId(), $request->request->get('_token'))) {
            $mainColorRepository->remove($mainColor, true);
        }

        return $this->redirectToRoute('app_mainColor_index', [], Response::HTTP_SEE_OTHER);
    }
}
