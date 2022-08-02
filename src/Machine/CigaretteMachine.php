<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @return PurchasedItemInterface
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        return new PurchasedItem($purchaseTransaction, self::ITEM_PRICE);
    }

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     * @return float
     */
    public function getAmountPayable(PurchaseTransactionInterface $purchaseTransaction)
    {
        return bcmul($purchaseTransaction->getItemQuantity(), self::ITEM_PRICE, 2);
    }
}