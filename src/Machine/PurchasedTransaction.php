<?php
/**
 * User: Halina Dippel
 * Date: 07.05.2018
 * Time: 19:10
 */
namespace App\Machine;

class PurchasedTransaction implements PurchaseTransactionInterface
{
    /**
     * @var int
     */
    private $requestedItemCount;

    /**
     * @var integer Cents
     */
    private $amount;

    /**
     * @param integer $requestedItemCount
     * @param float   $paidAmount
     */
    public function __construct($requestedItemCount, $paidAmount)
    {
        $this->requestedItemCount = $requestedItemCount;
        $this->amount = (int) ($paidAmount * 100);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemQuantity()
    {
        return $this->requestedItemCount;
    }

    /**
     * {@inheritdoc}
     */
    public function getPaidAmount()
    {
        return $this->amount / 100;
    }
}