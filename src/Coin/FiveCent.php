<?php

namespace App\Coin;

class FiveCent implements CoinInterface
{

    /**
     * @inheritDoc
     */
    public static function value(): int
    {
        return 5;
    }
}
