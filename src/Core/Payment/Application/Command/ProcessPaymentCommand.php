<?php

namespace App\Core\Payment\Application\Command;

class ProcessPaymentCommand
{
    private float $amount;
    private string $currency;
    private array $paymentDetails;
    private string $service;

    public function __construct(float $amount, string $currency, array $paymentDetails, string $service)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->paymentDetails = $paymentDetails;
        $this->service = $service;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPaymentDetails(): array
    {
        return $this->paymentDetails;
    }

    public function getService(): string
    {
        return $this->service;
    }
}