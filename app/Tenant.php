<?php

namespace App;

use Illuminate\Support\Facades\Cache;

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

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        $key = 'tenant.' . $value;

        return Cache::remember($key, now()->addHour(), function () use ($value) {
            return Tenant::where('slug', $value)->firstOrFail();
        });
    }

    /**
     * Get the portfolios for the tenant.
     */
    public function portfolios()
    {
        return $this->hasMany('App\Tenant\Portfolio');
    }
}
