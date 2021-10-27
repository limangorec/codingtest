<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;

    const COIN_FIFTY       = 50.0;
    const COIN_TWENTY      = 20.0;
    const COIN_TEN         = 10.0;
    const COIN_FIVE        = 5.0;
    const COIN_TWO         = 2.0;
    const COIN_ONE         = 1.0;
    const COIN_CENT_FIFTY  = 0.5;
    const COIN_CENT_TWENTY = 0.2;
    const COIN_CENT_TEN    = 0.10;
    const COIN_CENT_FIVE   = 0.05;
    const COIN_CENT_TWO    = 0.02;
    const COIN_CENT_ONE    = 0.01;

    const COINS = [CigaretteMachine::COIN_FIFTY, CigaretteMachine::COIN_TWENTY, CigaretteMachine::COIN_TEN, CigaretteMachine::COIN_FIVE,
                   CigaretteMachine::COIN_TWO, CigaretteMachine::COIN_ONE, CigaretteMachine::COIN_CENT_FIFTY, CigaretteMachine::COIN_CENT_TWENTY,
                   CigaretteMachine::COIN_CENT_TEN, CigaretteMachine::COIN_CENT_FIVE, CigaretteMachine::COIN_CENT_TWO, CigaretteMachine::COIN_CENT_ONE];

    public function execute(PurchaseTransactionInterface $purchaseTransaction)
    {
        $nItemQuantity     = 0;
        $nTransactionCosts = 0;

        $nTotalAmount = $purchaseTransaction->getItemQuantity() * CigaretteMachine::ITEM_PRICE;
        if($nTransactionCosts <= $purchaseTransaction->getPaidAmount())
        {
            $nItemQuantity = $purchaseTransaction->getItemQuantity();
        }
        else
        {
            $nTotalAmount = 0; // safer to not return anything instead of nr of items the customer didn't ask for -> TODO: check with product owner
        }

        $nBalance = $purchaseTransaction->getPaidAmount() - $nTotalAmount;
        $aChange  = $this->calculateChange($nBalance);

        $cPurchasedItem = new class($nItemQuantity, $nTotalAmount, $aChange) implements PurchasedItemInterface
        {
            private $m_nItemQuantity = 0;
            private $m_nTotalAmount  = 0;
            private $m_aChange       = [];
            public function __construct($nItemQuantity, $nTotalAmount, $aChange)
            {
                $this->m_nItemQuantity = $nItemQuantity;
                $this->m_nTotalAmount  = $nTotalAmount;
                $this->m_aChange       = $aChange;
            }

            public function getItemQuantity()
            {
                return $this->m_nItemQuantity;
            }

            public function getTotalAmount()
            {
                return $this->m_nTotalAmount;
            }

            public function getChange()
            {
                return $this->m_aChange;
            }
        };

        return $cPurchasedItem;
    }

    private function calculateChange($nBalance)
    {
        $aChange = [];
        foreach(CigaretteMachine::COINS as $nCoin)
        {
            if($nCoin > 0)
            {
                $nCount = (int)number_format((float)$nBalance / $nCoin, 2, '.', '');
                if($nCount > 0)
                {
                    $nBalance = $nBalance - ($nCount * $nCoin);
                    array_push($aChange, [number_format((float)$nCoin, 2, '.', ''), $nCount]);
                }
            }
        }
        return $aChange;
    }
}