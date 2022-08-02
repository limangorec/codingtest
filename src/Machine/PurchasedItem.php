<?php

namespace App\Machine;

/**
 * Class PurchasedItem
 * @package App\Machine
 */
class PurchasedItem implements PurchasedItemInterface
{
    private $itemQuantity;
    private $totalAmount;
    private $paidAmount;

    /**
     * @param PurchaseTransactionInterface $purchasedTransaction
     * @param $unitPrice
     */
    public function __construct(PurchaseTransactionInterface $purchasedTransaction, $unitPrice)
    {
        $this->itemQuantity = $purchasedTransaction->getItemQuantity();
        $this->paidAmount = $purchasedTransaction->getPaidAmount();
        $this->totalAmount = bcmul($unitPrice, $this->itemQuantity, 2);
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
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

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
    public function getChange()
    {
        $euroCoins = array(2.0, 1.0, 0.5, 0.2, 0.1, 0.05, 0.02, 0.01);
        $balanceToPay = bcsub($this->paidAmount, $this->totalAmount, 2);
        $coin_change = array();

        if ($balanceToPay > 0) {
            foreach ($euroCoins as $coin) {
                $coin_count = (int)(bcdiv($balanceToPay, $coin, 2));
                if ($coin_count >= 1) {
                    $coin_change[] = [$coin, $coin_count];
                    $balanceToPay = bcsub($balanceToPay, bcmul($coin, $coin_count, 2), 2);
                }
            }
        }
        return $coin_change;
    }
}