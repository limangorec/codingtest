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
     * {@inheritdoc}
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $requestedItemQuantity = $purchaseTransaction->getItemQuantity();
        $paidAmountInCents = $purchaseTransaction->getPaidAmount();
        $itemPriceInCents = static::ITEM_PRICE;

        return new PurchasedItem($requestedItemQuantity, $itemPriceInCents, $paidAmountInCents);
    }
}