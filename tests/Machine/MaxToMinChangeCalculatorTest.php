<?php

namespace Tests\Machine;

use App\Machine\MaxToMinChangeCalculator;
use PHPUnit\Framework\TestCase;

class MaxToMinChangeCalculatorTest extends TestCase
{
    private MaxToMinChangeCalculator $maxToMinChangeCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->maxToMinChangeCalculator = new MaxToMinChangeCalculator();
    }

    /** @dataProvider dataProviderForCalculate */
    public function testCalculate(float $amount, array $change): void
    {
        $result = $this->maxToMinChangeCalculator->calculate($amount);
        $this->assertEquals($change, $result);
    }

    public function dataProviderForCalculate(): array
    {
        return [
            [
                'amount' => 0.00,
                'change' => []
            ],
            [
                'amount' => 0.07,
                'change' => [['0.02', 3], ['0.01', 1]]
            ],
            [
                'amount' => 0.7,
                'change' => [['0.1', 7]]
            ],
            [
                'amount' => 0.02,
                'change' => [['0.02', 1]]
            ],
            [
                'amount' => 0.05,
                'change' => [['0.02', 2], ['0.01', 1]]
            ],
            [
                'amount' => 5.03,
                'change' => [['5', 1], ['0.02', 1], ['0.01', 1]]
            ],
            [
                'amount' => 3.03,
                'change' => [['1', 3], ['0.02', 1], ['0.01', 1]]
            ],
        ];
    }

}
