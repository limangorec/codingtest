<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Transaction\PurchaseTransaction;
use App\Helper\EuroCoinTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 *
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
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));

        try {
            $purchaseTransaction = new PurchaseTransaction($itemCount, $amount);
        } catch (\InvalidArgumentException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            return 1;
        }

        $cigaretteMachine = new CigaretteMachine();

        try {
            $purchasedTransaction = $cigaretteMachine->execute($purchaseTransaction);
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return 1;
        }

        $output->writeln(
            sprintf(

                'You bought <info>%s</info> packs of cigarettes for <info>%s</info>, each for <info>%s</info>. ',
                $purchasedTransaction->getItemQuantity(),
                $purchasedTransaction->getTotalAmount(),
                CigaretteMachine::ITEM_PRICE
            )
        );

        if ($purchasedTransaction->getChange()) {
            $output->writeln('Your change is:');

            $euroCoinRenderer = new EuroCoinTable($output);
            $euroCoinRenderer->renderCoinsTable($purchasedTransaction->getChange());
        }
    }
}
