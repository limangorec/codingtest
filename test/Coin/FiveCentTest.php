<?php

namespace Test\Coin;

use App\Coin\FiveCent;
use PHPUnit\Framework\TestCase;

class FiveCentTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(5,FiveCent::value());
    }
}
