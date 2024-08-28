<?php

declare(strict_types=1);

namespace App\Core\Payment\Infrastructure\Http\Exceptions;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidationException extends BadRequestHttpException
{
    private const string VALIDATION_FAILED_MESSAGE = 'Request validation failed.';

    public function __construct(private readonly ConstraintViolationListInterface $violationList)
    {
        $errors = $this->formatValidationErrors($violationList);
        parent::__construct(
            message: self::VALIDATION_FAILED_MESSAGE . ' ' . $errors,
        );
    }

    private function formatValidationErrors(ConstraintViolationListInterface $violationList): string
    {
        $errors = [];
        foreach ($violationList as $violation) {
            $errors[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
        }
        return implode(', ', $errors);
    }
}
