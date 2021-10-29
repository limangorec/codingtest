<?php

namespace App\Machine;

use function round;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    const POSSIBLE_COINS = [
        2, 1, 0.5, 0.2, 0.1, 0.05, 0.02, 0.01
    ];

    private $purchaseSuccessful = true;

    /**
     * @return bool
     */
    public function isPurchaseSuccessful(): bool
    {
        return $this->purchaseSuccessful;
    }

    /**
     * @param bool $purchaseSuccessful
     */
    public function setPurchaseSuccessful(bool $purchaseSuccessful)
    {
        $this->purchaseSuccessful = $purchaseSuccessful;
    }

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @return PurchasedItemInterface
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface
    {
        $totalAmount = $purchaseTransaction->getItemQuantity() * self::ITEM_PRICE;
        $change = $purchaseTransaction->getPaidAmount() - $totalAmount;
        $changeInCoins = [];
        if($change < 0){
            $this->setPurchaseSuccessful(false);
        }else if($change > 0){
            $changeInCoins = $this->splitAmountInCoins($change);
        }
        return new PurchasedItem($purchaseTransaction->getItemQuantity(), $totalAmount, $changeInCoins);
    }

    /**
     * @param float $amount
     *
     * @return array
     */
    private function splitAmountInCoins(float $amount): array
    {
        /**
         * PHP has a bug by the handling of float numbers.
         * To bypass it, we multiply all values with 100, so we can use them as integer.
         */
        $coins = [];
        $amount = round($amount * 100);
        foreach(self::POSSIBLE_COINS as $possibleCoin){
            $possibleCoin = (int)($possibleCoin * 100);
            if($amount >= $possibleCoin){
                $countOfThisCoin = (int)($amount / $possibleCoin);
                $coins[] = [(string)($possibleCoin / 100), $countOfThisCoin];
                $amount -= $countOfThisCoin * $possibleCoin;

                if($amount == 0){
                    break;
                }
            }
        }
        return $coins;
    }
}