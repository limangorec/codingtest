<?php

namespace App\Machine;

class Purchase implements PurchaseTransactionInterface
{
    public function __construct(private int $quantity, private float $paidAmount)
    {
    }

    /** @inheritDoc */
    public function getItemQuantity()
    {
        return $this->quantity;
    }

    /** @inheritDoc */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }
}
