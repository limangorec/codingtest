<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\CigaretteMachineService;
use App\Machine\PurchasedInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    const COMMAND_NAME = 'purchase-cigarettes';
    const ARGUMENT_PACKS_DESCRIPTION = 'How many packs do you want to buy?';
    const ARGUMENT_AMOUNT_DESCRIPTION =  'The amount in euro.';
    const OUTPUT_SUCCESS_MESSAGE =
        'You bought <info>%s</info> packs of cigarettes for <info>%s</info>, each for <info>%s</info>.';
    const OUTPUT_CHANGE_MESSAGE = 'Your change is <info>%s</info>:';
    const OUTPUT_NOT_ENOUGH_MONEY_MESSAGE = 'Not enough money for %s packages. You bought %s packages.';

    /**
     * @var CigaretteMachineService
     */
    protected $cigaretteMachineService;

    /**
     * @param CigaretteMachineService $cigaretteMachineService
     */
    public function __construct(CigaretteMachineService $cigaretteMachineService)
    {
        $this->cigaretteMachineService = $cigaretteMachineService;
        parent::__construct(self::COMMAND_NAME);
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packages', InputArgument::REQUIRED, self::ARGUMENT_PACKS_DESCRIPTION);
        $this->addArgument('money', InputArgument::REQUIRED, self::ARGUMENT_AMOUNT_DESCRIPTION);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $packages = $this->getArgumentPackages($input);
        $money = $this->getArgumentMoney($input);

        $purchased = $this->cigaretteMachineService->buy($packages, $money);

        if ($purchased->getItemQuantity() < $packages) {
            $this->outputNotEnoughMoneyMessage($output, $purchased, $packages);
        } else {
            $this->outputSuccessMessage($output, $purchased);
        }
        $this->outputMoneyChangeMessage($output, $purchased);
    }

    /**
     * @param InputInterface $input
     * @return int
     */
    protected function getArgumentPackages(InputInterface $input)
    {
        return (int) $input->getArgument('packages');
    }

    /**
     * @param InputInterface $input
     * @return float
     */
    protected function getArgumentMoney(InputInterface $input)
    {
        return (float)\str_replace(',', '.', $input->getArgument('money'));
    }

    /**
     * @param OutputInterface $output
     * @param PurchasedInterface $purchased
     */
    protected function outputSuccessMessage(OutputInterface $output, PurchasedInterface $purchased)
    {
        $output->writeln(
            sprintf(self::OUTPUT_SUCCESS_MESSAGE,
                $purchased->getItemQuantity(),
                $purchased->getTotalAmount(),
                CigaretteMachine::ITEM_PRICE
            )
        );
    }

    protected function outputNotEnoughMoneyMessage(OutputInterface $output, PurchasedInterface $purchased, $desiredPackages)
    {
        $output->writeln(
            sprintf(self::OUTPUT_NOT_ENOUGH_MONEY_MESSAGE,
                $desiredPackages,
                $purchased->getItemQuantity()
            )
        );
    }

    /**
     * @param OutputInterface $output
     * @param PurchasedInterface $purchased
     */
    protected function outputMoneyChangeMessage(OutputInterface $output, PurchasedInterface $purchased)
    {
        $output->writeln(sprintf(self::OUTPUT_CHANGE_MESSAGE, $purchased->getTotalLeft()));
        $change = $purchased->getChange();

        array_walk($change, function(&$key, $value) {
            $key =  [$value, $key];
        });

        $table = new Table($output);
        $table
            ->setHeaders(['Coins', 'Count'])
            ->setRows($change);
        $table->render();
    }
}
