<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function str_replace;

/**
 * Class PurchaseCigarettesCommand
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
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) str_replace(',', '.', $input->getArgument('amount'));

        $cigaretteMachine = new CigaretteMachine();
        $purchaseTransaction = new PurchaseTransaction($itemCount, $amount);
        $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);

        if($cigaretteMachine->isPurchaseSuccessful()){
            $output->writeln('You bought <info>' . $purchasedItem->getItemQuantity() . '</info> packs of cigarettes for <info>'
                . $purchasedItem->getTotalAmount() . '</info> €, each for <info>' . $cigaretteMachine::ITEM_PRICE . '</info> €. ');

            if($purchasedItem->getChange() == []){
                $output->writeln('You get no change. You paid exact amount for the cigarettes.');
            }else{
                $output->writeln('Your change is:');

                $table = new Table($output);
                $table
                    ->setHeaders(array('Coins', 'Count'))
                    ->setRows($purchasedItem->getChange());
                $table->render();
            }
        }else{
            $output->writeln('<info>' . $purchaseTransaction->getPaidAmount() . '</info> € is too less money for <info>'
                . $purchaseTransaction->getItemQuantity() . '</info> packs of cigarettes.');
            $output->writeln('One pack of cigarettes costs <info>' . CigaretteMachine::ITEM_PRICE . '</info> €.');
            $output->writeln('You need <info>' . CigaretteMachine::ITEM_PRICE * $purchaseTransaction->getItemQuantity()
                . '</info> € to buy <info>' . $purchaseTransaction->getItemQuantity() . '</info> packs of cigarettes.');
        }
    }
}