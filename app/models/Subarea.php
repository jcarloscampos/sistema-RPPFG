<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    /**
     * @type object subarea
     */
    protected $table = 'subarea';
    protected $fillable = [
        'name_subarea',
        'desc_subarea',
        'id_area',
        'activo'
    ];
}
