<?php

namespace App\Coin;

class TwoEuro implements CoinInterface
{
    public static function value(): int
    {
        return 200;
    }

}
