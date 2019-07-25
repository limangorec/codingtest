<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Machine;

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
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        if ($amount < $itemCount * Machine\CigaretteMachine::ITEM_PRICE) {
            $output->writeln($amount . ' is not enough money to pay for ' . $itemCount . ' packs of cigarettes');
            exit;
        }

        $cigaretteMachine = new Machine\CigaretteMachine();
        $cigarettePurchaseTransaction = new Machine\CigarettePurchaseTransaction($itemCount, $amount);
        $purchaseCigarette = $cigaretteMachine->execute($cigarettePurchaseTransaction);

        $output->writeln('You bought <info>'.$purchaseCigarette->getItemQuantity().'</info> packs of cigarettes for <info>'.$purchaseCigarette->getTotalAmount().'</info>, each for <info>'.$cigaretteMachine::ITEM_PRICE.'</info>. ');
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($purchaseCigarette->getChange())
        ;
        $table->render();

    }
}