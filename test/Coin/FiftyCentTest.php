<?php

namespace Test\Coin;

use App\Coin\FiftyCent;
use App\Coin\FiveCent;
use App\Coin\TenCent;
use PHPUnit\Framework\TestCase;

class FiftyCentTest extends TestCase
{
    public function testValue()
    {
        $this->assertEquals(20,FiftyCent::value());
    }
}
