<?php

// src/Controller/MentorshipController.php

namespace App\Controller;

use App\Entity\DemandeMentorat;
use App\Entity\Mentoroffers;
use App\Entity\User;
use App\Form\DemandeMentoratType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DemandeMentoratController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/Demande/{id}', name:'Demande')]
    public function DemandeMentorat(Request $request ,$id): Response
    {

       
        $offers = $this->entityManager->getRepository(Mentoroffers::class)->find($id);
        $users = $this->entityManager->getRepository(User::class)->findAll();
        $offerMentor = $this->entityManager->getRepository(Mentoroffers::class)->findAll();
        $DemandeMentorat = new DemandeMentorat();
        $form = $this->createForm(DemandeMentoratType::class, $DemandeMentorat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Sauvegardez la demande de mentorat dans la base de données
            $this->entityManager->persist($DemandeMentorat);
            $this->entityManager->flush();

            // Redirigez l'utilisateur ou affichez un message de confirmation
            return $this->redirectToRoute('app_suite_web');
        }

        return $this->render('demande_mentorat/index.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
            'offers' => $offers,
            'offerMentor' => $offerMentor,
        ]);
    }
    #[Route('/aproveListe', name: 'aproveListe')]
    public function allUsers(): Response
    {
        $demandes = $this->entityManager->getRepository(DemandeMentorat::class)->findAll();
        $offers = $this->entityManager->getRepository(Mentoroffers::class)->findAll();
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $this->render('demande_mentorat/show.html.twig', [
            'controller_name' => 'demandementoratController',
            'users' => $users,
            'offers' => $offers,
            'demandes' => $demandes,
        ]);
    }
    #[Route('/aprove/{id}', name:'aprove')]
    
    public function aprove($id): Response
    {
        $user = $this->entityManager->getRepository(DemandeMentorat::class)->find($id);
        if (!$user) {
            throw $this->createNotFoundException('Mentee not found');
        }

        // Supposez que vous ayez une méthode setValidated() dans votre entité User
        $user->setAproved(true);
        $this->entityManager->flush();

        $this->addFlash('success', 'Request approved successfully.');

        return $this->redirectToRoute('aproveListe', [], Response::HTTP_SEE_OTHER);
    }
}
