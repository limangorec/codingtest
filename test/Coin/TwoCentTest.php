<?php

namespace Test\Coin;

use App\Coin\TwoCent;
use PHPUnit\Framework\TestCase;

class TwoCentTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(2, TwoCent::value());
    }
}
