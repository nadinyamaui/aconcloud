<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary' => '"'.env('PDF_BINARY').'"',
        'timeout' => false,
        'options' => [
            'lowquality' => false,
        ],
    ],
    'image' => [
        'enabled' => true,
        'binary' => '"'.env('PDF_IMAGE_BINARY').'"',
        'timeout' => false,
        'options' => [
            'lowquality' => false,
        ],
    ],
];
