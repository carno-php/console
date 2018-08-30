<?php
/**
 * Based configure
 *
 * User: moyo
 * Date: 2018/5/24
 * Time: 10:24 PM
 */

namespace Carno\Console\Chips\Based;

use Carno\Console\Configure;

trait Configured
{
    /**
     * @param Configure $conf
     */
    final public function configure(Configure $conf) : void
    {
        // invoking all options[xx]
        foreach (get_class_methods($this) as $method) {
            if (substr($method, 0, 7) === 'options') {
                $this->$method($conf);
            }
        }
    }
}
