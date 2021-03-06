<?php
/**
 * Bootable chip
 * User: moyo
 * Date: 12/12/2017
 * Time: 4:41 PM
 */

namespace Carno\Console\Contracts;

interface Bootable
{
    /**
     * @return float
     */
    public function priority() : float;

    /**
     * @return bool
     */
    public function runnable() : bool;

    /**
     * @param Application $app
     */
    public function starting(Application $app) : void;
}
