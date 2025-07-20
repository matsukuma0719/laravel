<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineSetting extends Model
{
    protected $fillable = [
        'channel_name',
        'channel_access_token',
    ];
    public $timestamps = false;
}

