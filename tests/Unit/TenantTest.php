<?php

namespace Tests\Unit;

use App\Tenant;
use Tests\TestCase;
use App\Tenant\Portfolio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantTest extends TestCase
{
    public function testTenantSeparation()
    {
        $tenant1 = factory(Tenant::class)->create();
        $this->createAndPopulateDatabase($tenant1);

        $tenant2 = factory(Tenant::class)->create();
        $this->createAndPopulateDatabase($tenant2);

        $tenant2->portfolios()->save(
            factory(Portfolio::class)->make()
        );

        $response1 = $this->json('GET', route('api.portfolios.index', $tenant1->slug));

        $response1
            ->assertSuccessful()
            ->assertJson($tenant1->portfolios->toArray())
            ->assertJsonMissing($tenant2->portfolios->toArray());

        $response2 = $this->json('GET', route('api.portfolios.index', $tenant2->slug));

        $response2
            ->assertSuccessful()
            ->assertJson($tenant2->portfolios->toArray());
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
