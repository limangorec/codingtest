<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Model\Transaction;
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

        $purchaseTransaction = new Transaction($itemCount, $amount);
        $cigaretteMachine = new CigaretteMachine();
        $resultOfTransaction = $cigaretteMachine->execute($purchaseTransaction);
        // check if customer paid enough
        if($resultOfTransaction['paidEnough']){
            $output->writeln($resultOfTransaction['message']);
            $output->writeln('Your change is:');
            $table = new Table($output);
            $table->setHeaders(array('Coins', 'Count'))
                ->setRows($resultOfTransaction['changeTable']);
            $table->render();
        } else {
            $output->writeln($resultOfTransaction['message']);
        }
    }
}
