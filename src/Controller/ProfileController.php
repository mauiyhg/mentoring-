<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/profile/edit", name="profile_edit")
     */
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserProfileFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Persist changes to the database
            $this->entityManager->flush();

            $this->addFlash('success', 'Profile updated successfully.');

            if (in_array('MANAGER', $user->getRoles())) {
                
                return $this->redirectToRoute('manager');
            } elseif (in_array('MENTOR', $user->getRoles())) {

                return $this->redirectToRoute('app_mentor');
            } else {
    
                return $this->redirectToRoute('app_suite_web');
            }
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}