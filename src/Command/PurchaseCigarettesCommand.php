<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransactionInterface;

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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int)$input->getArgument('packs');
        $amount    = (float)\str_replace(',', '.', $input->getArgument('amount'));

        $cigaretteMachine             = new CigaretteMachine();
        $cigarettePurchaseTransaction = new class($itemCount, $amount) implements PurchaseTransactionInterface{
            private $m_nItemQuantity;
            private $m_nPaidAmount;
            public function __construct($itemCount, $amount)
            {
                $this->m_nItemQuantity = $itemCount;
                $this->m_nPaidAmount   = $amount;
            }

            public function getItemQuantity()
            {
                return $this->m_nItemQuantity;
            }

            public function getPaidAmount()
            {
                return $this->m_nPaidAmount;
            }
        };

        $cigarettePurchasedItem = $cigaretteMachine->execute($cigarettePurchaseTransaction);

        $output->writeln('You bought <info>' . $cigarettePurchasedItem->getItemQuantity() . '</info> packs of cigarettes for <info>' . $cigarettePurchasedItem->getTotalAmount() . '</info>, each for <info>' . CigaretteMachine::ITEM_PRICE . '</info>. ');
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($cigarettePurchasedItem->getChange());
        $table->render();
    }
}