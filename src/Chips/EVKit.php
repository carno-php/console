<?php
/**
 * Event kit
 * User: moyo
 * Date: 30/03/2018
 * Time: 10:25 AM
 */

namespace Carno\Console\Chips;

trait EVKit
{
    /**
     */
    protected function loops() : void
    {
        extension_loaded('swoole') && swoole_event_wait();
    }

    /**
     */
    protected function exits() : void
    {
        extension_loaded('swoole') && swoole_event_exit();
    }
}
