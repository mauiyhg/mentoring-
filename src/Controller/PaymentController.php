<?php

namespace App\Controller;

// src/Controller/PaymentController.php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PaymentController extends AbstractController
{
    #[Route('/process-payment', name: 'process_payment')]
    public function processPayment(): Response
    {
        // Step 1: Create Payment
        $token = $this->createPayment();

        // Step 2: Check Payment
        $paymentStatus = $this->checkPayment($token);

        if ($paymentStatus) {
            // Payment successful
            return $this->render('payment/success.html.twig');
        } else {
            // Payment failed
            return $this->render('payment/failure.html.twig');
        }
    }

    private function createPayment(): ?string
    {
        $httpClient = HttpClient::create();
        try {
            $response = $httpClient->request('POST', 'https://sandbox.paymee.tn/api/v1/payments/create', [
                'headers' => [
                    'Authorization' => 'Token ' . $_ENV['PAYMEE_API_TOKEN'],
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'vendor' => 1265,
                    'amount' => 45,
                    'note' => 'Commande #1324',
                ],
            ]);

            $data = $response->toArray();
            return $data['data']['token'] ?? null;
        } catch (TransportExceptionInterface $e) {
            // Handle exception
            return null;
        }
    }

    private function checkPayment(string $token): bool
    {
        $httpClient = HttpClient::create();
        try {
            $response = $httpClient->request('GET', 'https://sandbox.paymee.tn/api/v1/payments/' . $token . '/check', [
                'headers' => [
                    'Authorization' => 'Token ' . $_ENV['PAYMEE_API_TOKEN'],
                ],
            ]);

            $data = $response->toArray();
            return $data['data']['payment_status'] ?? false;
        } catch (TransportExceptionInterface $e) {
            // Handle exception
            return false;
        }
    }
}
