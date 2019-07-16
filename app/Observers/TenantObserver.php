<?php

namespace App\Observers;

use App\Tenant;
use App\Repositories\TenantRepository;

class TenantObserver
{
    /**
     * The tenant repository instance.
     */
    protected $tenants;

    /**
     * Create a new observer instance.
     *
     * @param  \App\Repositories\TenantRepository  $tenants
     * @return void
     */
    public function __construct(TenantRepository $tenants)
    {
        $this->tenants = $tenants;
    }

    /**
     * Handle the tenant "created" event.
     *
     * @param  \App\Tenant  $tenant
     * @return void
     */
    public function created(Tenant $tenant)
    {
        $this->tenants->createAndPopulateDatabase($tenant);
    }

    /**
     * Handle the tenant "updated" event.
     *
     * @param  \App\Tenant  $tenant
     * @return void
     */
    public function updated(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the tenant "deleted" event.
     *
     * @param  \App\Tenant  $tenant
     * @return void
     */
    public function deleted(Tenant $tenant)
    {
        $this->tenants->dropDatabase($tenant);
    }

    /**
     * Handle the tenant "restored" event.
     *
     * @param  \App\Tenant  $tenant
     * @return void
     */
    public function restored(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the tenant "force deleted" event.
     *
     * @param  \App\Tenant  $tenant
     * @return void
     */
    public function forceDeleted(Tenant $tenant)
    {
        //
    }
}
