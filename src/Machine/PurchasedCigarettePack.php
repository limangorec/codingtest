<?php

namespace App\Machine;

class PurchasedCigarettePack implements PurchasedItemInterface
{
    private $itemQuantity = 0;
    private $paidAmount = 0;

    /**
     * @param integer $itemAmount
     *
     * @return $this
     */
    public function setItemQuantity($itemQuantity = 0)
    {
        $this->itemQuantity = $itemQuantity;
        return $this;
    }

    /**
     * @param float $amount
     *
     * @return $this
     */
    public function setPaidAmount($amount = 0)
    {
        $this->paidAmount = $amount;
        return $this;
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
        return $this->itemQuantity * CigaretteMachine::ITEM_PRICE;
    }

    private function changeCalculator($change) {
        $coins = CigaretteMachine::COINS;
        arsort($coins);
        $changeLeft = $change;
        $coinCountTable = [];
        foreach( $coins as $coin) {
            $sameCoin = true;
            $coinCount = 0;
            while($sameCoin) {
                $difference = round($changeLeft - $coin, 2);
                if($difference < 0) {
                    $sameCoin = false;
                } else {
                    $changeLeft = $difference;
                    $sameCoin = true;
                    $coinCount++;
                }
            }
            if($coinCount > 0) {
                $coinCountTable[] = [$coin, $coinCount];
            }
        }
        return $coinCountTable;
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
        $paid = $this->paidAmount;
        $total = $this->getTotalAmount();
        $change = $paid - $total;
        if($change < 0) {
            throw new \Exception('Paid amount is too low');
        }
        return $this->changeCalculator($change);
    }
}