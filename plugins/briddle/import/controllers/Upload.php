<?php namespace Briddle\Import\Controllers;

use BackendMenu;
use System\Classes\SettingsManager;
use Request;
use Input;
use File;
use ZipArchive;
use October\Rain\Support\Facades\Flash;
use Lang;

class Upload extends \Backend\Classes\Controller {

    public $requiredPermissions = [
        'Import' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Briddle.Import', 'settings');
        $this->pageTitle = 'Upload';
    }
    
    public function index()    
    {
        if (Input::hasFile('plugin')) 
        {
            if (Input::file('plugin')->isValid()) 
            {
                $name = Input::file('plugin')->getClientOriginalName();
                $extension = Input::file('plugin')->getClientOriginalExtension();
                
                // Only allow .zip archives
                if($extension=='zip')
                {
                    // Move the uploaded .zip archive
                    $moved = Input::file('plugin')->move('plugins/',$name);
                    
                    // Unzip the uploaded .zip archive
                    $zip = new ZipArchive;
                    $res = $zip->open('plugins/' . $name);
                    if ($res === TRUE) 
                    {
                        $zip->extractTo('plugins/');
                        $zip->close();

                        // Delete the uploaded .zip archive?
                        File::delete('plugins/' . $name);
                        
                        Flash::success(Lang::get('briddle.import::lang.plugin.success'));
                        
                        // Running migrations is handled automagically. October executes the update process automatically when any of the following occurs:
                        // 1) When an administrator signs in to the back-end.
                        // 2) When the system is updated using the update feature in the back-end area.
                        // 3) When the console command php artisan october:up is called in the command line from the application directory.
                    } 
                    else
                    {
                        Flash::error(Lang::get('briddle.import::lang.plugin.error'));
                    }
                }
                else
                {
                    Flash::error(Lang::get('briddle.import::lang.plugin.invalid'));
                }
            }
            else
            {
                Flash::error(Lang::get('briddle.import::lang.plugin.empty'));
            }
        }   
        else if (Input::hasFile('theme')) 
        {
            if (Input::file('theme')->isValid()) 
            {
                $name = Input::file('theme')->getClientOriginalName();
                $extension = Input::file('theme')->getClientOriginalExtension();
                
                // Only allow .zip archives
                if($extension=='zip')
                {
                    // Move the uploaded .zip archive
                    Input::file('theme')->move('themes/',$name);
                    
                    // Unzip the uploaded .zip archive
                    $zip = new ZipArchive;
                    $res = $zip->open('themes/' . $name);
                    if ($res === TRUE) 
                    {
                        $zip->extractTo('themes/');
                        $zip->close();
                        
                        // Delete the uploaded .zip archive?
                        File::delete('themes/' . $name);
                        
                        Flash::success(Lang::get('briddle.import::lang.plugin.success'));
                    } 
                    else
                    {
                        Flash::error(Lang::get('briddle.import::lang.plugin.error'));
                    }
                }
                else
                {
                    Flash::error(Lang::get('briddle.import::lang.plugin.invalid'));
                }
            }
            else
            {
                Flash::error(Lang::get('briddle.import::lang.plugin.empty'));
            }
        } 
    }
}