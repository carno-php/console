<?php
/**
 * Console component
 * User: moyo
 * Date: 26/03/2018
 * Time: 11:19 AM
 */

namespace Carno\Console;

use Carno\Console\Contracts\Bootable;
use Carno\Container\DI;

abstract class Component implements Bootable
{
    /**
     * @var int
     */
    protected $priority = 50;

    /**
     * @var array
     */
    protected $prerequisites = [];

    /**
     * @var array
     */
    protected $dependencies = [];

    /**
     * @return int
     */
    public function priority() : int
    {
        return $this->priority;
    }

    /**
     * @return bool
     */
    public function runnable() : bool
    {
        foreach ($this->prerequisites as $class) {
            if (!class_exists($class) && !interface_exists($class)) {
                return false;
            }
        }

        foreach ($this->dependencies as $class) {
            if (!DI::has($class)) {
                return false;
            }
        }

        return true;
    }
}
