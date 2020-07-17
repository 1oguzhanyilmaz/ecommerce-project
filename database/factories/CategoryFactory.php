<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name'          =>  $name,
        'slug'          =>  \Str::slug($name),
        'parent_id'     =>  1,
    ];
});
