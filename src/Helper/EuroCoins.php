<?php

namespace App\Helper;

/**
 * Class EuroCoins
 *
 * @package App\Machine
 */
abstract class EuroCoins
{
    /**
     * @return int[]
     */
    public static function getCurrentValidEuroCoins()
    {
        return [
            200, 100, 50, 20, 10, 5, 2, 1
        ];
    }
}
