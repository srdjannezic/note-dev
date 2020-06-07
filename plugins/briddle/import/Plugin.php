<?php namespace Briddle\Import;

use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Backend;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name' => 'Import',
            'description' => 'Upload your custom plugins and themes',
            'author' => 'Briddle',
            'icon' => 'icon-upload'
        ];
    }    
    
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Import',
                'description' => 'Upload your custom plugins and themes',
                'category'    => SettingsManager::CATEGORY_SYSTEM,
                'icon'        => 'icon-upload',
                'url'         => Backend::url('briddle/import/upload'),
                'order'       => 500,
                'keywords'    => 'import',
                'permissions' => ['briddle.export.import']
            ]
        ];
    }
}
