<?php namespace Note\Tours\Components;
require $_SERVER['DOCUMENT_ROOT'] . '/PayPal-PHP-SDK-master/vendor/autoload.php';

use BackendAuth;
use Db;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Note\Tours\Models\Tours;
use Note\Tours\Models\Destinations;
use Note\Tours\Models\Types;

class TourCmp extends ComponentBase
{
    public $tour;
    protected $slug;

    public function componentDetails()
    {
        return [
            'name'        => 'Tour Single',
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

    public function onRun()
    {  
        if( $this->property('slug') ) {
            $this->slug = $this->property('slug');
        }
        $this->tour = $this->page['tour'] = $this->loadTour();
    }

    protected function loadTour()
    {
        $tour = new Tours;     
        $tour = $tour->where('slug',$this->slug)->first();  
        $this->page['starts'] = $tour['bokun_start_ids'];
        $this->page['bokun_pricing_id'] = json_decode($tour['bokun_pricing_id']);
        return $tour;
    }

    protected function checkEditor()
    {
        $backendUser = BackendAuth::getUser();

        return $backendUser && $backendUser->hasAccess('rainlab.blog.access_posts');
    }
}
