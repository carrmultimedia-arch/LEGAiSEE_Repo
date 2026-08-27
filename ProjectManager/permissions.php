<?php

/**
 * LEGAiSEE Project Manager
 *
 * permissions.php
 *
 * Central permission registry.
 *
 * Owned By:
 * 0130_PERMISSION_MODEL.md
 *
 * Purpose:
 * Defines the canonical permission identifiers
 * used throughout the authorization system.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | User Management Permissions
    |--------------------------------------------------------------------------
    */

    'user.view',
    'user.create',
    'user.update',
    'user.delete',
    'user.manage',

    /*
    |--------------------------------------------------------------------------
    | Role Management Permissions
    |--------------------------------------------------------------------------
    */

    'role.view',
    'role.create',
    'role.update',
    'role.delete',
    'role.assign',

    /*
    |--------------------------------------------------------------------------
    | Permission Administration
    |--------------------------------------------------------------------------
    */

    'permission.view',
    'permission.assign',
    'permission.manage',

    /*
    |--------------------------------------------------------------------------
    | Project Permissions
    |--------------------------------------------------------------------------
    */

    'project.view',
    'project.create',
    'project.update',
    'project.delete',
    'project.archive',
    'project.manage',

    /*
    |--------------------------------------------------------------------------
    | Task Permissions
    |--------------------------------------------------------------------------
    */

    'task.view',
    'task.create',
    'task.update',
    'task.delete',
    'task.assign',
    'task.complete',

    /*
    |--------------------------------------------------------------------------
    | Document Permissions
    |--------------------------------------------------------------------------
    */

    'document.view',
    'document.create',
    'document.update',
    'document.delete',
    'document.download',

    /*
    |--------------------------------------------------------------------------
    | Collaboration Permissions
    |--------------------------------------------------------------------------
    */

    'comment.create',
    'comment.update',
    'comment.delete',

    'note.create',
    'note.update',
    'note.delete',

    /*
    |--------------------------------------------------------------------------
    | Reporting Permissions
    |--------------------------------------------------------------------------
    */

    'report.view',
    'report.create',
    'report.export',

    /*
    |--------------------------------------------------------------------------
    | LEGAiSEE Integration Permissions
    |--------------------------------------------------------------------------
    */

    'integration.view',
    'integration.manage',

];