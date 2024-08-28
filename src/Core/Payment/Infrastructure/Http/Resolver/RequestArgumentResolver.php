<?php

declare(strict_types=1);

namespace App\Core\Payment\Infrastructure\Http\Resolver;

use App\Core\Payment\Infrastructure\Http\Contract\RequestAwareInterface;
use App\Core\Payment\Infrastructure\Http\Exceptions\BadRequestException;
use App\Core\Payment\Infrastructure\Http\Exceptions\RequestValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TypeError;

readonly class RequestArgumentResolver implements ArgumentValueResolverInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), RequestAwareInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @var class-string<RequestAwareInterface> $class */
        $class = $argument->getType();

        try {
            /** @var RequestAwareInterface $dto */
            $dto = new $class();
            $dto->setRequest($request);
        } catch (TypeError) {
            throw new BadRequestException();
        }

        if (count($violationList = $this->validator->validate($dto)) > 0) {
            throw new RequestValidationException($violationList);
        }

        yield $dto;
    }
}
