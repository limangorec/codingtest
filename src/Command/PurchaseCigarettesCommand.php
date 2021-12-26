<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\MaxToMinChangeCalculator;
use App\Machine\Purchase;
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
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        //to constructor
        $cigaretteMachine = new CigaretteMachine(new MaxToMinChangeCalculator());
        $result = $cigaretteMachine->execute(new Purchase($itemCount, $amount));


        $output->writeln('You bought <info>'. $result->getItemQuantity() . '</info> packs of cigarettes for <info>'. $result->getTotalAmount() . '</info>, each for <info>' . $result->getPrice() . '</info>. ');
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($result->getChange()
            )
        ;
        $table->render();

    }
}
