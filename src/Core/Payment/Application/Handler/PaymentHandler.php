<?php

namespace App\Core\Payment\Application\Handler;

use App\Core\Payment\Application\Command\ProcessPaymentCommand;
use App\Core\Payment\Application\Service\PaymentContext;

class PaymentHandler
{
    private PaymentContext $paymentContext;

    public function __construct(PaymentContext $paymentContext)
    {
        $this->paymentContext = $paymentContext;
    }

    public function handle(ProcessPaymentCommand $command): array
    {
        $this->paymentContext->setStrategy($command->getService());

        return $this->paymentContext->processPayment(
            $command->getAmount(),
            $command->getCurrency(),
            $command->getPaymentDetails()
        );
    }
}