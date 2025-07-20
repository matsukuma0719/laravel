<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RichMenu extends Model
{
    protected $fillable = [
        'title',
        'genders',
        'ages',
        'preset',
        'areas',
        'image_path'
    ];

    protected $casts = [
        'genders' => 'array',
        'ages' => 'array',
        'areas' => 'array',
    ];
}

