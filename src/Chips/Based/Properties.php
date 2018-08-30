<?php
/**
 * Based properties
 * User: moyo
 * Date: 2018/5/24
 * Time: 10:21 PM
 */

namespace Carno\Console\Chips\Based;

trait Properties
{
    /**
     * @var string
     */
    protected $app = null;

    /**
     * @var string
     */
    protected $name = 'none:default';

    /**
     * @var string
     */
    protected $help = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * user defined bootstraps
     * @var array
     */
    protected $components = [];

    /**
     * automatic to ready sta
     * @var bool
     */
    protected $ready = true;
}
