<?php

declare(strict_types=1);

namespace App\Core\Payment\Infrastructure\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $statusCode = $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $message = $exception->getMessage();

        $response = new JsonResponse(
            [
                'success' => false,
                'error' => $message,
                'code' => $statusCode
            ],
            $statusCode
        );

        $event->setResponse($response);
    }
}