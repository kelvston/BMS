<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relationship to Permissions (via pivot)
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}
