<?php

namespace App\Controller\Admin;

use App\Entity\Format;
use App\Entity\Theme;
use App\Form\FormatType;
use App\Form\ThemeType;
use App\Repository\FormatRepository;
use App\Repository\ThemeRepository;


use App\Repository\VitrineRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{

    #[Route('/', name: 'app_dashboard_index', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/themes', name: 'app_themes', methods: ['GET'])]
    public function themes(ThemeRepository $themeRepository): Response
    {
        $themes = $themeRepository->findAll();

        return $this->render('dashboard/allThemes.html.twig', [
            'themes' => $themes
        ]);
    }


    #[Route('/nouveau-theme', name: 'app_new_theme', methods: ['GET', 'POST'])]
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

        return $this->render('dashboard/newTheme.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[Route('/theme/{id}', name: 'app_delete_theme', methods: ['POST'])]
    public function deleteTheme(Request $request, Theme $theme, ThemeRepository $themeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$theme->getId(), $request->request->get('_token'))) {
            $themeRepository->remove($theme, true);
        }

        return $this->redirectToRoute('app_themes', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/formats', name: 'app_formats', methods: ['GET'])]
    public function formats(FormatRepository $formatRepository): Response
    {
        $formats = $formatRepository->findAll();

        return $this->render('dashboard/allFormats.html.twig', [
            'formats' => $formats
        ]);
    }

    #[Route('/nouveau-format', name: 'app_new_format', methods: ['GET', 'POST'])]
    public function newFormat(Request $request, FormatRepository $formatRepository): Response
    {
        $format = new Format();
        $form = $this->createForm(FormatType::class, $format);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formatRepository->save($format, true);

            $this->addFlash(
                'success',
                'Nouveau format enregistré avec succès !'
            );

            return $this->redirectToRoute('app_vitrine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/newFormat.html.twig', [
            'format' => $format,
            'form' => $form,
        ]);
    }

    #[Route('/format/{id}', name: 'app_delete_format', methods: ['POST'])]
    public function deleteFormat(Request $request, Format $format, FormatRepository $formatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$format->getId(), $request->request->get('_token'))) {
            $formatRepository->remove($format, true);
        }

        return $this->redirectToRoute('app_formats', [], Response::HTTP_SEE_OTHER);
    }
}
