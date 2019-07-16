<?php

namespace App\Repositories;

use App\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantRepository
{
    /**
     * Create and populate a tenant's database.
     *
     * @param  App\Tenant  $tenant
     * @return void
     */
    public function createAndPopulateDatabase(Tenant $tenant)
    {
        $name = 'tenant-' . $tenant->id;

        DB::statement("CREATE DATABASE `$name`"); // Warning: only use model attributes to avoid SQL injection

        config(['database.connections.tenant.database' => $name]);

        $path = database_path('migrations/tenant');

        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path'     => $path,
            '--realpath' => true,
        ]);
    }

    /**
     * Drop a tenant's database.
     *
     * @param  App\Tenant  $tenant
     * @return void
     */
    public function dropDatabase(Tenant $tenant)
    {
        $name = 'tenant-' . $tenant->id;

        DB::statement("DROP DATABASE `$name`"); // Warning: only use model attributes to avoid SQL injection
    }
}
