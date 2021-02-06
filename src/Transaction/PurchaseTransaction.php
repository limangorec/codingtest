<?php

namespace App\Transaction;

use App\Interfaces\PurchaseTransactionInterface;

/**
 * Class PurchaseTransaction
 *
 * @package App\Machine
 */
class PurchaseTransaction implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private $itemQuantity;

    /**
     * @var float
     */
    private $paidAmount;

    /**
     * PurchaseTransaction constructor.
     *
     * @throws \InvalidArgumentException
     *
     * @param $itemQuantity
     * @param $paidAmount
     */
    public function __construct($itemQuantity, $paidAmount)
    {
        $errors = '';
        $errors .= $itemQuantity <= 0 ? 'Item quantity should be bigger than 0' . PHP_EOL : $errors;
        $errors .= $paidAmount <= 0 ? 'Paid amount should be bigger than 0' . PHP_EOL : $errors;

        if ($errors) {
            throw new \InvalidArgumentException($errors);
        }

        $this->itemQuantity = $itemQuantity;
        $this->paidAmount = $paidAmount;
    }

    /**
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
