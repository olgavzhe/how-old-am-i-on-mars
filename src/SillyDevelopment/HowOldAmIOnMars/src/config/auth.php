<?php
return [
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => \SillyDevelopment\HowOldAmIOnMars\User::class,
        ],
    ],
];