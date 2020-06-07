<?php namespace Note\Partners;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return ['Note\Partners\Components\PartnersComponent'       => 'PartnersList'];
    }
}
