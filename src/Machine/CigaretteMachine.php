<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    private $changeMachine;

    public function __construct(ChangeMachine $machine)
    {
        $this->changeMachine = $machine;
    }

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {

        $quantity = $purchaseTransaction->getItemQuantity();
        $totalPrice = $purchaseTransaction->getItemQuantity() * self::ITEM_PRICE;
        $paid = $purchaseTransaction->getPaidAmount();
        $amountOfChange = $paid - $totalPrice;
        if($amountOfChange < 0) {
            throw new InsufficientCreditException($amountOfChange);
        }
        $change = $this->changeMachine->getChange($this->convertFloatEuroValueToIntegerCentValue($amountOfChange));
        return new Purchase($quantity, $totalPrice, $change);
    }

    private function convertFloatEuroValueToIntegerCentValue(float $value) : int
    {
        return intval($value * 100);
    }

}
