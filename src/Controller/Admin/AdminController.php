<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\ThemeRepository;


use App\Repository\VitrineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{

    #[Route('/', name: 'app_vitrine_index', methods: ['GET'])]
    public function index(VitrineRepository $vitrineRepository): Response
    {
        return $this->render('vitrine/index.html.twig', [
            'vitrines' => $vitrineRepository->findAll(),
        ]);
    }


    #[Route('/theme', name: 'app_new_theme', methods: ['GET', 'POST'])]
    public function newTheme(Request $request, ThemeRepository $themeRepository): Response
    {
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $themeRepository->save($theme, true);

            $this->addFlash(
                'success',
                'Nouveau thème enregistré avec succès !'
            );

            return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vitrine/newTheme.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }
}
