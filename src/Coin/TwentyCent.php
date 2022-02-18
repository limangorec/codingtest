<?php

namespace App\Coin;

class TwentyCent implements CoinInterface
{

    /**
     * @inheritDoc
     */
    public static function value(): int
    {
        return 20;
    }
}
