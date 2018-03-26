<?php

namespace Bantenprov\Sktm\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Sktm facade.
 *
 * @package Bantenprov\Sktm
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class SktmFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sktm';
    }
}
