<?php

declare(strict_types=1);

namespace App\Core\Payment\Infrastructure\Http\Exceptions;

use Exception;

class PaymentException extends Exception
{
    private const string MESSAGE = 'Payment exception';

    public function __construct($message = self::MESSAGE, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
