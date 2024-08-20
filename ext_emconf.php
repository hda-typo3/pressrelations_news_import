<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Import news from PressRelations',
    'description' => 'Import news from pressrelations.de into EXT:news',
    'category' => 'plugin',
    'author' => 'Georg Ringer',
    'author_email' => 'mail@ringer.it',
    'state' => 'beta',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
            'news' => '10.0.0-11.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
