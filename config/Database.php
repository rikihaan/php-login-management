<?php

function getDatabaseConfig():array{

    return [
        "database"=>[
            "test"=>[
                'url'=>'mysql:host=localhost:33061;dbname=php_login_management_test',
                'username'=>'root',
                'password'=>'1234'
            ],
            "prod"=>[
                'url'=>'mysql:host=localhost:33061;dbname=php_login_management',
                'username'=>'root',
                'password'=>'1234'
            ]
        ]
            ];

}