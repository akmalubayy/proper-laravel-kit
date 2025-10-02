<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'sitetitle',
        'siteurl',
        'homeurl',
        'sitelogo',
    ];

    protected $hidden = [];

    protected $casts  = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
