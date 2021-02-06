<?php

namespace App\Transaction;

use App\Formatter\EuroCoinFormatter;
use App\Interfaces\PurchasedItemInterface;

/**
 * Class PurchasedItem
 *
 * @package App\Machine
 */
class PurchasedTransaction implements PurchasedItemInterface
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
     * @var float
     */
    private $changeInCents;

    public function __construct($itemQuantity, $totalAmount, $changeInCents)
    {
        $errors = '';
        $errors .= $itemQuantity <= 0 ? 'Invalid item quantity' . PHP_EOL : $errors;
        $errors .= $totalAmount <= 0 ? 'Invalid total amount' . PHP_EOL : $errors;
        $errors .= $changeInCents < 0 ? 'Invalid change amount' . PHP_EOL : $errors;

        if ($errors) {
            throw new \InvalidArgumentException($errors);
        }

        $this->itemQuantity = $itemQuantity;
        $this->totalAmount = $totalAmount;
        $this->changeInCents = $changeInCents;
        $this->setChange($this->changeInCents);
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
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @return array
     */
    public function getChange()
    {
        return $this->change;
    }

    /**
     * @param $change
     *
     * @return void
     */
    public function setChange($change)
    {
        $this->change = EuroCoinFormatter::format($change);
    }
}
