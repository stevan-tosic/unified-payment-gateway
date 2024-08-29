<?php

namespace App\Core\Payment\Application\Command;

class ProcessPaymentCommand
{
    private array $paymentDetails;
    private string $service;

    public function __construct(string $service, array $paymentDetails)
    {
        $this->service = $service;
        $this->paymentDetails = $paymentDetails;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getPaymentDetails(): array
    {
        return $this->paymentDetails;
    }
}
