<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'url',
        'icon',
        'order',
        'is_parent',
        'has_child',
        'parent_id',
        'is_active'
    ];

    protected $guarded = ['id'];

    protected $hidden = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_role');
    }
}
