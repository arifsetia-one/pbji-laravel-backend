<?php

return [

    'post_types' => [
        0 => 'Article',
        1 => 'Movie',
        2 => 'Series',
        3 => 'Podcast',
    ],

    'category_types' => [
        0 => 'Post',
        1 => 'Event',
    ],

    'video_sources' => [
        'Local',
        'Youtube',
        'Vimeo',
    ],

    'video_qualities' => [
        '1080p' => 'Full HD',
        '720p' => '720 HD',
        '480p' => '480 SD',
        '360p' => '360 LD',
        '240p' => '240p',
        '144p' => '144p',
    ],

    'question_types' => [
        'dropdown',
        'checkbox',
        'multiple-choice',
        'date',
        'time',
        'single-line text',
        'multi-line text',
        'linear scale',
        // 'multiple-choice-grid',
        // 'checkbox-grid'
    ],

    'gender' => [
        0 => 'laki-laki',
        1 => 'perempuan'
    ]

];
