<?php

return [
    'sqlite' => [
        'path' => realpath(__DIR__ . '/../database/main.db'),
    ],
    'dir' => [
        'pages' => realpath(__DIR__ . '/pages'),
    ]
];