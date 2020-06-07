<?php namespace Note\Faq;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return ['Note\Faq\Components\FaqComponent'       => 'FaqList'];
    }

    public function registerSettings()
    {
    }
}
