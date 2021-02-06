<?php

namespace App\Helper;

use Symfony\Component\Console\Helper\Table;

/**
 * Class EuroCoinRenderer
 *
 * @package App\Renderer
 */
class EuroCoinTable extends Table
{
    const COIN_TITLE = 'Coin';
    const COUNT_TITLE = 'Count';

    /**
     * @param array $change
     */
    public function renderCoinsTable($change)
    {
        $this->setHeaders(array(self::COIN_TITLE, self::COUNT_TITLE));

        $rows = [];
        foreach ($change as $coin => $count) {
            $rows[] = [(string) $coin / 100, $count];
        }

        $this->setRows($rows);

        parent::render();
    }
}
