<?php

namespace Tests\Feature;

use App\Tenant;
use Tests\TestCase;

class TenantTest extends TestCase
{
    public function testTenantResolving()
    {
        $tenant = factory(Tenant::class)->create();

        $response = $this->json('GET', '/api/test/' . $tenant->slug, ['tenant' => $tenant->slug]);

        $response
            ->assertSuccessful()
            ->assertJson($tenant->toArray());
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
}
