<?php

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use App\Command\PurchaseCigarettesCommand;
use PHPUnit\Framework\TestCase;

final class PurchaseCigarettesCommandTest extends TestCase
{
    public function testPurchaseCigarettesCommandInit()
    {
        $command = new PurchaseCigarettesCommand();

        $this->assertInstanceOf(
            PurchaseCigarettesCommand::class,
            $command
        );
    }
}
