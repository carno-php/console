<?php
/**
 * Console bootstrap
 * User: moyo
 * Date: 12/12/2017
 * Time: 6:06 PM
 */

namespace Carno\Console;

use Carno\Console\Chips\LDKit;
use Carno\Console\Contracts\Bootable;
use Carno\Container\DI;

class Bootstrap
{
    use LDKit;

    /**
     * @var App
     */
    private $app = null;

    /**
     * @var string[]
     */
    private $kms = [];

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
        $this->kms = array_unique(array_merge($this->kms, $mods));
    }

    /**
     * booting kernel mods
     */
    public function kernel() : void
    {
        $this->loading(...$this->kms);
    }

    /**
     * @param string ...$mods
     */
    public function loading(string ...$mods) : void
    {
        /**
         * @var Bootable[] $boots
         */

        $boots = [];

        foreach ($mods as $mod) {
            ($com = DI::object($mod)) instanceof Bootable && $boots[] = $com;
        }

        $this->booting($this->app, ...$boots);
    }
}
