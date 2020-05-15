<?php

namespace App\Machine;

/**
 * Interface PurchasedInterface
 * @package App\Machine
 */
interface PurchasedInterface
{
    /**
     * @return integer
     */
    public function getItemQuantity();

    /**
     * @return float
     */
    public function getTotalLeft();

    /**
     * @return float
     */
    public function getTotalAmount();

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     *
     * @return array
     */
    public function getChange();
}