<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Workload extends Model
{
    protected $table = 'workload';

    protected $fillable =  ['name_wl'];
}
