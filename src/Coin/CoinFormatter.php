<?php

namespace App\Coin;

class CoinFormatter
{
    public static function formatCoin(CoinInterface $coin): string
    {
        return number_format($coin::value() / 100,2);
    }
}
