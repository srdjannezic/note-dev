<?php namespace Wollson\Widgets\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Regions extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Wollson.Widgets', 'main-menu-item', 'side-menu-item');
    }
}
