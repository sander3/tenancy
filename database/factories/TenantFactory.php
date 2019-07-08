<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tenant;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
