<?php

namespace App\Command;

use App\Machine\PurchaseTransaction;
use App\Machine\CigaretteMachine;
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
        try {
            $itemCount = (int) $input->getArgument('packs');
            $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

            $transaction = new PurchaseTransaction();
            $transaction->setPaidAmount($amount)
                ->setItemQuantity($itemCount);

            $cigaretteMachine = new CigaretteMachine();
            $purchasedCigarette = $cigaretteMachine->execute($transaction);
            $itemPrice = CigaretteMachine::ITEM_PRICE;

            $output->writeln(
                'You bought <info>' . $purchasedCigarette->getItemQuantity() . '</info> packs of cigarettes ' .
                'for <info>' . $purchasedCigarette->getTotalAmount() . '</info>, ' .
                'each for <info>' . $itemPrice . '</info>.');
            $output->writeln('Your change is:');

            $table = new Table($output);
            $table
                ->setHeaders(array('Coins', 'Count'))
                ->setRows($purchasedCigarette->getChange())
            ;
            $table->render();
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
        }
    }
}