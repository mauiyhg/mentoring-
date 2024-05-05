<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chat;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
class MentorController extends AbstractController
{
    #[Route('/mentor', name: 'app_mentor')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
      
        $messageRepository = $entityManager->getRepository(Chat::class);
        $messages = $messageRepository->getMessagesSortedByDate();
        $users = $entityManager->getRepository(User::class)->findAll();
       
        
        return $this->render('mentor/index.html.twig', [
            'controller_name' => 'MentorController',
            'users' => $users,
            'messages' => $messages,
        ]);
    }
}
