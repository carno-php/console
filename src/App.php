<?php
/**
 * Bootstrap app
 * User: moyo
 * Date: 12/12/2017
 * Time: 4:44 PM
 */

namespace Carno\Console;

use function Carno\Config\conf;
use Carno\Config\Config;
use Carno\Console\Boot\Waited;
use Carno\Console\Contracts\Application;
use Carno\Coroutine\Context;
use Symfony\Component\Console\Input\InputInterface;

class App implements Application
{
    /**
     * @var Context
     */
    private $ctx = null;

    /**
     * @var Input
     */
    private $input = null;

    /**
     * @var Waited
     */
    private $starting = null;

    /**
     * @var Waited
     */
    private $stopping = null;

    /**
     * @return Context
     */
    public function ctx() : Context
    {
        return $this->ctx ?? $this->ctx = new Context();
    }

    /**
     * @return Config
     */
    public function conf() : Config
    {
        return conf();
    }

    /**
     * @return string
     */
    public function name() : string
    {
        return $this->ctx()->get('APP_NAME') ?? '';
    }

    /**
     * @param string $name
     */
    public function named(string $name) : void
    {
        $this->ctx()->set('APP_NAME', $name);
    }

    /**
     * @return Input
     */
    public function input() : Input
    {
        return $this->input;
    }

    /**
     * @param InputInterface $set
     */
    public function inputs(InputInterface $set) : void
    {
        $this->input = new Input($set);
    }

    /**
     * @return Waited
     */
    public function starting() : Waited
    {
        return $this->starting ?? $this->starting = new Waited();
    }

    /**
     * @return Waited
     */
    public function stopping() : Waited
    {
        return $this->stopping ?? $this->stopping = new Waited();
    }
}
