<?php

return array(
    'pdf' => array(
        'enabled' => true,
        'binary' => '"'.env('PDF_BINARY').'"',
        'timeout' => false,
        'options' => array(
            'lowquality' => false,
        ),
    ),
    'image' => array(
        'enabled' => true,
        'binary' => '"'.env('PDF_IMAGE_BINARY').'"',
        'timeout' => false,
        'options' => array(
            'lowquality' => false,
        ),
    ),
);
