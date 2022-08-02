<?php

namespace App\Command;

use App\Machine\PurchaseTransaction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Machine\CigaretteMachine;

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
        try {
            $itemCount = $input->getArgument('packs');
            $amountPaid = $input->getArgument('amount');
            $amountPaid = \str_replace(',', '.', $amountPaid);

            if (!is_numeric($itemCount) || !is_numeric($amountPaid)) {
                $output->writeln('<error> Please enter numeric arguments and try again</error>');
            } else {
                $itemCount = (int)$itemCount;
                $amountPaid = (float)number_format($amountPaid, 2, '.', '');
                $cigaretteMachine = new CigaretteMachine();
                $purchaseTransaction = new PurchaseTransaction($itemCount, $amountPaid);
                $purchasedItem = $cigaretteMachine->execute($purchaseTransaction);
                $amountPayable = $cigaretteMachine->getAmountPayable($purchaseTransaction);

                if ($amountPaid > $amountPayable || bccomp($amountPaid, $amountPayable, 2) == 0) {
                    $changePayable = $purchasedItem->getChange();
                    $output->writeln('You bought <info>' . $itemCount . '</info> packs of cigarettes for <info>' . $amountPayable . '</info>, each for <info>' . $cigaretteMachine::ITEM_PRICE . '</info>. ');
                    if (!empty($changePayable)) {
                        $output->writeln('Your change is:');

                        $table = new Table($output);
                        $table
                            ->setHeaders(array('Coins', 'Count'))
                            ->setRows($changePayable);
                        $table->render();
                    }
                } else {
                    $output->writeln('Total payable amount is <info>' . $amountPayable . '.</info> Amount paid <info>' . $amountPaid . '</info>. Please pay the payable amount and try again.');
                }
            }
        } catch (\Exception $exp) {
            $output->writeln('<error>' . $exp->getMessage() . '</error>');
        } catch (\Error $error) {
            $output->writeln('<error>' . $error->getMessage() . '</error>');
        }
    }
}