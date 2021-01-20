<?php

// users.php file under the template path (by default @tests/unit/templates/fixtures)
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */
return [
    'username' => $faker->username,
    // 'phone' => $faker->phoneNumber,
    // 'city' => $faker->city,
    'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
    'access_token' => Yii::$app->getSecurity()->generateRandomString(),
    'status' => $faker->randomDigit(),
    // 'intro' => $faker->sentence(7, true),  // generate a sentence with 7 words
];
