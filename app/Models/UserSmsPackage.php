<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSmsPackage extends Model
{
    protected $fillable = [
        'name',
        'msg_number', 
        'sms_package_id',
        'back_link',
        'from',
        'to',
    ];

    public function sms_package(){
        return $this->belongsTo(SmsPackage::class, 'sms_package_id');
    }
}
