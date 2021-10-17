<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
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

        $itemCount = (int) abs($input->getArgument('packs'));
        $amount = (float) abs(str_replace(',', '.', $input->getArgument('amount')));

        $purchaseTransaction = new PurchaseTransaction();
        $purchaseTransaction
            ->setItemQuantity($itemCount)
            ->setPaidAmount($amount)
        ;

        $cigaretteMachine = new CigaretteMachine();
        $cigaretteMachine->execute($purchaseTransaction);


        $message = $cigaretteMachine->isPaidAmountEnough()
            ?
            sprintf(
                "You bought <info>%d</info> packs of cigarettes for <info>%01.2f€</info>, each for <info>%01.2f€</info>.\n ",
                $cigaretteMachine->getPurchasedItem()->getItemQuantity(),
                $cigaretteMachine->getPurchasedItem()->getTotalAmount(),
                CigaretteMachine::ITEM_PRICE
            )
            :
            sprintf(
                "The entered amount of %01.2f€ is too low. To make a purchase of %d packs you have to pay %01.2f€.\n",
                $purchaseTransaction->getPaidAmount(),
                $cigaretteMachine->getPurchasedItem()->getItemQuantity(),
                $cigaretteMachine->getPurchasedItem()->getTotalAmount()
            )
            ;

        $output->writeln($message);

        if ( !empty($cigaretteMachine->getPurchasedItem()->getChange())) {

            $message = $cigaretteMachine->isPaidAmountEnough()
                ? 'Your change is:'
                : "Here is your money:"
            ;

            $output->writeln($message);

            $table = new Table($output);
            $table
                ->setHeaders(array('Coins', 'Count'))
                ->setRows(
                    $cigaretteMachine->getPurchasedItem()->getChange()
                )
            ;
            $table->render();
        }
    }
}
