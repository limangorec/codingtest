<?php

namespace Test\Coin;

use App\Coin\OneCent;
use PHPUnit\Framework\TestCase;

class OneCentTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(1, OneCent::value());
    }
}
