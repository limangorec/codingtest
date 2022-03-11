<?php

namespace App\Model;

use App\Machine\PurchaseTransactionInterface;

class PruchasedItem implements \App\Machine\PurchasedItemInterface
{
    private $purchaseTransaction;
    private $totalAmount;
    private $coins = [
        2.0,
        1.0,
        0.5,
        0.2,
        0.1,
        0.05,
        0.02,
        0.01
    ];

    /**
     * Initialize necessary values
     *
     * @param PurchaseTransactionInterface $purchaseTransaction
     * @param $singlePrice
     */
    // Inject the PurchaseTransactionInterface here to reduce duplicate code
    public function __construct(PurchaseTransactionInterface $purchaseTransaction, $singlePrice){
        $this->purchaseTransaction = $purchaseTransaction;
        $this->totalAmount = $purchaseTransaction->getItemQuantity() * $singlePrice;

    }
    /**
     * Get the quantity the customer want
     *
     * @return int
     */
    public function getItemQuantity()
    {
        return $this->purchaseTransaction->getItemQuantity();
    }

    /**
     * Get the total amount he customer must pay
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Get the change the customers gets back
     *
     * @return array
     */
    public function getChange()
    {
        $changeArray = array();
        $paidDifference = $this->purchaseTransaction->getPaidAmount() - $this->totalAmount;
        if($paidDifference > 0){
            // loop through array with possible coins the customer could get back
            foreach($this->coins as $coin){
                // Multiply with 100 to avoid problems with divison at small values
                $tmpResult = round(($paidDifference * 100),0, PHP_ROUND_HALF_DOWN) /  round(($coin * 100),0, PHP_ROUND_HALF_DOWN);
                $numberOfCoins = intval($tmpResult);
                if($numberOfCoins > 0){
                    $changeArray[] = [
                        $coin,
                        $numberOfCoins
                    ];
                    $paidDifference -= $numberOfCoins * $coin;
                    // if the paid difference is smaller than 0 we can break the foreach loop
                    if($paidDifference < 0){
                        break;
                    }
                }
            }
        }
        return $changeArray;
    }
}
