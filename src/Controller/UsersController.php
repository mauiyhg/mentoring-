<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; 
use Symfony\Component\HttpFoundation\Request;
class UsersController extends AbstractController
{
    private $entityManager; 

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/users', name: 'app_users')]
    public function allUsers(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'users' => $users,
        ]);
    }
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, user $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
    }
      
    #[Route('/validate-user/{id}', name:'validate_user')]
    
    public function validateUser($id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Supposez que vous ayez une méthode setValidated() dans votre entité User
        $user->setValidated(true);
        $this->entityManager->flush();

        $this->addFlash('success', 'User validated successfully.');

        return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
    }
}
