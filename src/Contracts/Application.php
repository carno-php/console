<?php
/**
 * Application ops
 * User: moyo
 * Date: 2018/5/24
 * Time: 5:47 PM
 */

namespace Carno\Console\Contracts;

use Carno\Console\Boot\Waited;
use Carno\Console\Input;
use Carno\Coroutine\Context;

interface Application
{
    /**
     * @return Context
     */
    public function ctx() : Context;

    /**
     * @return string
     */
    public function name() : string;

    /**
     * @return Input
     */
    public function input() : Input;

    /**
     * @return Waited
     */
    public function starting() : Waited;

    /**
     * @return Waited
     */
    public function stopping() : Waited;
}
