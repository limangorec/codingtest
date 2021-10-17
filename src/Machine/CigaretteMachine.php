<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;
    const MULTIPLIER_FOR_MATH_OPERATIONS_ON_FLOAT_VALUES = 100;
    const AVAILABLE_COINS_VALUES = [2,1,0.50,0.20,0.10,0.05,0.02,0.01];

    /**
     * @var PurchaseTransactionInterface
     */
    private $purchaseTransaction;

    /**
     * @var PurchasedItemInterface
     */
    private $purchasedItem;

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $this->setPurchaseTransaction($purchaseTransaction);
        $this->preparePurchasedItem();
    }

    /**
     * @return PurchasedItemInterface
     */
    public function getPurchasedItem()
    {
        return $this->purchasedItem;
    }

    /**
     * @return bool
     */
    public function isPaidAmountEnough(){
        return $this->purchaseTransaction->getPaidAmount() >= $this->purchasedItem->getTotalAmount();
    }

    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     */
    private function setPurchaseTransaction($purchaseTransaction)
    {
        $this->purchaseTransaction = $purchaseTransaction;
    }

    private function preparePurchasedItem()
    {
        $this->purchasedItem = new PurchasedItem();
        $this->purchasedItem
            ->setItemQuantity(
                $this->purchaseTransaction->getItemQuantity()
            )
            ->setTotalAmount(
                $this->prepareTotalAmount()
            )
            ->setChange(
                $this->prepareChange()
            )
        ;
    }

    /**
     * @return float
     */
    private function prepareTotalAmount()
    {
        return $this->prepareValueForMathOperations(self::ITEM_PRICE)
            * $this->purchaseTransaction->getItemQuantity()
            / self::MULTIPLIER_FOR_MATH_OPERATIONS_ON_FLOAT_VALUES;
    }

    /**
     * @param float $value
     *
     * @return int
     */
    private function prepareValueForMathOperations($value)
    {
        return (int)round(
            $value * self::MULTIPLIER_FOR_MATH_OPERATIONS_ON_FLOAT_VALUES,
            0
        );
    }

    /**
     * @return array
     */
    private function prepareChange()
    {
        $amount = $this->prepareAmountToChange();

        $changeCoins = [];
        $changeCheckAmount = 0;
        foreach (self::AVAILABLE_COINS_VALUES as $coinValue) {
            $coinValueMultiplied = $coinValue * self::MULTIPLIER_FOR_MATH_OPERATIONS_ON_FLOAT_VALUES;
            while ($changeCheckAmount + $coinValueMultiplied <= $amount) {
                $changeCoins[$coinValueMultiplied] = isset($changeCoins[$coinValueMultiplied])
                    ? ++$changeCoins[$coinValueMultiplied]
                    : 1;
                $changeCheckAmount += $coinValueMultiplied;
            }
        }

        return $this->prepareIOTableFormat($changeCoins);
    }

    /**
     * @param array $changeCoins
     * @return array
     */
    private function prepareIOTableFormat($changeCoins)
    {
        $ioTableFormat = [];
        foreach ($changeCoins as $coinValue => $coinAmount) {
            $ioTableFormat[] = [
                $coinValue/self::MULTIPLIER_FOR_MATH_OPERATIONS_ON_FLOAT_VALUES,$coinAmount
            ];
        }

        return $ioTableFormat;
    }

    /**
     * @return int
     */
    private function prepareAmountToChange()
    {
        $paidAmount = $this->prepareValueForMathOperations(
            $this->purchaseTransaction->getPaidAmount()
        );

        $totalAmount = $this->prepareValueForMathOperations(
            $this->purchasedItem->getTotalAmount()
        );

        return $this->isPaidAmountEnough()
            ? $paidAmount - $totalAmount
            : $paidAmount;
    }
}
