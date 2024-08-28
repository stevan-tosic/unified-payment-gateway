<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Payment\Application\DTO\Response;

use App\Core\Payment\Application\Command\Core\Payment\Application\DTO\Response\PaymentResponse;
use PHPUnit\Framework\TestCase;

class PaymentResponseTest extends TestCase
{
    public function testPaymentResponseCanBeInstantiated()
    {
        $paymentResponse = new PaymentResponse(
            '12345',
            '2023-10-01',
            100.00,
            'EUR',
            '411111'
        );

        self::assertInstanceOf(PaymentResponse::class, $paymentResponse);
        self::assertSame('12345', $paymentResponse->transactionId);
        self::assertSame('2023-10-01', $paymentResponse->dateOfCreation);
        self::assertSame(100.00, $paymentResponse->amount);
        self::assertSame('EUR', $paymentResponse->currency);
        self::assertSame('411111', $paymentResponse->cardBin);
    }

    public function testPaymentResponseWithNullCardBin()
    {
        $paymentResponse = new PaymentResponse(
            '12345',
            '2023-10-01',
            100.00,
            'EUR',
            null
        );

        self::assertInstanceOf(PaymentResponse::class, $paymentResponse);
        self::assertSame('12345', $paymentResponse->transactionId);
        self::assertSame('2023-10-01', $paymentResponse->dateOfCreation);
        self::assertSame(100.00, $paymentResponse->amount);
        self::assertSame('EUR', $paymentResponse->currency);
        self::assertNull($paymentResponse->cardBin);
    }
}