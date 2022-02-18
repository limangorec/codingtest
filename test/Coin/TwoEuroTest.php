<?php

namespace Test\Coin;

use App\Coin\TwoCent;
use PHPUnit\Framework\TestCase;

class TwoEuroTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(100, TwoCent::value());
    }
}
