<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Commentaires;
use App\Repository\CommentairesRepository;


use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Chat;
use App\Entity\Activty;
use App\Entity\User;
use App\Entity\Formation;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuiteWebController extends AbstractController
{
    #[Route('/suiteWeb', name: 'app_suite_web')]
    public function index(Request $request, CommentairesRepository $commentairesRepository, EntityManagerInterface $entityManager): Response

    
    {
       
        $messageRepository = $entityManager->getRepository(Chat::class);
        $messages = $messageRepository->getMessagesSortedByDate();

        

        $avg_note = $commentairesRepository->findByAverageRoundedNoteByUser();
    
        // Préparez un tableau pour stocker les données dans un format compatible avec JSON
        $userData = [];
        foreach ($avg_note as $avgNote) {
            $userData[] = [
                'user_id' => $avgNote['user_id'],
                'avg_note' => $avgNote['avg_note']
            ];
        }
        $userid='user_id';
        $avgNotes='avg_note';
        // Récupérer le compteur de visites de la session
        $session = $request->getSession();
        $visitCount = $session->get('suite_web_visits', 0);
        // Incrémenter le compteur de visites
        $visitCount++;
        // Mettre à jour le compteur de visites dans la session
        $session->set('suite_web_visits', $visitCount);

        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        $events = [];
        $commentaires = []; // Initialisez la variable $events

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entity = new Contact();
            $entity->setName($formData['name']);
            $entity->setEmail($formData['email']);
            $entity->setSubject($formData['subject']);
            $entity->setMessage($formData['message']);

            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('success', 'Your message has been sent and saved to the database. Thank you!');
        }

        // Récupérer les événements de la base de données
        $events = $entityManager->getRepository(Event::class)->findAll();
        $commentaires = $entityManager->getRepository(Commentaires::class)->findAll();
        


        $activties = $entityManager->getRepository(Activty::class)->findAll();
        $users = $entityManager->getRepository(User::class)->findAll();
        $formation = $entityManager->getRepository(Formation::class)->findAll();
        return $this->render('suite_web/index.html.twig', [
            'form' => $form->createView(),
            'events' => $events,
            'commentaires' => $commentaires,
            'activties' => $activties,
            'users' => $users,
            'visitCount' => $visitCount,
            'userid' => $userid,
            'avgNotes' => $avgNotes,
            'userData' => $userData,
             'messages' => $messages,
            'formation' => $formation,
     
        ]);
    }
   
}