<?php

namespace App\Formatter;

use App\Helper\EuroCoins;

/**
 * Class EuroCoinFormatter
 *
 * @package App\Formmater
 */
class EuroCoinFormatter
{
    /**
     * @param float $total
     *
     * @return array
     */
    public static function format($total)
    {
        if ($total < 0) {
            throw new \InvalidArgumentException('Cant format EuroCoin with negative values');
        }

        $coins = [];
        $totalInCents = self::convertToCents($total);

        $euroCoinsInCents = EuroCoins::getCurrentValidEuroCoins();

        foreach ($euroCoinsInCents as $euroCoin) {
            if ($totalInCents >= $euroCoin) {
                $coins[$euroCoin] = (int) floor($totalInCents / $euroCoin);
                $totalInCents -= $euroCoin * $coins[$euroCoin];
            }
        }

        return $coins;
    }

    private static function convertToCents($total)
    {
        return (int) round($total * 100);
    }
}
