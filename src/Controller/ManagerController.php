<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Entity\Event;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ManagerController extends AbstractController
{
    /**
     * @Route("/manager",name="manager")
     */
    
    public function index(EventRepository $eventRepository, UserRepository $userRepository, SessionInterface $session, EntityManagerInterface $entityManager): Response

{


    
    $mois = $userRepository->findAll();
    $users = $userRepository->findAll();
    $userLines = $userRepository->findAll();
    $moisEvent = $eventRepository->findAll();
    $events = $eventRepository->findAll();





    $visitCount = $session->get('suite_web_visits', 0);
    $moisEvent = $eventRepository->countMoisByDate();

    $users = $userRepository->countByDate();
    $userLines = $userRepository->countByDateLine();
    $events = $eventRepository->countByColor();
    $mois = $userRepository->countByDateMonth();
   


    $totalMoisEvent = 0;
    $moisEventCount =[];
    $datesMoisEvent = [];



    $totalMois = 0;
    $moisCount =[];
    $datesMois = [];


    $totalUserLine = 0;
    $userLineCount =[];
    $usersCount = [];
    
    

    
    $totalUsers = 0;
    $eventCount = [];
    $totalEvents = 0;
    $datesLine = [];
    $dates = [];
    $colors = [];


    foreach ($moisEvent as $mo) {
       
        $datesMoisEvent[] = $mo['moisEvent'];
        $moisEventCount[] = $mo['count'];
       
    
}


    foreach ($mois as $months) {
       
        $datesMois[] = $months['mois'];
        $moisCount[] = $months['count'];
       
    
}

    foreach ($userLines as $usLine) {
       
            $datesLine[] = $usLine['userLine'];
            $userLineCount[] = $usLine['count'];
           
        
    }
    
    

    foreach ($users as $user) {
        $dates[] = $user['dateUser'];
        $usersCount[] = $user['count'];
        $totalUsers += $user['count'];
    }

    foreach ($events as $event) {
        $colors[] = $event['colorEvent']; // Assurez-vous d'utiliser la bonne clé
        $eventCount[] = $event['count'];
        $totalEvents += $event['count'];
    }

    $dates[] = 'Total';
    $datesLine[] = 'Total';
    
   
    $userMois[] = $totalMois; 
    $usersCount[] = $totalUsers;
    $userLineCount[] = $totalUserLine;
    $moisEventCount[] = $moisEventCount;
    $events = $entityManager->getRepository(Event::class)->findAll();

    return $this->render('manager/index.html.twig', [
        'visitCount' => $visitCount,
        'dates' => json_encode($dates),
        'colors' => json_encode($colors), // Utilisation de la variable correcte
        'usersCount' => json_encode($usersCount),
        'eventCount' => json_encode($eventCount), // Utilisation de la variable correcte
        'totalUsers' => json_encode($totalUsers),
        'userLineCount' => json_encode($userLineCount),
        'datesLine' => json_encode($datesLine),
        'userMois' => json_encode($userMois),
        'datesMois' => json_encode($datesMois),
        'moisEventCount' => json_encode($moisEventCount),
        'datesMoisEvent' => json_encode($datesMois),
        'events' => $events

]);
}

}