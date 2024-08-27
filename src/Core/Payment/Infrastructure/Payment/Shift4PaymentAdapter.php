<?php

namespace App\Core\Payment\Infrastructure\Payment;

use App\Core\Payment\Application\Service\PaymentServiceInterface;

class Shift4PaymentAdapter implements PaymentServiceInterface
{
    public function processPayment(float $amount, string $currency, array $paymentDetails): array
    {
        // TODO Implement processPayment() method.
        return ['status' => 'not_supported'];
    }

    public function refundPayment(string $transactionId, float $amount): array
    {
        return ['status' => 'not_supported'];
    }

    public function validatePaymentDetails(array $paymentDetails): bool
    {
        return isset($paymentDetails['cardNumber']);
    }
}