<?php

namespace App\Controller;

use App\Entity\Activty;
use App\Form\ActivtyType;
use App\Repository\ActivtyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/activty')]
class ActivtyController extends AbstractController
{
    #[Route('', name: 'app_activty_index', methods: ['GET'])]
    public function index(ActivtyRepository $activtyRepository): Response
    {
        return $this->render('activty/index.html.twig', [
            'activties' => $activtyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_activty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activty = new Activty();
        $form = $this->createForm(ActivtyType::class, $activty);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFileName')->getData();
    
            // Generate a unique name for the file
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
    
            // Move the file to the directory where images are stored
            $imageFile->move(
                $this->getParameter('kernel.project_dir') . '/public/uploads/images',
                $newFilename
            );
    
            // Set the image file name to the entity
            $activty->setImageFileName($newFilename);
    
            // Persist the entity with the image filename
            $entityManager->persist($activty);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_activty_new', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('activty/new.html.twig', [
            'activty' => $activty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activty_show', methods: ['GET'])]
    public function show(Activty $activty): Response
    {
        return $this->render('activty/show.html.twig', [
            'activty' => $activty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_activty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activty $activty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivtyType::class, $activty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activty/edit.html.twig', [
            'activty' => $activty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_activty_delete', methods: ['POST'])]
    public function delete(Request $request, Activty $activty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activty->getId(), $request->request->get('_token'))) {
            $entityManager->remove($activty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activty_index', [], Response::HTTP_SEE_OTHER);
    }
}
