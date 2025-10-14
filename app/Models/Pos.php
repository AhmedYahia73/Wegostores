<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    protected $fillable = [
        "front_end",
        "back_end",
        "restuarant_id",
        "status",
        "name",
    ];
}
