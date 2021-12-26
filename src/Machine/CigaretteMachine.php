<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    public function __construct(private ChangeCalculatorInterface $changeCalculator)
    {
    }

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $finalAmount = $purchaseTransaction->getItemQuantity() * self::ITEM_PRICE;

        if ($finalAmount > $purchaseTransaction->getPaidAmount()) {
            //custom exception
            throw  new \Exception('Not enough money');
        }

        $change = $purchaseTransaction->getPaidAmount() - $finalAmount;
        $change = $this->changeCalculator->calculate($change);

        return new PurchasedItem($purchaseTransaction->getItemQuantity(), $finalAmount, $change, self::ITEM_PRICE);
    }
}
