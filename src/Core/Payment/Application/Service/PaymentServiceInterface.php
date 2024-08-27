<?php

namespace App\Core\Payment\Application\Service;

interface PaymentServiceInterface
{
    /**
     * Process a payment transaction.
     *
     * @param float $amount The amount of the transaction.
     * @param string $currency The currency code (e.g., USD, EUR).
     * @param array $paymentDetails Additional payment details specific to the payment method.
     * @return array Returns an array with the transaction status and details.
     */
    public function processPayment(float $amount, string $currency, array $paymentDetails): array;

    /**
     * Refund a payment transaction.
     *
     * @param string $transactionId The ID of the transaction to refund.
     * @param float $amount The amount to refund.
     * @return array Returns an array with the refund status and details.
     */
    public function refundPayment(string $transactionId, float $amount): array;

    /**
     * Validate payment details before processing.
     *
     * @param array $paymentDetails Payment details to validate.
     * @return bool Returns true if the payment details are valid, otherwise false.
     */
    public function validatePaymentDetails(array $paymentDetails): bool;
}