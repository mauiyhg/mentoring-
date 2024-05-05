<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/graphe')]
class GrapheController extends AbstractController
{
    #[Route('/event/{id}', name: 'app_graphe', methods: ['GET'])]
    public function index(Event $event, ChartBuilderInterface $chartBuilder): Response
    {
        // Utilisez le constructeur de graphiques pour créer votre graphique
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        // Renvoyer la vue avec les données du graphique
        return $this->render('graphe/index.html.twig', [
            'eventId' => $event->getId(),
            'event' => $event,
            'chart' => $chart,
        ]);
    }
}