<?php
/**
 * Console bootstrap
 * User: moyo
 * Date: 12/12/2017
 * Time: 6:06 PM
 */

namespace Carno\Console;

use Carno\Console\Contracts\Bootable;
use Carno\Container\DI;

class Bootstrap
{
    /**
     * @var App
     */
    private $app = null;

    /**
     * @var string[]
     */
    private $kernel = [];

    /**
     * Bootstrap constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @return App
     */
    public function app() : App
    {
        return $this->app;
    }

    /**
     * set or booting kernel mods
     * @param string ...$mods
     */
    public function kernel(string ...$mods) : void
    {
        $mods ? $this->kernel = $mods : $this->loading(...$this->kernel);
    }

    /**
     * @param string ...$mods
     */
    public function loading(string ...$mods) : void
    {
        array_walk($mods, function (string $mod) {
            if (($com = DI::object($mod)) && $com instanceof Bootable && $com->runnable()) {
                $com->starting($this->app);
            }
        });
    }
}
