<?php
/**
 * Command kit
 * User: moyo
 * Date: 13/12/2017
 * Time: 4:04 PM
 */

namespace Carno\Console\Chips;

use Carno\Console\Configure;
use Carno\Console\Proxy;
use ReflectionClass;

trait CMDKit
{
    /**
     * @param Proxy $cmd
     * @param string $class
     * @param array $names
     * @return Proxy
     */
    protected function setCommandPTS(Proxy $cmd, string $class, array $names) : Proxy
    {
        $pts = $this->getCommandPTS($class, $names);

        foreach ($pts as $name => $value) {
            $setter = sprintf('set%s', ucfirst($name));
            if (method_exists($cmd, $setter)) {
                $cmd->$setter($value);
            }
        }

        if (method_exists($cmd->getCommand(), 'configure')) {
            call_user_func_array([$cmd->getCommand(), 'configure'], [new Configure($cmd)]);
        }

        return $cmd;
    }

    /**
     * @param string $class
     * @param array $pts
     * @return array
     */
    private function getCommandPTS(string $class, array $pts) : array
    {
        $defaults = (new ReflectionClass($class))->getDefaultProperties();

        $values = [];

        foreach ($pts as $name) {
            isset($defaults[$name]) && $values[$name] = $defaults[$name];
        }

        return $values;
    }
}
