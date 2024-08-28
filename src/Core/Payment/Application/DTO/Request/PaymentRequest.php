<?php

namespace App\Core\Payment\Application\DTO\Request;

use App\Core\Payment\Infrastructure\Http\Contract\RequestAwareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PaymentRequest implements RequestAwareInterface
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private mixed $amount;
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private mixed $currency;
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private mixed $cardNumber;
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private mixed $cardExpYear;
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private mixed $cardExpMonth;
    #[Assert\NotNull]
    #[Assert\NotBlank]
    private mixed $cardCvv;
    private mixed $service;

    public function setRequest(Request $request): void
    {
        $data = json_decode($request->getContent(), true);

        $this->service = $request->attributes->get('service');

        $this->amount = $data['amount'] ?? null;
        $this->currency = $data['currency'] ?? null;
        $this->cardNumber = $data['cardNumber'] ?? null;
        $this->cardExpYear = $data['cardExpYear'] ?? null;
        $this->cardExpMonth = $data['cardExpMonth'] ?? null;
        $this->cardCvv = $data['cardCvv'] ?? null;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    public function getCardExpYear(): string
    {
        return $this->cardExpYear;
    }

    public function getCardExpMonth(): string
    {
        return $this->cardExpMonth;
    }

    public function getCardCvv(): string
    {
        return $this->cardCvv;
    }

    public function getService(): string
    {
        return $this->service;
    }
}
