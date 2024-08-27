<?php

namespace App\Core\Payment\Application\Service;

use App\Core\Payment\Infrastructure\Payment\ACIPaymentAdapter;
use App\Core\Payment\Infrastructure\Payment\Shift4PaymentAdapter;
use InvalidArgumentException;

class PaymentContext
{
    private PaymentServiceInterface $strategy;

    public function setStrategy(string $serviceName): void
    {
        $this->strategy = match ($serviceName) {
            'aci' => new ACIPaymentAdapter(),
            'shift4' => new Shift4PaymentAdapter(),
            default => throw new InvalidArgumentException('Unsupported service selected.'),
        };
    }

    public function processPayment($amount, $currency, $paymentDetails): array
    {
        return $this->strategy->processPayment($amount, $currency, $paymentDetails);
    }
}