<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
     /**
     * @type object Career
     */
    protected $table = 'career';

    /**
     * @type array
     */
    protected $fillable =  [
        'name'
    ];
}
