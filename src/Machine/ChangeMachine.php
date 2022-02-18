<?php

namespace App\Machine;

use App\Coin\CoinInterface;
use App\Coin\FiftyCent;
use App\Coin\FiveCent;
use App\Coin\OneCent;
use App\Coin\OneEuro;
use App\Coin\TenCent;
use App\Coin\TwentyCent;
use App\Coin\TwoCent;
use App\Coin\TwoEuro;

class ChangeMachine
{
    /**
     * @return array<CoinInterface>
     */
    public function getChange(int $amountInCent) : array
    {
        $coins = [];
        while($amountInCent !== 0) {
            $coin = $this->getCoinWithHighestValuePossible($amountInCent);
            $amountInCent -= $coin::value();
            $coins[] = $coin;
        }
        return $coins;
    }

    private function getCoinWithHighestValuePossible(int $amount) : CoinInterface
    {
        if($amount >= 200) {
            return new TwoEuro();
        } else if ($amount >= 100) {
            return new OneEuro();
        } else if($amount >= 50) {
            return  new FiftyCent();
        } else if ($amount >= 20) {
            return new TwentyCent();
        } else if ($amount >= 10) {
            return new TenCent();
        } else if ($amount >=  5) {
            return new FiveCent();
        } else if ($amount >= 2) {
            return new TwoCent();
        }

        return new OneCent();
    }
}
