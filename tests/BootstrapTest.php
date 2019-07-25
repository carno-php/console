<?php
/**
 * Bootstrap test
 * User: moyo
 * Date: 2018-11-25
 * Time: 20:16
 */

namespace Carno\Console\Tests;

use Carno\Console\App;
use Carno\Console\Chips\LDKit;
use Carno\Console\Tests\Utils\PrioritizedCom;
use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    use LDKit;

    public function testLoadingOrder()
    {
        $buffer = [];

        $writer = static function ($com) use (&$buffer) {
            $buffer[] = $com;
        };

        $mods = [
            new PrioritizedCom('c1', $writer, 70),
            new PrioritizedCom('c2', $writer, 20),
            new PrioritizedCom('c3', $writer, 20),
            new PrioritizedCom('c4', $writer),
            new PrioritizedCom('c4.1', $writer),
            new PrioritizedCom('c5', $writer, 10),
            new PrioritizedCom('c6', $writer, 70),
            new PrioritizedCom('c7', $writer, 51),
            new PrioritizedCom('c8', $writer),
        ];

        $this->booting(new App(), ...$mods);

        $this->assertEquals('c5,c2,c3,c4,c4.1,c8,c7,c1,c6', implode(',', $buffer));
    }
}
