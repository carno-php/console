<?php
/**
 * Bootstrap load kit
 * User: moyo
 * Date: 2018-11-25
 * Time: 20:31
 */

namespace Carno\Console\Chips;

use Carno\Console\Component;
use Carno\Console\Contracts\Application;
use Carno\Console\Contracts\Bootable;

trait LDKit
{
    /**
     * @param Application $app
     * @param Bootable ...$mods
     */
    protected function booting(Application $app, Bootable ...$mods) : void
    {
        /**
         * @var Component $mod
         */

        foreach ($mods as $idx => $mod) {
            $mod->ordered($idx);
        }

        uasort($mods, static function (Bootable $com1, Bootable $com2) {
            return $com1->priority() <=> $com2->priority();
        });

        foreach ($mods as $idx => $com) {
            if ($com->runnable()) {
                $com->starting($app);
                logger('console')->debug('Component starting', ['p' => $com->priority(), 'com' => get_class($com)]);
            } else {
                logger('console')->debug('Component non-runnable', ['p' => $com->priority(), 'com' => get_class($com)]);
            }
        }
    }
}
