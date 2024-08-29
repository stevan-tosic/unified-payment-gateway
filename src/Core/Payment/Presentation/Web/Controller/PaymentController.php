<?php

namespace App\Core\Payment\Presentation\Web\Controller;

use App\Core\Payment\Application\Command\ProcessPaymentCommand;
use App\Core\Payment\Application\DTO\Request\PaymentRequest;
use App\Core\Payment\Application\Handler\PaymentHandler;
use App\Core\Payment\Application\Service\PaymentContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

readonly class PaymentController
{
    public function __construct(
        public PaymentContext $paymentContext,
        public PaymentHandler $paymentHandler,
    ) {
    }

    public function __invoke(PaymentRequest $request): JsonResponse
    {
        try {
            $paymentDetails = [
                'amount' => $request->getAmount(),
                'currency' => $request->getCurrency(),
                'cardNumber' => $request->getCardNumber(),
                'cardExpYear' => $request->getCardExpYear(),
                'cardExpMonth' => $request->getCardExpMonth(),
                'cardCvv' => $request->getCardCvv(),
            ];

            $command = new ProcessPaymentCommand($request->getService(), $paymentDetails);
            $result = $this->paymentHandler->handle($command);

            return new JsonResponse($result, Response::HTTP_OK);
        } catch (Throwable $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
