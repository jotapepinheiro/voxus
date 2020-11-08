<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $hidden = array('pivot');

    protected $fillable = [
        'name', 'display_name', 'description'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
