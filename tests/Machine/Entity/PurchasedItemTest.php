<?php

namespace Tests\Machine\Entity;

use App\Machine\PurchasedItem;
use PHPUnit\Framework\TestCase;

class PurchasedItemTest extends TestCase
{
    public function testPurchasedItem()
    {
        $purchasedItem = new PurchasedItem();
        $purchasedItem->setItemQuantity(2);
        $purchasedItem->setTotalAmount(9.98);
        $purchasedItem->setChange([[2,1],[1,2]]);

        $this->assertEquals(2, $purchasedItem->getItemQuantity());
        $this->assertEquals(9.98, $purchasedItem->getTotalAmount());
        $this->assertEquals([[2,1],[1,2]], $purchasedItem->getChange());
    }
}
