<?php

namespace App\Machine;

class PurchasedItem implements PurchasedItemInterface
{
    public function __construct(
        private int $itemQuantity,
        private float $totalAmount,
        private array $change,
        private $price
    ) {
    }

    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    public function getChange()
    {
        return $this->change;
    }

    public function getPrice()
    {
       return $this->price;
    }
}
