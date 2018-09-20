<?php namespace Barrot\Laratchet\Facades;

use Illuminate\Support\Facades\Facade;

class LaratchetFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'laratchet'; }

}