<?php
/**
 * Based runner
 * User: moyo
 * Date: 2018/5/24
 * Time: 10:44 PM
 */

namespace Carno\Console\Chips\Based;

use Carno\Console\Bootstrap;
use function Carno\Coroutine\defer;
use Throwable;

trait Runner
{
    /**
     * @param Bootstrap $boot
     * @return mixed
     */
    final public function execute(Bootstrap $boot)
    {
        yield defer(function ($e = null) use ($boot) {
            if ($e instanceof Throwable) {
                logger('console')->error('Application crashed', ['ec' => get_class($e), 'em' => $e->getMessage()]);
            }
            logger('console')->info('Application going to shutdown');
            $this->ready && yield $boot->app()->stopping()->perform();
        });

        $boot->loading(...$this->components);

        $this->ready && yield $boot->app()->starting()->perform();

        logger('console')->info('Application prepared to run');

        return yield method_exists($this, 'dispatching') ? $this->dispatching($boot) : $this->firing($boot->app());
    }
}
