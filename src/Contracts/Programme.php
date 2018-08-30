<?php
/**
 * Programme based
 * User: moyo
 * Date: 2018/5/24
 * Time: 11:22 PM
 */

namespace Carno\Console\Contracts;

use Carno\Console\Bootstrap;
use Carno\Console\Configure;

interface Programme
{
    /**
     * @param Configure $conf
     */
    public function configure(Configure $conf) : void;

    /**
     * @param Bootstrap $boot
     * @return mixed
     */
    public function execute(Bootstrap $boot);
}
