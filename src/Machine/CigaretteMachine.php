<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    const COINS = [0.01, 0.02, 0.05, 0.1, 0.2, 0.5, 1, 2];

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @return PurchasedItemInterface
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction) {
        $cigarettePack = new PurchasedCigarettePack();
        $cigarettePack->setItemQuantity($purchaseTransaction->getItemQuantity())
                      ->setPaidAmount($purchaseTransaction->getPaidAmount());
        return $cigarettePack;
    }
}