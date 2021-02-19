<?php

namespace App\Machine;

class PurchaseTransaction implements PurchaseTransactionInterface
{
    private $itemQuantity = 0;
    private $paidAmount = 0;

    /**
     * @return integer
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @return float
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * @param integer $itemQuantity
     *
     * @return $this
     */
    public function setItemQuantity($itemQuantity = 0)
    {
        $this->itemQuantity = $itemQuantity;
        return $this;
    }

    /**
     * @param float $paidAmount
     *
     * @return $this
     */
    public function setPaidAmount($paidAmount = 0)
    {
        $this->paidAmount = $paidAmount;
        return $this;
    }

}