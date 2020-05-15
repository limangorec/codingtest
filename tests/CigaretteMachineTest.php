<?php

namespace Tests;

use App\Machine\CigaretteMachine;
use App\Machine\CigaretteMachineService;
use PHPUnit\Framework\TestCase;

class CigaretteMachineServiceTest extends TestCase
{
    /**
     * @var CigaretteMachineService
     */
    protected $cigaretteMachineService;

    /**
     *
     */
    public function setUp()
    {
        $this->cigaretteMachineService = new CigaretteMachineService(new CigaretteMachine());
        parent::setUp();
    }

    /**
     *
     */
    public function testBuyOneWithExactPrice()
    {
        $purchase = $this->cigaretteMachineService->buy(1, CigaretteMachine::ITEM_PRICE);
        $this->assertEquals(1, $purchase->getItemQuantity());
        $this->assertTrue(round($purchase->getTotalLeft(),0) == 0);
        $this->assertEquals([], $purchase->getChange());
    }

    /**
     *
     */
    public function testBuyTwoWithExactPrice()
    {
        $purchase = $this->cigaretteMachineService->buy(2, CigaretteMachine::ITEM_PRICE * 2);
        $this->assertEquals(2, $purchase->getItemQuantity());
        $this->assertTrue(round($purchase->getTotalLeft(),0) == 0);
        $this->assertEquals([], $purchase->getChange());
    }

    /**
     *
     */
    public function testBuyOneWithTenEuros()
    {
        $purchase = $this->cigaretteMachineService->buy(1, 10);
        $this->assertEquals(1, $purchase->getItemQuantity());
        $this->assertTrue(round($purchase->getTotalLeft(),2) == 5.01);
        $this->assertEquals([
            '2' => 2,
            '0.01' => 1,
            '1' => 1
        ], $purchase->getChange());
    }

    /**
     *
     */
    public function testBuyTwoWithTenEuros()
    {
        $purchase = $this->cigaretteMachineService->buy(2, 10);
        $this->assertEquals(2, $purchase->getItemQuantity());
        $this->assertTrue(round($purchase->getTotalLeft(),2) == 0.02);
        $this->assertEquals([
            '0.02' => 1
        ], $purchase->getChange());
    }

    /**
     *
     */
    public function testBuyOneWithInsufficientMoney()
    {
        $purchase = $this->cigaretteMachineService->buy(1, 3);
        $this->assertEquals(0, $purchase->getItemQuantity());
        $this->assertTrue(round($purchase->getTotalLeft(),2) == 3);
        $this->assertEquals([
            '2' => 1,
            '1' => 1
        ], $purchase->getChange());
    }

    /**
     *
     */
    public function testBuy1000WithInsufficientMoney()
    {
        $purchase = $this->cigaretteMachineService->buy(1000, 4);
        $this->assertEquals(0, $purchase->getItemQuantity());
        $this->assertTrue(round($purchase->getTotalLeft(),2) == 4);
        $this->assertEquals([
            '2' => 2,
        ], $purchase->getChange());
    }

    /**
     *
     */
    public function testBuy3ButWithMoneyJustFor2()
    {
        $purchase = $this->cigaretteMachineService->buy(3, 10);
        $this->assertEquals(2, $purchase->getItemQuantity());
        $this->assertTrue(round($purchase->getTotalLeft(),2) == 0.02);
        $this->assertEquals([
            '0.02' => 1
        ], $purchase->getChange());
    }
}
