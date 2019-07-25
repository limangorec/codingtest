<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 25/07/2019
 * Time: 08:50
 */

namespace App\Machine;


class CigarettePurchaseTransaction implements PurchaseTransactionInterface
{
    private $itemQuantity;
    private $totalAmount;

    function __construct($itemQuantity, $totalAmount)
    {
        $this->itemQuantity = (int) $itemQuantity;
        $this->totalAmount = (float) $totalAmount;
    }

    /**
     * @return integer
     */
    public function getItemQuantity() {
        return $this->itemQuantity;
    }

    /**
     * @return float
     */
    public function getPaidAmount() {
        return $this->totalAmount;
    }

}