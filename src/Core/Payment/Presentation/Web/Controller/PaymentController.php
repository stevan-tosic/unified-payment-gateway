<?php

namespace App\Core\Payment\Presentation\Web\Controller;

use App\Core\Payment\Application\Command\ProcessPaymentCommand;
use App\Core\Payment\Application\Handler\PaymentHandler;
use App\Core\Payment\Application\Service\PaymentContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController
{
    public function __construct(
        readonly PaymentContext $paymentContext,
        readonly PaymentHandler $paymentHandler,
    ) {
    }

    public function __invoke(Request $request, string $service): JsonResponse
    {
        $paymentDetails = [
            'cardNumber' => '4111111111111111',
            'paymentBrand' => 'VISA'
        ];

        $command = new ProcessPaymentCommand(100.00, 'EUR', $paymentDetails, $service);
        $result = $this->paymentHandler->handle($command);

        return new JsonResponse($result);
    }
}