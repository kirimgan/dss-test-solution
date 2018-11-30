<?php

use Faker\Generator as Faker;

$factory->define(App\DentalUsers::class, function (Faker $faker) {
    return [
        'userid' => $faker->userName,
        'last_accessed_date' => date('Y-m-d H:i:s')
    ];
});
