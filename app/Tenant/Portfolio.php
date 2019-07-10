<?php

namespace App\Tenant;

class Portfolio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the tenant that owns the portfolio.
     */
    public function tenant()
    {
        return $this->belongsTo('App\Tenant');
    }

    /**
     * The users that belong to the portfolio.
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
