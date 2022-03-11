<?php

namespace App\Model;
/**
 * Class Transaction
 * @package App\Model
 */
class Transaction implements \App\Machine\PurchaseTransactionInterface
{

    private $quantity;
    private $paidAmount;

    /**
     * Initialize necessary values
     *
     * @param $quantity
     * @param $paidAmount
     */
    public function __construct($quantity,$paidAmount){
        $this->paidAmount = $paidAmount;
        $this->quantity = $quantity;
    }
    /**
     * Get the quantity the customer want
     *
     * @return int
     */
    public function getItemQuantity()
    {
        return $this->quantity;
    }

    /**
     * Get the amount the customer paud
     *
     * @return float
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }
}
