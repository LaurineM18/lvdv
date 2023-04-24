<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_admin_contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        $messages = $contactRepository->findAll();
        return $this->render('contact/index.html.twig', [
            'messages' => $messages
        ]);
    }

    #[Route('/message/{id}', name: 'app_delete_message', methods: ['POST'])]
    public function deleteMessage(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $contactRepository->remove($contact, true);
        }

        return $this->redirectToRoute('app_admin_contact', [], Response::HTTP_SEE_OTHER);
    }
}
