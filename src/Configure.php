<?php
/**
 * Options configure
 * User: moyo
 * Date: 13/12/2017
 * Time: 4:29 PM
 */

namespace Carno\Console;

use Symfony\Component\Console\Command\Command;

class Configure
{
    /**
     * @var Command
     */
    private $cmd = null;

    /**
     * Configure constructor.
     * @param Command $cmd
     */
    public function __construct(Command $cmd)
    {
        $this->cmd = $cmd;
    }

    /**
     * Adds an option.
     *
     * @param string $name        The option name
     * @param string $shortcut    The shortcut (can be null)
     * @param int    $mode        The option mode: One of the InputOption::VALUE_* constants
     * @param string $description A description text
     * @param mixed  $default     The default value (must be null for InputOption::VALUE_NONE)
     *
     * @return static
     */
    public function addOption($name, $shortcut = null, $mode = null, $description = '', $default = null) : self
    {
        $this->cmd->addOption($name, $shortcut, $mode, $description, $default);
        return $this;
    }
}
