<?php

namespace App\Tests\Unit;

use App\Kernel;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Kernel
 */
class KernelTest extends TestCase
{
    public function testKernelCanBeInstantiated()
    {
        $kernel = new Kernel('dev', true);
        $this->assertInstanceOf(Kernel::class, $kernel);
    }
}
