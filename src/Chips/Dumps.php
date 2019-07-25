<?php
/**
 * Dumps (failure)
 * User: moyo
 * Date: Jul 25, 2019
 * Time: 11:06
 */

namespace Carno\Console\Chips;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

trait Dumps
{
    /**
     * @param Throwable $e
     * @param int $c
     */
    protected function failure(Throwable $e, int $c = null) : void
    {
        $styled = (new SymfonyStyle(new ArgvInput(), new ConsoleOutput()));

        $styled->title(get_class($e));
        $styled->error($e->getMessage());
        $styled->note(sprintf('%s:%d', $e->getFile(), $e->getLine()));

        dump($e);

        is_null($c) || exit($c);
    }
}
