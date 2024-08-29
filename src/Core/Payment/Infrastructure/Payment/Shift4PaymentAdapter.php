<?php

namespace App\Core\Payment\Infrastructure\Payment;

use App\Core\Payment\Application\DTO\Response\PaymentResponse;
use App\Core\Payment\Application\Service\PaymentServiceInterface;
use App\Core\Payment\Infrastructure\Http\Exceptions\PaymentException;
use Shift4\Request\CardRequest;
use Shift4\Request\ChargeRequest;
use Shift4\Shift4Gateway;

class Shift4PaymentAdapter implements PaymentServiceInterface
{
    public function processPayment(array $paymentDetails): PaymentResponse
    {
        $gateway = new Shift4Gateway('sk_test_FQJcbkC9JCEVwYGNwTjT5vp6');

        try {
            $cardRequest = new CardRequest();
            $cardRequest->number($paymentDetails['cardNumber'])
                ->expMonth($paymentDetails['cardExpMonth'])
                ->expYear($paymentDetails['cardExpYear']);

            $request = new ChargeRequest();
            $request->amount(floatval($paymentDetails['amount']))
                ->currency($paymentDetails['currency'])
                ->card($cardRequest);

            $charge = $gateway->createCharge($request);

            return new PaymentResponse(
                transactionId: $charge->getId(),
                dateOfCreation: date("Y-m-d H:i:s", $charge->getCreated()),
                amount: $charge->getAmount(),
                currency: $charge->getCurrency(),
                cardBin: $charge->getCard()->getFirst6(),
            );
        } catch (\Throwable $e) {
            throw new PaymentException($e->getMessage());
        }
    }
}
