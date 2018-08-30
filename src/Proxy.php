<?php
/**
 * Named proxy
 * User: moyo
 * Date: 13/12/2017
 * Time: 4:10 PM
 */

namespace Carno\Console;

use Carno\Console\Chips\EVKit;
use Carno\Console\Contracts\Programme;
use Carno\Container\DI;
use function Carno\Coroutine\async;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class Proxy extends Command
{
    use EVKit;

    /**
     * @var Bootstrap
     */
    private $bootstrap = null;

    /**
     * @var string
     */
    private $target = null;

    /**
     * @var Based
     */
    private $ref = null;

    /**
     * @param string $name
     * @return static
     */
    public function setApp(string $name) : self
    {
        $this->bootstrap->app()->named($name);
        return $this;
    }

    /**
     * @param Bootstrap $bootstrap
     * @return static
     */
    public function setBootstrap(Bootstrap $bootstrap) : self
    {
        $this->bootstrap = $bootstrap;
        return $this;
    }

    /**
     * @param string $class
     * @return static
     */
    public function setCommand(string $class) : self
    {
        $this->target = $class;
        return $this;
    }

    /**
     * @return Based
     */
    public function getCommand() : Programme
    {
        return $this->ref ?? $this->ref = new $this->target;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap->app()->inputs($input);
        $this->bootstrap->kernel();

        async(function () {
            /**
             * @var Programme $command
             */
            $command = DI::object($this->target);
            yield $command->execute($this->bootstrap);
        })->catch(function (Throwable $e) {
            dump('APP EXCEPTION', $e);
            $this->exits();
        });

        $this->loops();
    }
}
