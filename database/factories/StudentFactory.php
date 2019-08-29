<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'gender_id' => rand(1,2),
        'place_of_birth' => $faker->address,
        'date_of_birth' => $faker->dateTime,
        'email_address' => $faker->unique()->safeEmail
    ];
});
