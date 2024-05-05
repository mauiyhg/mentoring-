<?php

namespace App\Controller;

use Stripe\StripeClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Event;


class HomeController extends AbstractController
{
    private $manager;
    private $gateway;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->gateway = new StripeClient($_ENV['STRIPE_SECRETKEY']);
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(Request $request): Response
    {
        // Récupérer l'ID de l'événement depuis la requête
        $eventId = $request->query->get('id');

        // Si l'ID est fourni dans l'URL, récupérer uniquement cet événement
        if ($eventId) {
            $event = $this->manager->getRepository(Event::class)->find($eventId);
            // Vérifiez si un événement correspondant à cet ID a été trouvé
            if (!$event) {
                throw $this->createNotFoundException('Event not found');
            }
            // Retournez uniquement cet événement dans la vue
            return $this->render('cart/cart.html.twig', [
                'events' => [$event],
            ]);
        }

        // Si aucun ID n'est fourni dans l'URL, récupérer tous les événements
        $events = $this->manager->getRepository(Event::class)->findAll();

        return $this->render('cart/cart.html.twig', [
            'events' => $events,
        ]);
    }


    #[Route('/checkout', name: 'app_checkout', methods:"POST")]
    public function checkout(Request $request): Response
    {
        $amount=$request->request->get('amount');
        

        $quantity=$request->request->get('quantity');

        $amount *= 100;
        //créer le checkout

        $checkout=$this->gateway->checkout->sessions->create(
            [
                  'line_items'=>[[
                      'price_data'=>[
                        'currency'=>$_ENV['STRIPE_CURRENCY'],
                        'product_data'=>[
                            'name'=>'Nike',
                        ],

                        'unit_amount'=>intval($amount),

                    ],
                    'quantity'=>$quantity
                  ]],

                  'mode'=>'payment',
                  'success_url'=>'https://127.0.0.1:8001/success?id_sessions={CHECKOUT_SESSION_ID}',
                  'cancel_url'=>'https://127.0.0.1:8001/cancel?id_sessions={CHECKOUT_SESSION_ID}'
            ]);

            return $this->redirect($checkout->url);




    }


    #[Route('/success', name: 'app_success')]
    public function success(Request $request): Response
    {
        $id_sessions=$request->query->get('id_sessions');

        
        //Récupère le customer via l'id de la  session
        $customer=$this->gateway->checkout->sessions->retrieve(
            $id_sessions,
            []
        );

        //Récupérer les informations du customer et de la transaction

        $name=$customer["customer_details"]["name"];

        $email=$customer["customer_details"]["email"];

        $payment_status=$customer["payment_status"];

        $amount=$customer['amount_total'];

       

        //Stocker au niveau de la base de données



        //Email au customer




        //Message de succès


        return $this->render('success/success.html.twig',[
            'name'=>$name
        ]);

    }


    #[Route('/cancel', name: 'app_cancel')]
    public function cancel(Request $request): Response
    {
      
        return $this->render('suite_web/index.html.twig');
    }

}
