<?php

namespace App\Machine;

/**
 * Class PurchasedItem
 * @package App\Machine
 */
class PurchasedItem implements PurchasedItemInterface
{
    private $itemQuantity;
    private $totalAmount;
    private $change;

    /**
     * @param int $itemQuantity
     * @param float $totalAmount
     * @param array $change
     */
    public function __construct(int $itemQuantity, float $totalAmount, array $change)
    {
        $this->itemQuantity = $itemQuantity;
        $this->totalAmount = $totalAmount;
        $this->change = $change;
    }

    /**
     * @return int
     */
    public function getItemQuantity(): int
    {
        return $this->itemQuantity;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @return array
     */
    public function getChange(): array
    {
        return $this->change;
    }
}