<?php

namespace App\Core\Payment\Application\Service;

use App\Core\Payment\Application\DTO\Response\PaymentResponse;

interface PaymentServiceInterface
{
    /**
     * Process a payment transaction.
     *
     * @param array $paymentDetails Additional payment details specific to the payment method.
     * @return PaymentResponse Returns an object with the transaction status and details.
     */
    public function processPayment(array $paymentDetails): PaymentResponse;
}
