<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StudyGroup;
use Faker\Generator as Faker;

$factory->define(StudyGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'leader' => $faker->name,
        'subject' => $faker->word,
        'starting_date' => $faker->dateTime
    ];
});
