<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * The users that belong to the tenant.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')
            ->using('App\TenantUser')
            ->withTimestamps();
    }
}
