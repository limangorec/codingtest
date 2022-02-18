<?php

namespace App\Machine;

use App\Coin\CoinFormatter;

class Purchase implements PurchasedItemInterface
{

    private $quantity;

    private $totalAmount;

    private $change;

    public function __construct (int $quantity, float $totalAmount, array $change)
    {
        $this->quantity = $quantity;
        $this->totalAmount = $totalAmount;
        $this->change = $change;
    }

    /**
     * @inheritDoc
     */
    public function getItemQuantity() : int
    {
        return $this->quantity;
    }

    /**
     * @inheritDoc
     */
    public function getTotalAmount() : float
    {
        return $this->totalAmount;
    }

    /**
     * @inheritDoc
     */
    public function getChange() : array
    {
        $coins = [];
        foreach($this->change as $coin) {
            $formattedValue = CoinFormatter::formatCoin($coin);
            if(array_key_exists($formattedValue,$coins)){
                $coins[$formattedValue] += 1;
            } else {
                $coins[$formattedValue] = 1;
            }
        }

        $change = [];
        foreach($coins as $key => $amount) {
            $change[] = [$key, $amount];
        }

        return $change;
    }
}
