<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'months',
        'price',
        'discount',
        'msg_number',
        'discount_type',
        'status',
    ];
}
