<?php

namespace App\Machine;

/**
 * Interface PurchaseTransactionInterface
 * @package App\Machine
 */
interface PurchaseTransactionInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity();

    /**
     * @return float
     */
    public function getPaidAmount();
}