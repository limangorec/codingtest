<?php

namespace Test\Coin;

use App\Coin\FiveCent;
use App\Coin\TenCent;
use PHPUnit\Framework\TestCase;

class TwentyCentTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(20,TenCent::value());
    }
}
