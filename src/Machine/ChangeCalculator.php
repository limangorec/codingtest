<?php
/**
 * User: Halina Dippel
 * Date: 07.05.2018
 * Time: 19:31
 */
namespace App\Machine;

class ChangeCalculator
{
    /**
     * @var array
     */
    private static $changeUnits = [
        '2000',
        '1000',
        '500',
        '200',
        '100',
        '50',
        '20',
        '10',
        '5',
        '2',
        '1',
    ];

    /**
     * @param integer $amount Cents
     *
     * @return array
     */
    public static function calculateChange($amount)
    {
        $change = [];
        foreach (static::$changeUnits as $changeUnit) {
            if (0 >= $amount) {
                $change[static::renderUnit($changeUnit)] = 0;
                continue;
            }
            $changeUnitCount = (int) ($amount / $changeUnit);
            $change[static::renderUnit($changeUnit)] = $changeUnitCount;
            $amount = $amount - $changeUnitCount * $changeUnit;
        }

        return $change;
    }

    /**
     * @param integer $changeUnit Cents
     *
     * @return string float formatted to two decimals
     */
    protected static function renderUnit($changeUnit)
    {
        return number_format((float) ($changeUnit / 100), 2, '.', '');
    }
}