<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
     /**
     * @type object Secretary
     */
    protected $table = 'secretary';

    /**
     * @type array
     */
    protected $fillable =  ['name', 'l_name', 'ml_name', 'ci', 'phone', 'email', 'address'];
}
