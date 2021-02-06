<?php

namespace App\Machine;

use App\Interfaces\MachineInterface;
use App\Interfaces\PurchasedItemInterface;
use App\Interfaces\PurchaseTransactionInterface;
use App\Transaction\PurchasedTransaction;

/**
 * Class CigaretteMachine
 *
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @return PurchasedItemInterface
     * @throws \Exception
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $totalToPay = $this->calculateTotalToPay($purchaseTransaction->getItemQuantity());

        if ($purchaseTransaction->getPaidAmount() < $totalToPay) {
            throw new \Exception(
                sprintf(
                    'Minimum payment is <info>%s</info>. Paid amount was <error>%s</error>',
                $totalToPay,
                $purchaseTransaction->getPaidAmount()
                )
            );
        }

        return new PurchasedTransaction(
            $purchaseTransaction->getItemQuantity(),
            $totalToPay,
            $purchaseTransaction->getPaidAmount() - $totalToPay
        );
    }

    /**
     * @param $itemCount
     *
     * @return float
     */
    private function calculateTotalToPay($itemCount)
    {
        return $itemCount * self::ITEM_PRICE;
    }
}
