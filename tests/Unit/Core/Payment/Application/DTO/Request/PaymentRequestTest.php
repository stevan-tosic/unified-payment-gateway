<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Payment\Application\DTO\Request;

use App\Core\Payment\Application\DTO\Request\PaymentRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class PaymentRequestTest extends TestCase
{
    public function testPaymentRequestCanBeInstantiated()
    {
        $paymentRequest = new PaymentRequest();
        self::assertInstanceOf(PaymentRequest::class, $paymentRequest);
    }

    public function testSetRequest()
    {
        $requestData = [
            'amount' => 100.00,
            'currency' => 'EUR',
            'cardNumber' => '4111111111111111',
            'cardExpYear' => '2025',
            'cardExpMonth' => '12',
            'cardCvv' => '123'
        ];

        $request = new Request(
            attributes: ['service' => 'aci'],
            content: json_encode($requestData)
        );
        $paymentRequest = new PaymentRequest();
        $paymentRequest->setRequest($request);

        self::assertSame(100.00, $paymentRequest->getAmount());
        self::assertSame('EUR', $paymentRequest->getCurrency());
        self::assertSame('4111111111111111', $paymentRequest->getCardNumber());
        self::assertSame('2025', $paymentRequest->getCardExpYear());
        self::assertSame('12', $paymentRequest->getCardExpMonth());
        self::assertSame('123', $paymentRequest->getCardCvv());
        self::assertSame('aci', $paymentRequest->getService());
    }
}
