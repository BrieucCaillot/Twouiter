<?php

use Faker\Generator as Faker;

$factory->define(App\Follower::class, function (Faker $faker) {
    return [
        'follower_id' => function() {
            return factory(App\User::class)->create();
        },
        'user_id' => function() {
            return factory(App\User::class)->create();
        }
    ];
});
