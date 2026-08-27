<?php

declare(strict_types=1);

return [

    'tables' => [

        'users' => [
            'id',
            'name',
            'email',
            'password_hash',
            'active',
            'created_at',
            'updated_at'
        ],

        'roles' => [
            'id',
            'name',
            'description',
            'created_at',
            'updated_at'
        ],

        'permissions' => [
            'id',
            'name',
            'description',
            'created_at',
            'updated_at'
        ],

        'role_permissions' => [
            'id',
            'role_id',
            'permission_id'
        ],

        'user_roles' => [
            'id',
            'user_id',
            'role_id'
        ],

        'attachments' => [
            'id',
            'entity_type',
            'entity_id',
            'filename',
            'storage_path',
            'mime_type',
            'file_size',
            'uploaded_by',
            'created_at'
        ],

        'activity_log' => [
            'id',
            'user_id',
            'action',
            'entity_type',
            'entity_id',
            'details',
            'created_at'
        ],

        'audit_logs' => [
            'id',
            'user_id',
            'action',
            'details',
            'created_at'
        ]

    ]

];