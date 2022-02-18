<?php

namespace App\Coin;

class OneCent implements CoinInterface
{
    public static function value(): int
    {
        return 1;
    }

}
