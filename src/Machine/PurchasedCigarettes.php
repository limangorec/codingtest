<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 25/07/2019
 * Time: 08:31
 */

namespace App\Machine;


class PurchasedCigarettes implements PurchasedItemInterface
{
    private $itemQuantity = 0;
    private $totalAmount = 0.0;


    function __construct($itemQuantity, $totalAmount)
    {
        $this->itemQuantity = (int)$itemQuantity;
        $this->totalAmount = (float)$totalAmount;
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
        $totalChange = round($this->totalAmount - ($this->itemQuantity * CigaretteMachine::ITEM_PRICE), 2);
        $change = ["2" => 0, "1" => 0, "0.5" => 0, "0.2" => 0, "0.1" => 0, "0.05" => 0, "0.02" => 0, "0.01" => 0];
        $sum = 0.0;

        foreach ($change as $coin => $amount) {
            while ($sum + $coin <= $totalChange) {
                /* add current coin once if not exceeding total amount of change */
                $change[$coin]++;
                $sum += (float)$coin;
            }
        }

        $return = array();
        foreach (array_reverse($change, true) as $coin => $amount) {
            if ($amount > 0) $return[] = array($coin, $amount);
        }

        return $return;
    }
}