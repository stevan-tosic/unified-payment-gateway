<?php

declare(strict_types=1);

namespace App\Core\Payment\Application\DTO\Response;

readonly class PaymentResponse
{
    public function __construct(
        public string $transactionId,
        public string $dateOfCreation,
        public float $amount,
        public string $currency,
        public ?string $cardBin,
    ) {
    }
}
