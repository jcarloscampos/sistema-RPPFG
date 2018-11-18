<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
     /**
     * @type object User
     */
    protected $table = 'administrator';

    /**
     * @type array
     */
    protected $fillable =  [     
        'name',
        'l_name',
        'ml_name',
        'ci',
        'phone',
        'email',
        'address'
    ];
}
