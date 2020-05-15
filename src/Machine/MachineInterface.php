<?php

namespace App\Machine;

/**
 * Interface CigaretteMachine
 * @package App\Machine
 */
interface MachineInterface
{
    /**
     * @param PurchaseTransactionInterface $purchaseTransaction
     *
     * @return PurchasedInterface
     */
    public function execute(PurchaseTransactionInterface $purchaseTransaction);
}