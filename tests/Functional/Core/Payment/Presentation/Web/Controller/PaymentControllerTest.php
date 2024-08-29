<?php

declare(strict_types=1);

namespace App\Tests\Functional\Core\Payment\Presentation\Web\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class PaymentControllerTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();
    }

    /**
     * @dataProvider serviceDataProvider
     */
    public function testPaymentEndpoint($serviceName)
    {
        $this->client->request(
            method: Request::METHOD_POST,
            uri: '/process/' . $serviceName,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'amount' => 100.00,
                'currency' => 'EUR',
                'cardNumber' => '4111111111111111',
                'cardExpYear' => '2025',
                'cardExpMonth' => '12',
                'cardCvv' => '123'
            ])
        );

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        self::assertSame(200, $response->getStatusCode());
        self::assertArrayHasKey('transactionId', $responseData);
        self::assertArrayHasKey('dateOfCreation', $responseData);
        self::assertSame(100, $responseData['amount']);
        self::assertSame('EUR', $responseData['currency']);
        self::assertSame('411111', $responseData['cardBin']);
    }

    public function testPaymentEndpointFails()
    {
        $this->client->request(
            method: Request::METHOD_POST,
            uri: '/process/non-existing-service',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'amount' => 100.00,
                'currency' => 'EUR',
                'cardNumber' => '4111111111111111',
                'cardExpYear' => '2025',
                'cardExpMonth' => '12',
                'cardCvv' => '123'
            ])
        );

        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent(), true);

        self::assertSame(400, $response->getStatusCode());
        self::assertSame('Unsupported service selected.', $responseData);
    }

    private function serviceDataProvider(): array
    {
        return [
            [
                'shift4',
            ],
            [
                'aci',
            ],
        ];
    }
}
