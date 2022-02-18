<?php

namespace App\Coin;

class TenCent implements CoinInterface
{

    /**
     * @inheritDoc
     */
    public static function value(): int
    {
        return 10;
    }
}
