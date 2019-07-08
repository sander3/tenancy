<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication Routes
Route::middleware('tenant', function () {
    Route::post('register', 'Auth\RegisterController@register')->name('auth.register')->middleware('guest');

    Route::post('email', 'Auth\LinkController@sendMagicLinkEmail')->name('auth.email')->middleware(['guest', 'throttle:5,5']);

    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout')->middleware('auth');
});

// Tenant Routes
Route::group([
    'domain'     => '{tenant}' . config('tenancy.domain'),
    'middleware' => 'tenant:explicit',
], function () {
    //
});
