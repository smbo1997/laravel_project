<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, SparkPost and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id' => '1613689988936249',
        'client_secret' => '6a4a656ab4c7a109f99a4399ff7f310a',
        'redirect' => 'http://laravel.am/en/callback',
    ],
    'google' => [
        'client_id' => '234910655171-1ang98ljrrl75dqf4t7skiiqlhvd1p2i.apps.googleusercontent.com',
        'client_secret' => 'RXT94srMnZQL0Tmx3mMZMMFa',
        'redirect' => 'http://laravel.am/en/googleCallback',
    ],
];
