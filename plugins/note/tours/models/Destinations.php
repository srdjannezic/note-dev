<?php namespace Note\Tours\Models;

use Model;
use Illuminate\Support\Str;
use Html;
/**
 * Model
 */
class Destinations extends Model
{
    use \October\Rain\Database\Traits\Validation;
        /**
     * @var string The database table used by the model.
     */
    public $table = 'note_tours_destination';

    public $jsonable = array('cover_media','content');
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

    public $belongsToMany = [
        'tours' => [
            'Note\Tours\Models\Tours',
            'table' => 'note_tours_tourdestinations',
            'key' => 'tour_id',
            'otherKey' => 'tour_id',
        ]
    ];

    public function checkIsDestExisting($name){
        return $this->where('name',$name)->first();
    }
}
