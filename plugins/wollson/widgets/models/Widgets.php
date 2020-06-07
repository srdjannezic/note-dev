<?php namespace Wollson\Widgets\Models;

use Model;

/**
 * Model
 */
class Widgets extends Model
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
    public $table = 'wollson_widgets_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = array('blocks');

    public $belongsTo = [
        'region' => [
            'Wollson\Widgets\Models\Regions',
            'table' => 'wollson_widgets_regions',
            'order' => 'name',
            'key'=>'region_id'
        ]
    ];
}
