<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;
    const COINS = [0.01, 0.02, 0.05, 0.10, 0.25, 0.50, 1, 2];

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     * @return CigarettePurchased|PurchasedInterface
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $packagesAmountDesired = $purchaseTransaction->getItemQuantity();
        $packagesBought = 0;
        $moneyLeft = $purchaseTransaction->getPaidAmount();

        while ($moneyLeft >= self::ITEM_PRICE && $packagesBought < $packagesAmountDesired) {
            $moneyLeft = round($moneyLeft - self::ITEM_PRICE, 2);
            $packagesBought++;
        }
        $money = round($purchaseTransaction->getPaidAmount() - $moneyLeft, 2);
        $change = $this->calculateChange($moneyLeft);

        return new CigarettePurchased($money, $moneyLeft, $packagesBought, $change);
    }

    /**
     * @param float $money
     * @return array
     */
    protected function calculateChange($money)
    {
        $coins = self::COINS;
        $change = array_combine(
            self::COINS,
            array_fill(0, count(self::COINS),0)
        );

        rsort($coins);

        while(round($money,2) > 0) {
            $currentCoin = current($coins);
            if (round($money - $currentCoin, 2) < 0) {
                array_shift($coins);
            } else {
                $change[ (string) $currentCoin]++;
                $money = round($money - $currentCoin, 2);
            }
        }

        return array_filter($change);
    }
}