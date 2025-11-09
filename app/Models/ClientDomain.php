<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDomain extends Model
{
    protected $fillable = [
        'img',
        'alt',
        'website',
        'facaebook',
        'app_status',
        'is_client',
        'ios',
        'android',
    ];
}
