<?php

namespace App\Machine;

class PurchasedItem implements PurchasedItemInterface
{
    /**
     * @var int
     */
    private $itemQuantity;

    /**
     * @var float
     */
    private $totalAmount;

    /**
     * @var array
     */
    private $change;

    /**
     * @return int
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @param int $itemQuantity
     * @return PurchasedItem
     */
    public function setItemQuantity($itemQuantity)
    {
        $this->itemQuantity = $itemQuantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     * @return PurchasedItem
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return array
     */
    public function getChange()
    {
        return $this->change;
    }

    /**
     * @param array $change
     * @return PurchasedItem
     */
    public function setChange($change)
    {
        $this->change = $change;
        return $this;
    }
}
