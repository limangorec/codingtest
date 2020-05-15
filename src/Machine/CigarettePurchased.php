<?php


namespace App\Machine;


/**
 * Class CigarettePurchased
 * @package App\Machine
 */
class CigarettePurchased implements PurchasedInterface
{
    /**
     * @var float
     */
    protected $totalAmount;
    /**
     * @var float
     */
    protected $totalLeft;
    /**
     * @var int
     */
    protected $itemQuantity;

    /**
     * @var array
     */
    protected $change;

    /**
     * @param float $totalAmount
     * @param float $totalLeft
     * @param int $itemQuantity
     * @param array $change
     */
    public function __construct($totalAmount, $totalLeft, $itemQuantity, array $change)
    {
        $this->itemQuantity = $itemQuantity;
        $this->totalLeft = $totalLeft;
        $this->totalAmount = $totalAmount;
        $this->change = $change;
    }

    /**
     * @return int
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @return float
     */
    public function getTotalLeft()
    {
        return $this->totalLeft;
    }

    /**
     * @return array
     */
    public function getChange()
    {
        return $this->change;
    }
}
