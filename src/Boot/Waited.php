<?php
/**
 * Bootstrap waited
 * User: moyo
 * Date: 11/10/2017
 * Time: 5:03 PM
 */

namespace Carno\Console\Boot;

use function Carno\Coroutine\all;
use Carno\Promise\Promise;
use Carno\Promise\Promised;

class Waited
{
    /**
     * @var mixed[]
     */
    private $chain = [];

    /**
     * @var Promised
     */
    private $done = null;

    /**
     * @param mixed[] $programs
     */
    public function add(...$programs) : void
    {
        $this->chain = array_merge($this->chain, $programs);
    }

    /**
     * @return Promised
     */
    public function done() : Promised
    {
        return $this->done ?? $this->done = Promise::deferred();
    }

    /**
     * @return Promised
     */
    public function perform() : Promised
    {
        return all(...$this->chain)->sync($this->done());
    }
}
