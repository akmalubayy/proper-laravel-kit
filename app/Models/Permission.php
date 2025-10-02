<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'guard_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
