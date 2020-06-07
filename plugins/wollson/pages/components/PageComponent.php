<?php namespace Wollson\Pages\Components;

use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Wollson\Pages\Models\Pages;

class PageComponent extends ComponentBase
{
    public $page;

    public function componentDetails()
    {
        return [
            'name'        => 'Page',
        ];
    }

    public function defineProperties()
    {
        return [
            'pageID' => [
                'title'       => 'Page ID',
                'type'        => 'string',
                'default'     => ''
            ],
        ];
    }

    public function onRun()
    {
        $pageID = $this->property('pageID');
    	$this->page = $this->page['page'] = $this->getPage($pageID);
    }


    protected function getPage($pageID){
    	$page = new Pages();
    	return $page->where('id',$pageID)->first();
    }
}