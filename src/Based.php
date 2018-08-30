<?php
/**
 * Console based
 * User: moyo
 * Date: 12/12/2017
 * Time: 3:34 PM
 */

namespace Carno\Console;

use Carno\Console\Chips\Based\Configured;
use Carno\Console\Chips\Based\Properties;
use Carno\Console\Chips\Based\Runner;
use Carno\Console\Contracts\Application;
use Carno\Console\Contracts\Programme;

abstract class Based implements Programme
{
    use Properties, Configured, Runner;

    /**
     * implement your command code here
     * @param Application $app
     * @return mixed
     */
    abstract protected function firing(Application $app);
}
