<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\PurchasedTransaction;
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
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('purchase-cigarettes');

        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        // TODO validate amount: number of decimals & negative input

        $cigaretteMachine = new CigaretteMachine();
        $purchaseTransaction = new PurchasedTransaction($itemCount, $amount);

        $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);

        // TODO format float to two decimals

        $output->writeln('You bought <info>' .$purchasedItem->getItemQuantity(). '</info> packs of cigarettes for <info>-'.\str_replace('.', ',', $purchasedItem->getTotalAmount()). '</info>, each for <info>-'.\str_replace('.', ',',CigaretteMachine::ITEM_PRICE).'</info>. ');
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($this->prepareChangeArrayForRendering($purchasedItem->getChange()))
        ;
        $table->render();
    }

    private function prepareChangeArrayForRendering(array $change)
    {
        $formattedChange = [];
        foreach ($change as $changeUnit => $changeUnitCount) {
            $formattedChange[] = [number_format((float) $changeUnit, 2, '.', ''), $changeUnitCount];
        }

        return $formattedChange;
    }
}