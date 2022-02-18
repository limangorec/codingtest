<?php

namespace App\Machine;

use Throwable;

class InsufficientCreditException extends \Exception
{
    private $missingAmount;

    public function __construct(float $missingAmount)
    {
        $this->missingAmount = $missingAmount;
        $message = sprintf('You have an insufficient credit. You are missing %s€',number_format($missingAmount,2));
        parent::__construct($message);
    }
}
