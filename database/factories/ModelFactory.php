<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Customer::class, function ($faker) {
    return [
        'cus_name' => $faker->name($gender = null | 'male' | 'female'),
        'cus_birthday_day' => $faker->dayOfMonth($max = 'now'),
        'cus_birthday_month' => $faker->month($max = 'now'),
        'cus_birthday_year' => $faker->year($max = 'now'),
        'cus_tel' => $faker->phoneNumber,
        'cus_phone' => $faker->phoneNumber,
        'cus_email' => $faker->email,
        'cus_hno' => $faker->buildingNumber,
        'cus_moo' => $faker->buildingNumber,
        'cus_soi' => $faker->streetSuffix,
        'cus_road' => $faker->streetName,
        'cus_subdis' => $faker->citySuffix,
        'cus_district' => $faker->stateAbbr,
        'cus_province' => $faker->state,
        'cus_postal' => $faker->postcode,
        'branch_id' => '1'
    ];
});

