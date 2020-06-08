<?php

return [
    'square' => [
        'transforms' => [
            ['width' => 400],
            ['width' => 800],
            ['width' => 1200],
            ['width' => 1800]
        ],
        'defaults' => [
            'ratio' => 1/1
        ]
    ],
    '4x3' => [
        'transforms' => [
            ['width' => 400],
            ['width' => 800],
            ['width' => 1200],
            ['width' => 1800]
        ],
        'defaults' => [
            'ratio' => 4/3
        ]
    ]
    '16x9' => [
        'transforms' => [
            ['width' => 400],
            ['width' => 800],
            ['width' => 1200],
            ['width' => 1800]
        ],
        'defaults' => [
            'ratio' => 16/9
        ]
    ]
];
