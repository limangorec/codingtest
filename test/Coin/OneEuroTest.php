<?php

namespace Test\Coin;

use App\Coin\OneEuro;
use PHPUnit\Framework\TestCase;

class OneEuroTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(100, OneEuro::value());
    }
}
