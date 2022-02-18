<?php

namespace Test\Coin;

use App\Coin\FiveCent;
use App\Coin\TenCent;
use PHPUnit\Framework\TestCase;

class TenCentTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(10,TenCent::value());
    }
}
