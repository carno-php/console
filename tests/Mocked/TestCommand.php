<?php
/**
 * Test Command
 * User: moyo
 * Date: Jul 25, 2019
 * Time: 10:35
 */

namespace Carno\Console\Tests\Mocked;

use Carno\Console\Based;
use Carno\Console\Contracts\Application;

class TestCommand extends Based
{
    public const NAME = 'cmd:test';
    public const DESC = 'just test';

    protected $name = self::NAME;

    protected $description = self::DESC;

    protected function firing(Application $app)
    {
        return 'hello';
    }
}
