<?php

return [
    'propel' => [
        'generator' => [
            'schema' => [
                'autoPackage' => true,
            ],
        ],
        'database' => [
            'connections' => [
                'default' => [
                    'adapter'  => 'mysql',
                    'dsn'      => 'mysql:host=localhost;port=3306;dbname=communitycrm',
                    'user'     => 'communitycrm',
                    'password' => 'communitycrm',
                    'settings' => [
                        'charset' => 'utf8',
                    ],
                ],
            ],
        ],
    ],
];
