<?php

namespace Test\Machine;

use App\Coin\FiftyCent;
use App\Coin\FiveCent;
use App\Coin\OneCent;
use App\Coin\OneEuro;
use App\Coin\TwoCent;
use App\Coin\TwoEuro;
use App\Machine\ChangeMachine;
use PHPUnit\Framework\TestCase;

class ChangeMachineTest extends TestCase
{
    public function testGetChangeReturnsAnArrayOfCoins()
    {
        $machine = new ChangeMachine();

        $change = $machine->getChange(103);
        $this->assertInstanceOf(OneEuro::class, $change[0]);
        $this->assertInstanceOf(TwoCent::class, $change[1]);
        $this->assertInstanceOf(OneCent::class, $change[2]);


        $change = $machine->getChange(457);
        $this->assertInstanceOf(TwoEuro::class, $change[0]);
        $this->assertInstanceOf(TwoEuro::class, $change[1]);
        $this->assertInstanceOf(FiftyCent::class, $change[2]);
        $this->assertInstanceOf(FiveCent::class, $change[3]);
        $this->assertInstanceOf(TwoCent::class, $change[4]);
    }



}
