<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserData extends Authenticatable
{
    use Notifiable;

    // 1. Tell Laravel to use your specific ERD table
    protected $table = 'user_data';
    
    // 2. Tell Laravel your primary key is 'user_id', not 'id'
    protected $primaryKey = 'user_id';

    // 3. Allow mass assignment
    protected $guarded = [];

    // 4. Hide the password from arrays for security
    protected $hidden = [
        'password',
    ];
}