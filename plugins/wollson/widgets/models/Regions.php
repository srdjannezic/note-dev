<?php namespace Wollson\Widgets\Models;

use Model;

/**
 * Model
 */
class Regions extends Model
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
    public $table = 'wollson_widgets_regions';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
