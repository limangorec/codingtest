<?php

namespace App\Machine;

use App\Model\PruchasedItem;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    /**
     * Start the purchase process
     *
     * @param PurchaseTransactionInterface $purchaseTransaction
     * @return array
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $resultArray = array();
        $amountToPay = $purchaseTransaction->getItemQuantity() * self::ITEM_PRICE;
        // first check if customer paud enough
        if($amountToPay > $purchaseTransaction->getPaidAmount()){
            $resultArray = [
                'paidEnough' => false,
                'message' => 'You not paid enough. You had to pay <info>'.$amountToPay.'</info> but you only paid <info>'.$purchaseTransaction->getPaidAmount().'</info>. Please check your money and try again.',
                'changeTable' => '',
            ];
        } else {
            $purchasedItem = new PruchasedItem($purchaseTransaction, self::ITEM_PRICE);
            // get the change array to display
            $changeResult = $purchasedItem->getChange();
            $resultArray = [
                'paidEnough' => true,
                'message' => 'You bought <info>'.$purchaseTransaction->getItemQuantity().'</info> packs of cigarettes for <info>'.($purchaseTransaction->getItemQuantity() * self::ITEM_PRICE).'</info>, each for <info>'.self::ITEM_PRICE.'</info>.',
                'changeTable' => $changeResult,
            ];
        }
        return $resultArray;
    }
}
