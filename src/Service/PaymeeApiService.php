<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PaymeeApiService
{
    private $baseUrl = 'https://sandbox.paymee.tn/api/v1/payments/';
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function createPayment(int $vendor, int $amount, string $note): ?string
    {
        $client = HttpClient::create();
        try {
            $response = $client->request('POST', $this->baseUrl . 'create', [
                'headers' => [
                    'Authorization' => 'Token ' . $this->token,
                ],
                'json' => [
                    'vendor' => $vendor,
                    'amount' => $amount,
                    'note' => $note,
                ],
            ]);
            $data = $response->toArray();
            return $data['data']['token'] ?? null;
        } catch (TransportExceptionInterface $e) {
            // Handle exception
            return null;
        }
    }

    public function checkPayment(string $token): ?bool
    {
        $client = HttpClient::create();
        try {
            $response = $client->request('GET', $this->baseUrl . $token . '/check', [
                'headers' => [
                    'Authorization' => 'Token ' . $this->token,
                ],
            ]);
            $data = $response->toArray();
            return $data['data']['payment_status'] ?? null;
        } catch (TransportExceptionInterface $e) {
            // Handle exception
            return null;
        }
    }
}
