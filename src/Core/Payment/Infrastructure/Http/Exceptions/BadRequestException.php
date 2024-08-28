<?php

declare(strict_types=1);

namespace App\Core\Payment\Infrastructure\Http\Exceptions;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BadRequestException extends BadRequestHttpException
{
    private const string MESSAGE = 'The request parameters are invalid.';

    public function __construct()
    {
        parent::__construct(self::MESSAGE);
    }
}
