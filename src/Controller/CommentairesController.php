<?php

namespace App\Controller;


use App\Entity\Commentaires;
use App\Entity\Mentoroffers;
use App\Entity\User;

use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentairesController extends AbstractController
{
    #[Route('/commentaires/{id}', name: 'app_commentaires', methods: ['GET', 'POST'])]
public function index(Request $request, EntityManagerInterface $entityManager, CommentairesRepository $commentairesRepository): Response
{
    $id = $request->get('id');

    $mentor = $entityManager->getRepository(User::class)->find($id);
    $users = $entityManager->getRepository(User::class)->findAll();
    $commentaire = new Commentaires();
    $form = $this->createForm(CommentairesType::class, $commentaire);
    $form->handleRequest($request);
    $offers = $entityManager->getRepository(Mentoroffers::class)->findAll();

    $commentaires = $commentairesRepository->findBy(['user' => $mentor]);
        

        
        if ($mentor && in_array('MENTOR', $mentor->getRoles())) {
            $commentaire = new Commentaires();
            $commentaire->setUser($mentor); // Définir l'utilisateur mentor dans le commentaire

            $form = $this->createForm(CommentairesType::class, $commentaire);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($commentaire);
                $entityManager->flush();

                return $this->redirectToRoute('app_commentaires', ['id' => $id]);
            }

        return $this->render('commentaires/index.html.twig', [
            'form' => $form->createView(),
            'offers' => $offers,
            'mentor' => $mentor,
            'users' => $users,
            'commentaires' => $commentaires, // Passer les commentaires à la vue

        ]);
    }

    
}



    #[Route('/commentaire/{id}', name: 'commentaire_show', methods: ['GET', 'POST'])]
    public function showByUser(Request $request, CommentairesRepository $commentairesRepository, EntityManagerInterface $entityManager): Response
    {
        $id = $request->get('id');
        $mentor = $entityManager->getRepository(User::class)->find($id);
        
        $users = $entityManager->getRepository(user::class)->findAll();

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
        return $this->render('commentaires/show.html.twig', [
            'mentor' => $mentor,
            'userid' => $userid,
            'avgNotes' => $avgNotes,
            'userData' => $userData,
            'users' => $users,
        ]);
    }


    #[Route('/about/{id}', name: 'about' ,methods: ['GET', 'POST'])]
    public function about(Request $request,EntityManagerInterface $entityManager): Response
    {  
        $id = $request->get('id');
        $mentor = $entityManager->getRepository(User::class)->find($id);
        
        
         $users = $entityManager->getRepository(user::class)->findAll();
        return $this->render('about/about.html.twig', [
            'controller_name' => 'CommentairesController',
            'mentor' => $mentor,
            'users' => $users,
        ]);
    }
}

