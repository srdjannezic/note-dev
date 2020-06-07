<?php namespace Wollson\Bokun;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
    		'Wollson\Bokun\Components\BokunCmp'       => 'bokun',
    		'Wollson\Bokun\Components\BikeRental'       => 'BikeRentalForm',
    	];
    }

    public function registerSettings()
    {
    }
}
