<?php

return [
    'acl' => [
        'prefix' => '/admin',
        'middleware' => ['auth:admin'],
        'guard' => 'admin',
        'guard_model' => 'App\\Models\\Admin',
        'roles' => [
            'permissions' => [
                'index' => 'roles.index',
                'create' => 'roles.create',
                'update' => 'roles.update',
                'delete' => 'roles.delete',
            ]
        ],
        'permissions' => [
            'permissions' => [
                'index' => 'permissions.index',
                'create' => 'permissions.create',
                'update' => 'permissions.update',
                'delete' => 'permissions.delete',
            ]
        ]
    ]
];
