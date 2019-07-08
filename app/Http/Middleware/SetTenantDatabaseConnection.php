<?php

namespace App\Http\Middleware;

use Closure;
use App\Tenant;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SetTenantDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $mode
     * @return mixed
     */
    public function handle(
        $request,
        Closure $next,
        string $mode = 'implicit'
    ) {
        // Get tenant by subdomain/route or input value
        $tenant = $request->route('tenant') ?? $request->input('tenant');

        if ($this->isExplicit($mode) && is_null($tenant)) {
            $exception = new ModelNotFoundException;
            $exception->setModel(Tenant::class);

            throw $exception;
        }

        if ($tenant instanceof Tenant) {
            $this->switchDatabaseConnection($tenant);
        }

        return $next($request);
    }

    public function isExplicit(string $mode)
    {
        return $mode === 'explicit';
    }

    public function switchDatabaseConnection(Tenant $tenant)
    {
        $name = 'tenant-' . $tenant->id;

        config(['database.connections.tenant.database' => $name]);
    }
}
