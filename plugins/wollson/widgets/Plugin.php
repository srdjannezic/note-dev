<?php namespace Wollson\Widgets;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
    		'Wollson\Widgets\Components\WidgetComponent'       => 'widget'
    	];
    }

    public function registerSettings()
    {
    }
}
