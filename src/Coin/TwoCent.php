<?php

namespace App\Coin;

class TwoCent implements CoinInterface
{
    public static function value(): int
    {
        return 2;
    }

}
