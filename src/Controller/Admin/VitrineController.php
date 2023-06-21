<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Entity\Theme;
use App\Entity\Vitrine;
use App\Form\ThemeType;
use App\Form\VitrineType;
use App\Repository\ThemeRepository;


use App\Repository\VitrineRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            'vitrines' => $vitrineRepository->orderByDesc(),
        ]);
    }

    #[Route('/nouvelle-vitrine', name: 'app_vitrine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VitrineRepository $vitrineRepository): Response
    {
        $vitrine = new Vitrine();
        $form = $this->createForm(VitrineType::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('images')->getData();

            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );

                $img = new Image;
                $img->setTitle($fichier);
                $vitrine->addImage($img); 
            }
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

    #[Route('/{id}/modifier', name: 'app_vitrine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vitrine $vitrine, VitrineRepository $vitrineRepository): Response
    {
        $form = $this->createForm(VitrineType::class, $vitrine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('images')->getData()){
                $images = $form->get('images')->getData();

            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('upload_directory'),
                    $fichier
                );

                $img = new Image;
                $img->setTitle($fichier);
                $vitrine->addImage($img); 
            }
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
    public function delete(Request $request, Vitrine $vitrine, VitrineRepository $vitrineRepository, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vitrine->getId(), $request->request->get('_token'))) {
            $images = $vitrine->getImages();
            foreach($images as $image){
                $name = $image->getTitle();
                unlink($this->getParameter('upload_directory').'/'.$name );
                $em->remove($image);
                $em->flush();
            }
            $vitrineRepository->remove($vitrine, true);
        }

        return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
    }
}
