<?php

namespace App\Machine;

class MaxToMinChangeCalculator implements ChangeCalculatorInterface
{
    private const COINS = ['20' => 2000, '10' => 1000, '5' => 500, '1' => 100, '0.1' => 10, '0.02' => 2, '0.01' => 1];
    private const MULTIPLIER = 100;

    /** @inheritDoc */
    public function calculate(float $amount): array
    {
        if ($amount <= 0.0) {
            return [];
        }

        $amountInCoins = (int)round($amount * self::MULTIPLIER, 0);

        $change = [];
        foreach (self::COINS as $key => $coin) {
            if ($coin <= $amountInCoins) {
                $numberOfCoin = intdiv($amountInCoins, $coin);
                $change[] = [$key, $numberOfCoin];
                $amountInCoins -= ($coin * $numberOfCoin);
            }

            if ($amountInCoins === 0) {
                return $change;
            }
        }

        throw new \Exception('We can not give you the change' . $amountInCoins);
    }

}
