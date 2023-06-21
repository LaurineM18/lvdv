<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use App\Entity\Contact;
use App\Entity\Vitrine;
use App\Data\SearchData;
use App\Form\SearchType;
use App\Form\ContactType;
use App\Repository\MailRepository;
use App\Repository\ContactRepository;
use App\Repository\VitrineRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MailRepository $mailRepository, Request $request, MailerInterface $mailer): Response
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && empty($form['other']->getData())) {
            $mailRepository->save($mail, true);

            $email = (new TemplatedEmail())
                ->from($mail->getMail())
                ->to('contact@lavitrinedevalerie.fr')
                ->htmlTemplate('emails/emailNewsletter.html.twig')
                ;

            try{
                $mailer->send($email);
                $this->addFlash(
                    'success',
                    'Votre adresse mail a bien été enregistrée merci !'
                );
            } catch (TransportExceptionInterface $e){
                $e;
            }


            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/vitrines/{new}', name: 'app_vitrines')]
    public function allVitrines(VitrineRepository $repository, Request $request, $new): Response
    {
        $numberArticles = 9;
        $data = new SearchData();
        if($new === 'nouveautes'){
            $data->new = true;
        }
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        $listeVitrines = $repository->findSearch($data, $numberArticles);
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
    public function showVitrine(Vitrine $vitrine, Request $request): Response
    {
        $previousUrl = $request->headers->get('referer');
        return $this->render('home/showVitrine.html.twig', [
            'vitrine' => $vitrine,
            'previousUrl' => $previousUrl
        ]);
    }



    #[Route('/expositions', name: 'app_expositions')]
    public function expo(MailRepository $mailRepository, Request $request, MailerInterface $mailer): Response
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && empty($form['other']->getData())) {
            $mailRepository->save($mail, true);

            $email = (new TemplatedEmail())
                ->from($mail->getMail())
                ->to('laurine.mencias@gmail.com')
                ->htmlTemplate('emails/emailNewsletter.html.twig')
                ;

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre adresse mail a bien été enregistrée !'
            );

            return $this->redirectToRoute('app_expositions', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/expo.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, ContactRepository $contactRepository, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);

        if ($formContact->isSubmitted() && $formContact->isValid() && empty($formContact['other']->getData())) {
            $contactRepository->save($contact, true);

            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('laurine.mencias@gmail.com')
                ->subject($contact->getSubject())
                ->htmlTemplate('emails/emailContact.html.twig')
                ->context([
                    'lastname' => $contact->getLastname(),
                    'message' => $contact->getMessage()
                ]);

            $mailer->send($email);

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
