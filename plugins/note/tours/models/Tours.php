<?php namespace Note\Tours\Models;

use Model;
use Illuminate\Support\Str;
use Html;
/**
 * Model
 */
class Tours extends Model
{
    use \October\Rain\Database\Traits\Validation;
	use \October\Rain\Database\Traits\Sortable;
	use \October\Rain\Database\Traits\NestedTree;
        /**
     * @var string The database table used by the model.
     */
    public $table = 'note_tours_';

    public $jsonable = array('highlights','other_images','group_type','bokun_points','bokun_start_ids','bokun_pricing_id');

    public $belongsToMany = [ 
        'type' => [
            'Note\Tours\Models\Types',
            'table' => 'note_tours_tourtype',
            'key' => 'tour_id',
            'otherKey' => 'type_id',
        ],
        'style' => [
            'Note\Tours\Models\Styles',
            'table' => 'note_tours_tourstyle',
            'key' => 'tour_id',
            'otherKey' => 'style_id',
        ],
        'destinations' => [
            'Note\Tours\Models\Destinations',
            'table' => 'note_tours_tourdestinations',
            'key' => 'tour_id',
            'otherKey' => 'destination_id',
        ],
        'transportation' => [
            'Note\Tours\Models\Transportation',
            'table' => 'note_tours_tourtransportation',
            'key' => 'tour_id',
            'otherKey' => 'transportation_id',
        ]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function beforeSave()
    {
        $this->name = Html::strip($this->title);
        $this->slug = Str::slug($this->name);
    }

    public function checkIsTourExisting($name){
        return $this->where('name',$name)->first();
    }
}
