<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    protected $table = 'subarea';
    protected $fillable = ['nomb_subarea', 'desc_subarea', 'id_area', 'activo'];
}
