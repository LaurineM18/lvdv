<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_admin_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig');
    }
}
