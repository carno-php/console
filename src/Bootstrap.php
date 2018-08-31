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
    private $mods = [];

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
     * setting kernel mods
     * @param string ...$mods
     */
    public function register(string ...$mods) : void
    {
        $this->mods = array_unique(array_merge($this->mods, $mods));
    }

    /**
     * booting kernel mods
     */
    public function kernel() : void
    {
        $this->loading(...$this->mods);
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
