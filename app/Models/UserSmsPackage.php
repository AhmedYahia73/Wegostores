<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSmsPackage extends Model
{
    protected $fillable = [
        'name',
        'msg_number', 
        'back_link',
        'from',
        'to',
    ];
}
