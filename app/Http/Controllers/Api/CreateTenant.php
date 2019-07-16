<?php

namespace App\Http\Controllers\Api;

use App\Tenant;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTenant;
use App\Http\Controllers\Controller;

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
        return Tenant::create($request->validated());
    }
}
