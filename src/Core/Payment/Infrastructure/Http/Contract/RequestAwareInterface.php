<?php

declare(strict_types=1);

namespace App\Core\Payment\Infrastructure\Http\Contract;

use Symfony\Component\HttpFoundation\Request;

interface RequestAwareInterface
{
    public function setRequest(Request $request): void;
}
