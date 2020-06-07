<?php namespace Note\Faq\Components;

use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Note\Faq\Models\FAQ;

class FaqComponent extends ComponentBase
{
    public $faq;

    public function componentDetails()
    {
        return [
            'name'        => 'Faq list',
        ];
    }

    public function onRun()
    {
    	$this->faq = $this->page['faq'] = $this->getFaq();
    }


    protected function getFaq(){
    	$faq = new FAQ();
    	return $faq->get();
    }
}