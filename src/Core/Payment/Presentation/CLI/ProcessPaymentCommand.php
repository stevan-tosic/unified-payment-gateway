<?php

namespace App\Core\Payment\Presentation\CLI;

use App\Core\Payment\Application\Command\ProcessPaymentCommand as ProcessPaymentAppCommand;
use App\Core\Payment\Application\Handler\PaymentHandler;
use App\Core\Payment\Application\Service\PaymentContext;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('payment:process')]
class ProcessPaymentCommand extends Command
{
    public function __construct(
        readonly PaymentContext $paymentContext,
        readonly PaymentHandler $paymentHandler,
    ) {
        parent::__construct(name: 'payment:process');
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Processes a payment through a specified service.')
            ->addArgument('service', InputArgument::REQUIRED, 'The payment service to use (aci or shift4)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $service = $input->getArgument('service');

        $paymentDetails = [
            'cardNumber' => '4111111111111111',
            'paymentBrand' => 'VISA'
        ];

        $command = new ProcessPaymentAppCommand(100.00, 'EUR', $paymentDetails, $service);
        $result = $this->paymentHandler->handle($command);

        if (!$result) {
            $output->writeln('Unsupported service selected.');
            return Command::FAILURE;
        }

        $output->writeln('Payment processed with ' . $service . ': ' . json_encode($result));
        return Command::SUCCESS;
    }
}