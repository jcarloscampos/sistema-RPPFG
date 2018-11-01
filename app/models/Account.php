<?php
namespace AppPHP\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model{

    /**
     * @type object Account
     */
    protected $table = 'account';

    /**
     * @type array
     */
    protected $fillable =  ['username', 'password', 'state'];

}
