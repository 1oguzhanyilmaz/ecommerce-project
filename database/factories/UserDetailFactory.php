<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\UserDetail::class, function (Faker $faker) {
    return [
        'address1' => $faker->address,
        'address2' => $faker->address,
        'phone1' => $faker->phoneNumber,
        'phone2' => $faker->phoneNumber,
    ];
});
