<?php

namespace App\Http\Controllers\Api;

use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTenant;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class CreateTenant extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\StoreTenant  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreTenant $request)
    {
        $tenant = Tenant::create($request->validated());

        // To-do: move to queue
        $this->createAndPopulateDatabase($tenant);

        return $tenant;
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
