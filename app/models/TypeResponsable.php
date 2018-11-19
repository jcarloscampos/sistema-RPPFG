<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class TypeResponsable extends Model
{
     /**
     * @type object Career
     */
    protected $table = 'type_resp';

    /**
     * @type array
     */
    protected $fillable = ['name'];
}
