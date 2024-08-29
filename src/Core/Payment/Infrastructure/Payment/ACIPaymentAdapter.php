<?php

namespace App\Core\Payment\Infrastructure\Payment;

use App\Core\Payment\Application\DTO\Response\PaymentResponse;
use App\Core\Payment\Application\Service\PaymentServiceInterface;
use App\Core\Payment\Infrastructure\Http\Exceptions\PaymentException;

class ACIPaymentAdapter implements PaymentServiceInterface
{
    private const string API_URL = "https://eu-test.oppwa.com/v1/payments";

    public function processPayment(array $paymentDetails): PaymentResponse
    {
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
            "&amount=" . $paymentDetails['amount'] .
            "&currency=" . $paymentDetails['currency'] .
            "&paymentBrand=VISA" .
            "&paymentType=DB" .
            "&card.number=" . $paymentDetails['cardNumber'] .
            "&card.holder=Jane Jones" .
            "&card.expiryMonth=" . $paymentDetails['cardExpMonth'] .
            "&card.expiryYear=" . $paymentDetails['cardExpYear'] .
            "&card.cvv=123";

        $responseData = $this->makeCurlRequest(self::API_URL, $data);

        $decodedData = json_decode($responseData, true);

        return new PaymentResponse(
            transactionId: $decodedData['id'],
            dateOfCreation: date("Y-m-d H:i:s", (int) $decodedData['timestamp']),
            amount: floatval($decodedData['amount']),
            currency: $decodedData['currency'],
            cardBin: $decodedData['card']['bin']
        );
    }

    private function makeCurlRequest(string $url, string $data): string|false
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // This should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);

            throw new PaymentException($error);
        }
        curl_close($ch);

        return $responseData;
    }
}
