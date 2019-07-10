<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Tenant\Portfolio;
use Faker\Generator as Faker;

$factory->define(Portfolio::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
