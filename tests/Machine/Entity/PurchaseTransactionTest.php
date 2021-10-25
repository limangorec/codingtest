<?php

namespace Tests\Machine\Entity;

use App\Machine\PurchaseTransaction;
use PHPUnit\Framework\TestCase;

class PurchaseTransactionTest extends TestCase
{
    public function testPurchaseTransaction()
    {
        $purchaseTransaction = new PurchaseTransaction();
        $purchaseTransaction->setItemQuantity(2);
        $purchaseTransaction->setPaidAmount(10.02);

        $this->assertEquals(2, $purchaseTransaction->getItemQuantity());
        $this->assertEquals(10.02, $purchaseTransaction->getPaidAmount());
    }
}
