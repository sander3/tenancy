<?php

namespace App;

use App\Tenant;
use App\TenantUser;
use Illuminate\Notifications\Notifiable;
use Soved\Laravel\Magic\Auth\Traits\CanMagicallyLogin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Soved\Laravel\Magic\Auth\Contracts\CanMagicallyLogin as CanMagicallyLoginContract;

class User extends Authenticatable implements CanMagicallyLoginContract
{
    use Notifiable, CanMagicallyLogin;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'locale',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the logs for the user.
     */
    public function logs()
    {
        return $this->hasMany('App\Log');
    }

    /**
     * The tenants that belong to the user.
     */
    public function tenants()
    {
        return $this->belongsToMany('App\Tenant')
            ->using('App\TenantUser')
            ->withTimestamps();
    }

    /**
     * Determine whether the user belongs to the given tenant.
     *
     * @param  \App\Tenant  $tenant
     * @return bool
     */
    public function belongsToTenant(Tenant $tenant)
    {
        return TenantUser::query()
            ->where([
                'tenant_id' => $tenant->id,
                'user_id'   => $this->id,
            ])
            ->exists();
    }
}
