<?php

namespace App\Coin;

class OneEuro implements CoinInterface
{

    /**
     * @inheritDoc
     */
    public static function value(): int
    {
       return 100;
    }
}
