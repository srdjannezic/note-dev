<?php namespace Note\Tours\Models;

use Model;
use Illuminate\Support\Str;
use Html;
/**
 * Model
 */
class Styles extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'note_tours_style';

    public $hasMany = [
        'tours' => [
            'Note\Tours\Models\Tours',
            'table' => 'note_tours_tourstyle',
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
}
