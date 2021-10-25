<?php

namespace Tests\Machine\Service;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use PHPUnit\Framework\TestCase;

class CigaretteMachineTest extends TestCase
{
    public function testExecute()
    {
        $cigaretteMachine = new CigaretteMachine();

        $purchaseTransaction = new PurchaseTransaction();
        $purchaseTransaction->setItemQuantity(2);
        $purchaseTransaction->setPaidAmount(10.01);

        $cigaretteMachine->execute($purchaseTransaction);

        $this->assertIsObject($cigaretteMachine->getPurchasedItem());

        $this->assertEquals(2, $cigaretteMachine->getPurchasedItem()->getItemQuantity());
        $this->assertEquals(9.98, $cigaretteMachine->getPurchasedItem()->getTotalAmount());
        $this->assertEquals([[0.02,1],[0.01,1]], $cigaretteMachine->getPurchasedItem()->getChange());
    }
}
