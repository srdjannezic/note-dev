<?php namespace Wollson\Pages;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
    		'Wollson\Pages\Components\PageComponent'       => 'page'
    	];
    }

    public function registerSettings()
    {
    }
}
