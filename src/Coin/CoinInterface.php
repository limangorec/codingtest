<?php

namespace App\Coin;

interface CoinInterface
{
    /**
     * @return int the value of the coin in Euro cents
     */
    public static function value() : int;
}
