<?php

namespace Tests\Feature;

use App\Tenant;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantTest extends TestCase
{
    public function testTenantResolving()
    {
        $tenant = factory(Tenant::class)->create();

        $this->createAndPopulateDatabase($tenant);

        $url = route('api.portfolios.index', $tenant->slug);

        $response = $this->json('GET', $url);

        $response
            ->assertSuccessful()
            ->assertJson($tenant->portfolios->toArray());
    }

    public function testTenantCreation()
    {
        $name = 'test ' . rand();

        $response = $this->json('POST', '/api/tenants', ['name' => $name]);

        $tenant = Tenant::where('name', $name)->firstOrFail();

        $response
            ->assertSuccessful()
            ->assertJson($tenant->toArray());
    }

    private function createAndPopulateDatabase(Tenant $tenant)
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
}
