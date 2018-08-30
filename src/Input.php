<?php
/**
 * Input proxy (backend to ENV|ARGV)
 * User: moyo
 * Date: 22/12/2017
 * Time: 11:58 AM
 */

namespace Carno\Console;

use Symfony\Component\Console\Input\InputInterface;

class Input
{
    /**
     * @var InputInterface
     */
    private $backend = null;

    /**
     * Input constructor.
     * @param InputInterface $input
     */
    public function __construct(InputInterface $input)
    {
        $this->backend = $input;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOption(string $name) : bool
    {
        return (false !== getenv($this->evn($name))) ? true : $this->backend->hasOption($name);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getOption(string $name)
    {
        return (false !== $got = getenv($this->evn($name))) ? $got : $this->backend->getOption($name);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->backend->$name(...$arguments);
    }

    /**
     * @return InputInterface
     */
    public function raw() : InputInterface
    {
        return $this->backend;
    }

    /**
     * @param string $avn
     * @return string
     */
    private function evn(string $avn) : string
    {
        return str_replace('-', '_', strtoupper($avn));
    }
}
