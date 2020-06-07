<?php namespace Note\Tours;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
    		'Note\Tours\Components\ToursCmp'       => 'ToursList',
            'Note\Tours\Components\TourCmp'       => 'Tour',
    		'Note\Tours\Components\DestinationsCmp'       => 'DestinationsList',
            'Note\Tours\Components\DestinationCmp'       => 'Destination'
    	];
    }

    public function registerSettings()
    {
    }
}
