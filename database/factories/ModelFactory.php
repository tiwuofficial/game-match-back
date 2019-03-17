<?php

$factory->define(App\Model\User::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->name,
        'introduction' => $faker->text,
        'password' => password_hash('pass', PASSWORD_DEFAULT),
    ];
});
