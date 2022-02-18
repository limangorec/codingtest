<?php

namespace App\Coin;

class FiftyCent implements CoinInterface
{
    public static function value(): int
    {
        return 50;
    }
}
