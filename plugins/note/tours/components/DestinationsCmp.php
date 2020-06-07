<?php namespace Note\Tours\Components;

use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Note\Tours\Models\Tours;
use Note\Tours\Models\Destinations;

class DestinationsCmp extends ComponentBase
{
    public $destinations;


    public function componentDetails()
    {
        return [
            'name'        => 'Destinations',
        ];
    }

    // public function defineProperties()
    // {
    //     return [
    //         'ToursType' => [
    //             'title'       => 'Tours Type',
    //             'type'        => 'text',
    //         ],
    //     ];
    // }


    public function onRun()
    {
        $this->destinations = $this->page['destinations'] = $this->loadDestinations();
    }

    protected function loadDestinations()
    {
        $destinations = new Destinations;
        $destinations = $destinations->get();
        return $destinations;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();

        return $backendUser && $backendUser->hasAccess('rainlab.blog.access_posts');
    }
}
