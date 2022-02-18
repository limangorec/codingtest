<?php

namespace Test\Machine;

use App\Machine\ChangeMachine;
use App\Machine\CigaretteMachine;
use App\Machine\InsufficientCreditException;
use App\Machine\PurchasedItemInterface;
use App\Machine\PurchaseTransaction;
use PHPUnit\Framework\TestCase;

class CigaretteMachineTest extends TestCase
{
    public function testExecutesThrowsInsufficientCreditExceptionIfPaidAmountIsLessThanTheTotalCost()
    {
        $this->expectException(InsufficientCreditException::class);
        $transaction = new PurchaseTransaction(3,6);
        $machine = new CigaretteMachine(new ChangeMachine());
        $machine->execute($transaction);
    }

    public function testExecuteReturnsAnPurchasedItemInterfaceIfPaidAmountIsGreaterThanTheTotalCost()
    {
        $this->expectException(InsufficientCreditException::class);
        $transaction = new PurchaseTransaction(1,5);
        $machine = new CigaretteMachine(new ChangeMachine());
        $this->assertInstanceOf(PurchasedItemInterface::class, $machine->execute($transaction));
    }



}
