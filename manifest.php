<?php

declare(strict_types=1);

/**
 * MANIFEST modul Connection.
 *
 * Relasi many-to-many customer <-> surveyor via invite link (privacy:
 * customer & surveyor tidak saling melihat sebelum koneksi ter-approve).
 *
 * Entity: tidak punya entity master sendiri — bekerja di atas customers
 * & surveyors (HO maupun branch) milik user yang login.
 */
return [
    'menu' => [
        [
            'slug'       => 'connections',
            'label'      => 'Connections',
            'icon'       => '🔗',
            'href'       => '/connections',
            'position'   => 50,
            'permission' => 'connection:view',
        ],
    ],

    'widgets' => [
        [
            'id'    => 'connections',
            'area'  => 'right-5',
            'title' => 'Connections',
            'api'   => '/api/v1/connections',
        ],
    ],

    'rbac' => [
        'permissions' => [
            'connection:view', 'connection:create', 'connection:approve', 'connection:cancel',
        ],
        'roles' => [
            ['name' => 'connection',              'label' => 'Connection',
             'permissions' => ['connection:view']],
            ['name' => 'connection-admin',        'label' => 'Connection Admin',
             'permissions' => ['connection:*']],
        ],
        'grants' => [
            // Entitas customer/surveyor (via admin mereka) dapat mengelola koneksinya.
            'customer-admin'       => ['connection:view', 'connection:create', 'connection:approve', 'connection:cancel'],
            'customer-branch-admin'=> ['connection:view', 'connection:create', 'connection:approve', 'connection:cancel'],
            'surveyor-admin'       => ['connection:view', 'connection:create', 'connection:approve', 'connection:cancel'],
            'surveyor-branch-admin'=> ['connection:view', 'connection:create', 'connection:approve', 'connection:cancel'],
        ],
    ],
];
