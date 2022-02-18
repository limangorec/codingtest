<?php

namespace Test\Coin;

use App\Coin\CoinFormatter;
use App\Coin\FiftyCent;
use App\Coin\FiveCent;
use App\Coin\OneCent;
use App\Coin\OneEuro;
use App\Coin\TenCent;
use App\Coin\TwentyCent;
use App\Coin\TwoCent;
use App\Coin\TwoEuro;
use PHPUnit\Framework\TestCase;

class CoinFormatterTest extends TestCase
{
    public function testOneCent()
    {
        $this->assertEquals('0.01', CoinFormatter::formatCoin(new OneCent()));
    }

    public function testTwoCent()
    {
        $this->assertEquals('0.02', CoinFormatter::formatCoin(new TwoCent()));
    }

    public function testFiveCent()
    {
        $this->assertEquals('0.05', CoinFormatter::formatCoin(new FiveCent()));
    }

    public function testTenCent()
    {
        $this->assertEquals('0.10', CoinFormatter::formatCoin(new TenCent()));
    }

    public function testTwentyCent()
    {
        $this->assertEquals('0.20', CoinFormatter::formatCoin(new TwentyCent()));
    }

    public function testFiftyCent()
    {
        $this->assertEquals('0.50', CoinFormatter::formatCoin(new FiftyCent()));
    }

    public function testOneEuro()
    {
        $this->assertEquals('1.00', CoinFormatter::formatCoin(new OneEuro()));
    }

    public function testTwoEuro()
    {
        $this->assertEquals('2.00', CoinFormatter::formatCoin(new TwoEuro()));
    }

}
