<?php

namespace Tests\Unit;

use App\Tenant;
use Tests\TestCase;
use App\Tenant\Portfolio;

class TenantTest extends TestCase
{
    public function testTenantSeparation()
    {
        $tenant1 = factory(Tenant::class)->create();

        $tenant2 = factory(Tenant::class)->create();

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
