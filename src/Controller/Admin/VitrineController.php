<?php

namespace App\Controller\Admin;

use App\Entity\Vitrine;
use App\Form\VitrineType;
use App\Services\ImageService;
use App\Repository\VitrineRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/vitrine')]
class VitrineController extends AbstractController
{

    #[Route('/', name: 'app_vitrine_index', methods: ['GET'])]
    public function index(VitrineRepository $vitrineRepository): Response
    {
        return $this->render('vitrine/index.html.twig', [
            'vitrines' => $vitrineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vitrine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VitrineRepository $vitrineRepository, ImageService $imgService): Response
    {
        $vitrine = new Vitrine();
        $form = $this->createForm(VitrineType::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['Image']->getData();
            
            $imgService->moveImage($file,$vitrine);
            $vitrineRepository->save($vitrine, true);

            $this->addFlash(
                'success',
                'Nouvelle vitrine enregistrée avec succès !'
            );

            return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine/new.html.twig', [
            'vitrine' => $vitrine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vitrine_show', methods: ['GET'])]
    public function show(Vitrine $vitrine): Response
    {
        return $this->render('vitrine/show.html.twig', [
            'vitrine' => $vitrine,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vitrine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vitrine $vitrine, VitrineRepository $vitrineRepository, ImageService $imgService): Response
    {
        $form = $this->createForm(VitrineType::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form["Image"]->getData()){
                $file = $form["Image"]->getData();
                $imgService->updateImage($file , $vitrine );
            }

            $vitrineRepository->save($vitrine, true);

            return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine/edit.html.twig', [
            'vitrine' => $vitrine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vitrine_delete', methods: ['POST'])]
    public function delete(Request $request, Vitrine $vitrine, VitrineRepository $vitrineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vitrine->getId(), $request->request->get('_token'))) {
            $vitrineRepository->remove($vitrine, true);
        }

        return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
    }
}
