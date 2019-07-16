<?php

namespace Tests\Feature;

use App\Tenant;
use Tests\TestCase;

class TenantTest extends TestCase
{
    public function testTenantResolving()
    {
        $tenant = factory(Tenant::class)->create();

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

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        Tenant::all()->each->delete();
    }
}
