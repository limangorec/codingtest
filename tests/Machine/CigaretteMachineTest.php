<?php

namespace Tests\Machine;

use App\Machine\ChangeCalculatorInterface;
use App\Machine\CigaretteMachine;
use App\Machine\Purchase;
use PHPUnit\Framework\TestCase;

class CigaretteMachineTest extends TestCase
{

    private \PHPUnit\Framework\MockObject\MockObject|ChangeCalculatorInterface $changeCalculator;
    private CigaretteMachine $cigaretteMachine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->changeCalculator = $this->createMock(ChangeCalculatorInterface::class);
        $this->cigaretteMachine = new CigaretteMachine($this->changeCalculator);
    }

    public function testNotEnoughMoney(): void
    {
        $quantity = 1000;
        $purchase = new Purchase(1000, CigaretteMachine::ITEM_PRICE * ($quantity - 10));

        $this->expectException(\Exception::class);

        $this->cigaretteMachine->execute($purchase);
    }

    public function testExecute(): void
    {
        $quantity = 2;
        $purchase = new Purchase($quantity, 10);
        $change = [['0.02', 1]];
        $this->changeCalculator->expects($this->once())
            ->method('calculate')
            ->willReturn($change)
        ;

        $result = $this->cigaretteMachine->execute($purchase);

        $this->assertEquals($change, $result->getChange());
        $this->assertEquals($quantity, $result->getItemQuantity());
        $this->assertEquals(CigaretteMachine::ITEM_PRICE * $quantity, $result->getTotalAmount());
        $this->assertEquals(CigaretteMachine::ITEM_PRICE, $result->getPrice());
    }

}
