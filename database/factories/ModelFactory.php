<?php

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factory;
use App\Models\{User, Location};
use Faker\Generator as Faker;
use Carbon\Carbon;

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
$factory->define(User::class, function (Faker $faker) {

    $date = Carbon::now()->subDays(rand(1, 28))->subMonth(rand(1, 12));

    return [
        'name'     => $faker->name,
        'email'    => $faker->unique()->safeEmail,
        'password' => app('hash')->make('123456'),
        'email_verified_at' => Carbon::parse($date)->addHour(rand(1, 12)),
        'created_at'  => $date,
        'updated_at'  => Carbon::parse($date)->addDay(rand(1, 28))->addHour(rand(1, 12))
    ];
});

$factory->define(Location::class, function (Faker $faker) {

    $lat = $faker->latitude;
    $lon = $faker->longitude;

    return [
        'ip'           => $faker->ipv4,
        'latitude'     => $lat,
        'longitude'    => $lon,
        'cidade'       => $faker->city,
        'estado'       => $faker->stateAbbr,
        'time_zone'    => getPHPtimezone($lat, $lon)
    ];
});


