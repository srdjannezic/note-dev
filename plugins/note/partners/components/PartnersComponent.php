<?php namespace Note\Partners\Components;

use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Note\Partners\Models\Partners;

class PartnersComponent extends ComponentBase
{
    /**
     * @var RainLab\Blog\Models\Widgets The widgets model used for display.
     */
    public $partners;

    public function componentDetails()
    {
        return [
            'name'        => 'Partners List',
        ];
    }

    public function onRun(){
    	$this->partners = $this->page['partners'] = $this->getPartners();
    }


    protected function getPartners(){
    	$partners = new Partners();
    	return $partners->get();
    }
}