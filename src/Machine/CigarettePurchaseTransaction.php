<?php


namespace App\Machine;

/**
 * Class CigarettePurchaseTransaction
 * @package App\Machine
 */
class CigarettePurchaseTransaction implements PurchaseTransactionInterface
{
    /**
     * Quantity of cigarettes requested
     * @var int
     */
    protected $itemQuantity;

    /**
     * @var float
     */
    protected $paidAmount;

    /**
     * @param $itemQuantity
     * @param $paidAmount
     */
    public function __construct($itemQuantity, $paidAmount)
    {
        $this->itemQuantity = $itemQuantity;
        $this->paidAmount = $paidAmount;
    }

    /**
     * Quantity of cigarettes requested
     *
     * @return int
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