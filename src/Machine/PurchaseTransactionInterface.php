<?php

namespace App\Machine;

/**
 * Interface PurchasableItemInterface
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

    /**
     * @return bool
     */
    public function isValid();
}