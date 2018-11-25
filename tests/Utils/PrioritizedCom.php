<?php
/**
 * Mocked component
 * User: moyo
 * Date: 2018-11-25
 * Time: 20:13
 */

namespace Carno\Console\Tests\Utils;

use Carno\Console\Component;
use Carno\Console\Contracts\Application;
use Carno\Console\Contracts\Bootable;

class PrioritizedCom extends Component implements Bootable
{
    private $named = null;

    private $writer = null;

    public function __construct(string $named, callable $writer, int $priority = null)
    {
        $this->named = $named;
        $this->writer = $writer;
        if (is_numeric($priority)) {
            $this->priority = $priority;
        }
    }

    public function name() : string
    {
        return $this->named;
    }

    public function starting(Application $app) : void
    {
        ($this->writer)($this->named);
    }
}
