<?php namespace Wollson\Bokun\Models;

use Model;

/**
 * Model
 */
class Bokun extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'wollson_bokun_';

    protected $jsonable = ['bokun_pricing_id'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
