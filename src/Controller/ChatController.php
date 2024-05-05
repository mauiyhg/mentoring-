<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Repository\MessageRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Chat;
use App\Form\ChatType;
use Symfony\Component\Form\FormError;

class ChatController extends AbstractController
{
 

#[Route('/chat/{id}', name: 'app_chat', methods: ['GET', 'POST'])]
public function index(Request $request, EntityManagerInterface $entityManager, $id): Response
{   $id = $request->get('id');
    $reciptions = $entityManager->getRepository(User::class)->find($id);
    $userRepository = $entityManager->getRepository(user::class);
    $users = $userRepository->findAll();
    // Vérifiez si l'utilisateur existe
    if (!$reciptions) {
        throw new NotFoundHttpException('Utilisateur non trouvé');
    }


    // Créer une nouvelle instance de l'entité Chat
    $chatMessage = new Chat();
    $form = $this->createForm(ChatType::class, $chatMessage);

    // Handle form submission
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
       

        // Enregistrer le message dans la base de données
        $entityManager->persist($chatMessage);
        $entityManager->flush();

        // Rediriger vers la page du chat ou effectuer une autre action
        return $this->redirectToRoute('app_chat', ['id' => $id]);
    }

    // Obtenez les messages du chat depuis la base de données
    $messageRepository = $entityManager->getRepository(Chat::class);
    $messages = $messageRepository->getMessagesSortedByDate();

    // Rendez le template 'chat/index.html.twig' avec les données nécessaires
    return $this->render('chat/index.html.twig', [
        'reciptions' => $reciptions,
        'messages' => $messages,
        'users' => $users,
       
        'form' => $form->createView(),
    ]);
}



#[Route('/seemore/{id}', name: 'seemore', methods: ['GET', 'POST'])]
public function seemore(Request $request, EntityManagerInterface $entityManager, $id): Response
{   $id = $request->get('id');
    $reciptions = $entityManager->getRepository(User::class)->find($id);
    $userRepository = $entityManager->getRepository(user::class);
    $users = $userRepository->findAll();
    // Vérifiez si l'utilisateur existe
    if (!$reciptions) {
        throw new NotFoundHttpException('Utilisateur non trouvé');
    }


    // Créer une nouvelle instance de l'entité Chat
    $chatMessage = new Chat();
    $form = $this->createForm(ChatType::class, $chatMessage);

    // Handle form submission
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
       

        // Enregistrer le message dans la base de données
        $entityManager->persist($chatMessage);
        $entityManager->flush();

        // Rediriger vers la page du chat ou effectuer une autre action
        return $this->redirectToRoute('app_chat', ['id' => $id]);
    }

    // Obtenez les messages du chat depuis la base de données
    $messageRepository = $entityManager->getRepository(Chat::class);
    $messages = $messageRepository->getMessagesSortedByDate();

    // Rendez le template 'chat/index.html.twig' avec les données nécessaires
    return $this->render('chat/seemore.html.twig', [
        'reciptions' => $reciptions,
        'messages' => $messages,
        'users' => $users,
       
        'form' => $form->createView(),
    ]);
}
}