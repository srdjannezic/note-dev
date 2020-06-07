<?php namespace Wollson\Widgets\Components;

use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Wollson\Widgets\Models\Widgets;

class WidgetComponent extends ComponentBase
{
    /**
     * @var RainLab\Blog\Models\Widgets The widgets model used for display.
     */
    public $widgets;

    public function componentDetails()
    {
        return [
            'name'        => 'Widgets',
        ];
    }

    public function defineProperties()
    {
        return [
            'regionFilter' => [
                'title'       => 'Region',
                'type'        => 'string',
                'default'     => ''
            ],
        ];
    }

    public function onRun()
    {
        $region_id = $this->property('regionFilter');
        $this->widgets = $this->page['widgets'] = $this->getWidget($region_id);
    }


    protected function getWidget($region_id){
        $widget = new Widgets();
        return $widget->where('region_id',$region_id)->get();
    }

    public function getInstagram(){
        ini_set("allow_url_fopen", 1);
        // use this instagram access token generator http://instagram.pixelunion.net/
        $access_token="1977623329.1677ed0.5d01aa8fd79849f28e702335f57fb858";
        $photo_count=9;
             
        $json_link="https://api.instagram.com/v1/users/self/media/recent/?";
        $json_link.="access_token={$access_token}&count={$photo_count}";
        $json = file_get_contents($json_link);
        $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
        return $obj;
    }
}