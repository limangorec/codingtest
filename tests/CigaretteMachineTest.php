<?php

use App\Machine\CigaretteMachine;
use App\Machine\PurchasedCigarettePack;
use App\Machine\PurchaseTransaction;
use PHPUnit\Framework\TestCase;

final class CigaretteMachineTest extends TestCase
{
    public function testCigaretteMachineInit()
    {
        $machine = new CigaretteMachine();

        $this->assertInstanceOf(
            CigaretteMachine::class,
            $machine
        );
    }

    public function testCigaretteMachineCalls()
    {
        $machine = new CigaretteMachine();

        $transaction = $this->getMockBuilder(PurchaseTransaction::class)
            ->setMethods(['getPaidAmount', 'getItemQuantity'])
            ->getMock();

        $transaction->expects($this->once())
            ->method('getPaidAmount');

        $transaction->expects($this->once())
            ->method('getItemQuantity');

        $machine->execute($transaction);
    }

    public function testCigaretteMachineCorrectResult()
    {
        $machine = new CigaretteMachine();

        $transaction = new PurchaseTransaction();
        $transaction->setItemQuantity(2);
        $transaction->setPaidAmount(10);

        $purchased = $machine->execute($transaction);
        $this->assertInstanceOf(
            PurchasedCigarettePack::class,
            $purchased
        );
        $this->assertEquals(2, $purchased->getItemQuantity());
        $this->assertEquals(9.98, $purchased->getTotalAmount());
        $this->assertArraySubset([[0.02, 1]], $purchased->getChange());
    }

    public function testCigaretteMachineIncorrectResult()
    {
        $this->expectException(Exception::class);
        $machine = new CigaretteMachine();

        $transaction = new PurchaseTransaction();
        $transaction->setItemQuantity(2);
        $transaction->setPaidAmount(5);

        $purchased = $machine->execute($transaction);
        $this->assertInstanceOf(
            PurchasedCigarettePack::class,
            $purchased
        );
        $this->assertEquals(2, $purchased->getItemQuantity());
        $this->assertEquals(9.98, $purchased->getTotalAmount());
        $purchased->getChange();
    }
}
