<?php namespace Note\Tours\Models;

use Model;
use Illuminate\Support\Str;
use Html;
/**
 * Model
 */
class Types extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'note_tours_type';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        'type' => [
            'Note\Tours\Models\Tours',
            'table' => 'note_tours_tourtype',
            'key' => 'tour_id',
            'otherKey' => 'tour_id',
        ]
    ];

    public function beforeSave()
    {
        $this->name = Html::strip($this->title);
        $this->slug = Str::slug($this->name);
    }
}
