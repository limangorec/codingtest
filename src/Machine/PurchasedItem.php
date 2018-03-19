<?php
/**
 * User: Halina Dippel
 * Date: 07.05.2018
 * Time: 19:09
 */
namespace App\Machine;

class PurchasedItem implements PurchasedItemInterface
{
    /**
     * @var int
     */
    private $itemQuantity = 0;

    /**
     * @var integer Cents
     */
    private $pricePerItem;

    /**
     * @var integer Cents
     */
    private $paidAmount;

    /**
     * @param integer $requestedItemQuantity
     * @param integer $pricePerItem Cents
     * @param integer $paidAmount Cents
     */
    public function __construct($requestedItemQuantity, $pricePerItem, $paidAmount)
    {
        $this->pricePerItem = (int) ($pricePerItem * 100);
        $this->paidAmount = (int) ($paidAmount * 100);
        $this->calculateAttainableItems($requestedItemQuantity);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalAmount()
    {
        return $this->getItemQuantity() * $this->pricePerItem / 100;
    }

    /**
     * {@inheritdoc}
     */
    public function getChange()
    {
        $changeInCents = $this->paidAmount - $this->itemQuantity * $this->pricePerItem;

        return ChangeCalculator::calculateChange($changeInCents);
    }

    /**
     * @param integer $requestedItemQuantity
     */
    private function calculateAttainableItems($requestedItemQuantity)
    {
        $credit = $this->paidAmount;
        while ($credit >= $this->pricePerItem && $requestedItemQuantity > 0) {
            $this->itemQuantity++;
            $credit -= $this->pricePerItem;
            $requestedItemQuantity--;
        }
    }
}