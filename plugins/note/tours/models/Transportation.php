<?php namespace Note\Tours\Models;

use Model;

/**
 * Model
 */
class Transportation extends Model
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
    public $table = 'note_tours_transportation';


    public $hasMany = [
        'tours' => [
            'Note\Tours\Models\Tours',
            'table' => 'note_tours_tourtransportation',
        ]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
