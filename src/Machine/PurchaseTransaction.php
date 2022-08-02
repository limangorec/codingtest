<?php

namespace App\Machine;

/**
 * Class PurchaseTransaction
 * @package App\Machine
 */
class PurchaseTransaction implements PurchaseTransactionInterface
{
    private $itemQuantity;
    private $paidAmount;

    /**
     * @param $itemQuantity
     * @param $paidAmount
     */
    public function __construct($itemQuantity, $paidAmount)
    {
        $this->itemQuantity = (int)$itemQuantity;
        $this->paidAmount = (float)$paidAmount;
    }


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
}