<?php

namespace App\Machine;

interface ChangeCalculatorInterface
{
    /**
     * @param float $amountInCoins
     *
     * @return array
     *
     * @throws \Exception
     */
    public function calculate(float $amountInCoins): array;
}
