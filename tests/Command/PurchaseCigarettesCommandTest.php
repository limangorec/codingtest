<?php

namespace Tests\Command;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use PHPUnit\Framework\TestCase;

class PurchaseCigarettesCommandTest extends TestCase
{
    public function testPurchaseCigarettes()
    {
        $purchaseTransaction = new PurchaseTransaction();
        $purchaseTransaction->setItemQuantity(2);
        $purchaseTransaction->setPaidAmount(9.95);

        $cigaretteMachine = new CigaretteMachine();
        $cigaretteMachine->execute($purchaseTransaction);

        $this->assertIsObject($cigaretteMachine->getPurchasedItem());

        $this->assertIsFloat($cigaretteMachine->getPurchasedItem()->getTotalAmount());
        $this->assertIsInt($cigaretteMachine->getPurchasedItem()->getItemQuantity());
        $this->assertIsArray($cigaretteMachine->getPurchasedItem()->getChange());

        $this->assertEquals(2, $cigaretteMachine->getPurchasedItem()->getItemQuantity());
        $this->assertEquals(9.98, $cigaretteMachine->getPurchasedItem()->getTotalAmount());

        $testChangeValue = [
            [2,4],
            [1,1],
            [0.5,1],
            [0.2,2],
            [0.05,1]
        ];

        $this->assertEquals($testChangeValue, $cigaretteMachine->getPurchasedItem()->getChange());
    }
}
