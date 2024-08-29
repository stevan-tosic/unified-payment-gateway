<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Payment\Presentation\Web\Controller;

use App\Core\Payment\Application\DTO\Request\PaymentRequest;
use App\Core\Payment\Application\DTO\Response\PaymentResponse;
use App\Core\Payment\Application\Handler\PaymentHandler;
use App\Core\Payment\Application\Service\PaymentContext;
use App\Core\Payment\Presentation\Web\Controller\PaymentController;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Core\Payment\Presentation\Web\Controller\PaymentController
 */
class PaymentControllerTest extends TestCase
{
    private PaymentContext&MockObject $paymentContextMock;
    private PaymentHandler&MockObject $paymentHandlerMock;
    private PaymentRequest&MockObject $paymentRequestMock;
    protected PaymentController $paymentController;

    public function setUp(): void
    {
        $this->paymentContextMock = $this->createMock(PaymentContext::class);
        $this->paymentHandlerMock = $this->createMock(PaymentHandler::class);
        $this->paymentRequestMock = $this->createMock(PaymentRequest::class);

        $this->paymentController = new PaymentController(
            $this->paymentContextMock,
            $this->paymentHandlerMock
        );
    }

    public function testInvoke()
    {
        $this->paymentRequestMock
            ->expects($this->once())
            ->method('getAmount')
            ->willReturn(100.00);

        $this->paymentRequestMock
            ->expects($this->once())
            ->method('getCurrency')
            ->willReturn('EUR');

        $this->paymentRequestMock
            ->expects($this->once())
            ->method('getCardNumber')
            ->willReturn('4111111111111111');

        $this->paymentRequestMock
            ->expects($this->once())
            ->method('getCardExpYear')
            ->willReturn('2025');

        $this->paymentRequestMock
            ->expects($this->once())
            ->method('getCardExpMonth')
            ->willReturn('12');

        $this->paymentRequestMock
            ->expects($this->once())
            ->method('getCardCvv')
            ->willReturn('123');

        $this->paymentRequestMock
            ->expects($this->once())
            ->method('getService')
            ->willReturn('aci');

        $this->paymentHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->willReturn(
                new PaymentResponse(
                    '12345',
                    '2023-10-01',
                    100.00,
                    'EUR',
                    '411111'
                )
            );

        $response = $this->paymentController->__invoke($this->paymentRequestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertSame(
            [
                'transactionId' => '12345',
                'dateOfCreation' => '2023-10-01',
                'amount' => 100,
                'currency' => 'EUR',
                'cardBin' => '411111'
            ],
            json_decode($response->getContent(), true)
        );
    }
}
