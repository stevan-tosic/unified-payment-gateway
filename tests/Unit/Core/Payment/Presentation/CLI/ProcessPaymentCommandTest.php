<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\Payment\Presentation\CLI;

use App\Core\Payment\Application\Command\ProcessPaymentCommand as ProcessPaymentAppCommand;
use App\Core\Payment\Application\DTO\Response\PaymentResponse;
use App\Core\Payment\Application\Handler\PaymentHandler;
use App\Core\Payment\Application\Service\PaymentContext;
use App\Core\Payment\Presentation\CLI\ProcessPaymentCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \App\Core\Payment\Presentation\CLI\ProcessPaymentCommand
 */
class ProcessPaymentCommandTest extends TestCase
{
    private PaymentHandler&MockObject $paymentHandlerMock;
    private PaymentContext&MockObject $paymentContextMock;
    private ProcessPaymentCommand $processPaymentCommand;

    protected function setUp(): void
    {
        $this->paymentHandlerMock = $this->createMock(PaymentHandler::class);
        $this->paymentContextMock = $this->createMock(PaymentContext::class);

        $this->processPaymentCommand = new ProcessPaymentCommand(
            $this->paymentContextMock,
            $this->paymentHandlerMock
        );
    }

    public function testExecute()
    {
        $application = new Application();
        $application->add($this->processPaymentCommand);

        $command = $application->find('payment:process');
        $commandTester = new CommandTester($command);

        $this->paymentHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(ProcessPaymentAppCommand::class))
            ->willReturn(
                new PaymentResponse(
                    '12345',
                    '2023-10-01',
                    100.00,
                    'EUR',
                    '411111'
                )
            );

        $commandTester->execute([
            'command' => $command->getName(),
            'service' => 'aci',
            '--amount' => 100.00,
            '--currency' => 'EUR',
            '--cardNumber' => '4111111111111111',
            '--cardExpYear' => '2025',
            '--cardExpMonth' => '12',
            '--cardCvv' => '123'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Payment processed with aci', $output);
        $this->assertStringContainsString('"transactionId":"12345"', $output);
    }

    public function testExecuteFail()
    {
        $application = new Application();
        $application->add($this->processPaymentCommand);

        $command = $application->find('payment:process');
        $commandTester = new CommandTester($command);

        $this->paymentHandlerMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->isInstanceOf(ProcessPaymentAppCommand::class))
            ->willReturn(null);

        $commandTester->execute([
            'command' => $command->getName(),
            'service' => 'non-existing-service',
            '--amount' => 100.00,
            '--currency' => 'EUR',
            '--cardNumber' => '4111111111111111',
            '--cardExpYear' => '2025',
            '--cardExpMonth' => '12',
            '--cardCvv' => '123'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Unsupported service selected', $output);
    }
}
