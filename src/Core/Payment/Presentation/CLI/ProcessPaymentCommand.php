<?php

namespace App\Core\Payment\Presentation\CLI;

use App\Core\Payment\Application\Command\ProcessPaymentCommand as ProcessPaymentAppCommand;
use App\Core\Payment\Application\Handler\PaymentHandler;
use App\Core\Payment\Application\Service\PaymentContext;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->addArgument('service', InputArgument::REQUIRED, 'The payment service to use (aci or shift4)')
            ->addOption('amount', null, InputOption::VALUE_REQUIRED, 'Payment amount')
            ->addOption('currency', null, InputOption::VALUE_REQUIRED, 'Currency code')
            ->addOption('cardNumber', null, InputOption::VALUE_REQUIRED, 'Credit card number')
            ->addOption('cardExpYear', null, InputOption::VALUE_REQUIRED, 'Card expiration year')
            ->addOption('cardExpMonth', null, InputOption::VALUE_REQUIRED, 'Card expiration month')
            ->addOption('cardCvv', null, InputOption::VALUE_REQUIRED, 'Card CVV');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $service = $input->getArgument('service');

        $paymentDetails = [
            'amount' => $input->getOption('amount'),
            'currency' => $input->getOption('currency'),
            'cardNumber' => $input->getOption('cardNumber'),
            'cardExpYear' => $input->getOption('cardExpYear'),
            'cardExpMonth' => $input->getOption('cardExpMonth'),
            'cardCvv' => $input->getOption('cardCvv'),
        ];

        $command = new ProcessPaymentAppCommand($service, $paymentDetails);
        $result = $this->paymentHandler->handle($command);

        if (!$result) {
            $output->writeln('Unsupported service selected.');
            return Command::FAILURE;
        }

        $output->writeln('Payment processed with ' . $service . ': ' . json_encode($result));
        return Command::SUCCESS;
    }
}