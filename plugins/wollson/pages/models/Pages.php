<?php namespace Wollson\Pages\Models;

use Model;

/**
 * Model
 */
class Pages extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wollson_pages_';

    public $jsonable = array('content','gallery');

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
