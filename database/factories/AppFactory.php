<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(App\Distributor::class, function (Faker $faker) {
    return [
        'login' => str_replace('.', '', $faker->unique()->userName),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
    ];
});

$factory->define(App\Task::class, function (\Faker\Generator $faker) {
    static $reduce = 999;
    return [
        'fecha' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'nombre' => $faker->company,
        'direccion' => $faker->address,
        'logintud' => $faker->longitude($min = -180, $max = 180),
        'latitud' => $faker->latitude($min = -90, $max = 90),
        'mercancia' => $faker->numberBetween($min = 100, $max = 1000),
        'estado' => 'pending',
        'updated_at' => \Carbon\Carbon::now()->subSeconds($reduce--),
        'created_at' => \Carbon\Carbon::now()->subSeconds($reduce--),
    ];
});