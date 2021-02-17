<?php

namespace App\Models\Customer;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CustomerGroupTranslation
 * @package App\Models\Customer
 * @version September 11, 2020, 2:59 pm UTC
 *
 * @property string $name
 * @property string $descriptions
 */
class CustomerGroupTranslation extends Model
{
    use SoftDeletes;

    public $table = 'customer_group_translations';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'descriptions'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'descriptions' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'descriptions' => 'required'
    ];

    
}
