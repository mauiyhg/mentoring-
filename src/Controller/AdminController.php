<?php

// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/contact-messages", name="admin_contact_messages")
     */
    public function contactMessages(ContactRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll(); // Fetch messages from repository

        return $this->render('admin/index.html.twig', [
            'messages' => $messages,
        ]);
    }
}
