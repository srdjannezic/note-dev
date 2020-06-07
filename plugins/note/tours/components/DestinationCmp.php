<?php namespace Note\Tours\Components;

use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Note\Tours\Models\Tours;
use Note\Tours\Models\Destinations;

class DestinationCmp extends ComponentBase
{
    public $destination;

    protected $slug;

    public function componentDetails()
    {
        return [
            'name'        => 'Destination Single',
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Slug',
                'default'     => '{{ :slug }}',
                'type'        => 'string',
            ],
        ];
    }

    protected function setVars(){
        $this->slug = $this->property('slug');
    }

    public function onRun()
    {  
        $this->setVars();
        $this->destination = $this->page['destination'] = $this->loadDestination();
    }

    protected function loadDestination()
    {
        $slug = $this->slug;
        $destination = new Destinations;
        $destination = $destination->where('slug',$slug)->first();
        return $destination;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();

        return $backendUser && $backendUser->hasAccess('rainlab.blog.access_posts');
    }
}
