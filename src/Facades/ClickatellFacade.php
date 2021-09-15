<?php
namespace DonwelSystems\Clickatell\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * Class ClickatellFacade
 * @package DonwelSystems\Clickatell
 */

class ClickatellFacade  extends  Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'clickatell';
    }
}