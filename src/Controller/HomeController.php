<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Contact;
use App\Entity\Mail;
use App\Entity\Vitrine;
use App\Form\ContactType;
use App\Form\MailType;
use App\Form\SearchType;
use App\Repository\ContactRepository;
use App\Repository\MailRepository;
use App\Repository\VitrineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MailRepository $mailRepository, Request $request): Response
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailRepository->save($mail, true);

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé !'
            );

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/vitrines', name: 'app_vitrines')]
    public function allVitrines(VitrineRepository $repository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $listeVitrines = $repository->findSearch($data);
        return $this->render('home/vitrines.html.twig', [
            'vitrines' => $listeVitrines,
            'form' => $form
        ]);
    }

    #[Route('/nouveautes', name: 'app_new_vitrines')]
    public function newVitrines(VitrineRepository $repository, Request $request): Response
    {
        $data = new SearchData();
        $data->new = true;
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $listeVitrines = $repository->findSearch($data);
        return $this->render('home/vitrines.html.twig', [
            'vitrines' => $listeVitrines,
            'form' => $form
        ]);
    }

    #[Route('/personnalisation', name: 'app_personalization_vitrines')]
    public function personalization(): Response
    {
        return $this->render('home/personalization.html.twig');
    }


    #[Route('/vitrine/{id}', name: 'app_show_vitrine')]
    public function showVitrine(Vitrine $vitrine): Response
    {
        return $this->render('home/showVitrine.html.twig', [
            'vitrine' => $vitrine
        ]);
    }



    #[Route('/expositions', name: 'app_expositions')]
    public function expo(MailRepository $mailRepository, Request $request): Response
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailRepository->save($mail, true);

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé !'
            );

            return $this->redirectToRoute('app_expositions', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/expo.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid()) {
            $contactRepository->save($contact, true);

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé !'
            );

            return $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/contact.html.twig', [
            'form' => $formContact
        ]);
    }

    #[Route('/faq', name: 'app_faq')]
    public function faq(): Response
    {
        return $this->render('home/faq.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_termsofUse')]
    public function termsOfUse(): Response
    {
        return $this->render('home/termsOfUse.html.twig');
    }

}
