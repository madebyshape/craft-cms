<?php

return [
    'noRatio' => [
        'transforms' => [
            ['width' => 400],
            ['width' => 800],
            ['width' => 1200]
        ],
        'defaults' => []
    ],
    '1x1' => [
        'transforms' => [
            ['width' => 400],
            ['width' => 800],
            ['width' => 1200]
        ],
        'defaults' => [
            'ratio' => 1/1
        ]
    ],
    '4x3' => [
        'transforms' => [
            ['width' => 400],
            ['width' => 800],
            ['width' => 1200]
        ],
        'defaults' => [
            'ratio' => 4/3
        ]
    ],
    '16x9' => [
        'transforms' => [
            ['width' => 400],
            ['width' => 800],
            ['width' => 1200]
        ],
        'defaults' => [
            'ratio' => 16/9
        ]
    ]
];