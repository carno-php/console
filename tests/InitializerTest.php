<?php
/**
 * Initializer Test
 * User: moyo
 * Date: Jul 25, 2019
 * Time: 10:37
 */

namespace Carno\Console\Tests;

use Carno\Console\Initializer;
use Carno\Console\Tests\Mocked\TestCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class InitializerTest extends TestCase
{
    public function testCommand()
    {
        ($init = new Initializer())
            ->components()
            ->commands(TestCommand::class)
        ;

        $px = $init->proxy(TestCommand::NAME);

        $this->assertEquals(TestCommand::class, get_class($px->getCommand()));

        $this->assertEquals(TestCommand::NAME, $px->getName());
        $this->assertEquals(TestCommand::DESC, $px->getDescription());

        $this->assertEquals(0, $px->execute(new ArrayInput([]), new ConsoleOutput()));
    }
}
