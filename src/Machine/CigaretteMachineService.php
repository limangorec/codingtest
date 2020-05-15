<?php


namespace App\Machine;


class CigaretteMachineService
{
    /**
     * @var CigaretteMachine
     */
    protected $cigaretteMachine;

    /**
     * @param CigaretteMachine $cigaretteMachine
     */
    public function __construct(CigaretteMachine $cigaretteMachine)
    {
        $this->cigaretteMachine = $cigaretteMachine;
    }

    /**
     * @param $packages
     * @param $money
     * @return CigarettePurchased|PurchasedInterface
     */
    public function buy($packages, $money)
    {
        $transaction = $this->buildTransaction($packages, $money);
        return $this->cigaretteMachine->execute($transaction);
    }

    /**
     * @param $packagesCount
     * @param $amount
     * @return CigarettePurchaseTransaction
     */
    protected function buildTransaction($packagesCount, $amount)
    {
        return new CigarettePurchaseTransaction($packagesCount, $amount);
    }
}