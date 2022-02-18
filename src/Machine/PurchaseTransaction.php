<?php

namespace App\Machine;

class PurchaseTransaction implements PurchaseTransactionInterface
{
    private $quantity;

    private $amount;


    public function __construct(int $quantity, float $amount)
    {
        $this->quantity = $quantity;
        $this->amount = $amount;
    }

    public function getItemQuantity() : int
    {
        return $this->quantity;
    }

    public function getPaidAmount() : float
    {
        return $this->amount;
    }

}
