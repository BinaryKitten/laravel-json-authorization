<?php

return [
    /**
     * Path to Laravel models. This does not recurse in folders, so you need to specify
     * an array of paths if non-standard models are to be used
     */
    'models_path'      => [
        app_path()
    ],
    /**
     * Namespace for Laravel models.
     */
    'model_namespace'  => 'App\\',
    /**
     * Namespace to AuthorizesWithJson trait
     */
    'trait_path'       => 'Voice\JsonAuthorization\App\Traits\AuthorizesWithJson',

    /**
     * List of roles/groups/etc which have absolute admin/root rights.
     * Key must resemble names from authorization_manage_types table
     */
    'absolute_rights' => [
        'roles' => [
            //'asseco-voice-admin'
        ],
        // 'groups' => [
        //     'asseco-voice-admin'
        // ],
    ],

    /**
     * For dev purposes. Setting to true will ignore authorization completely
     */
    'override_authorization' => env('OVERRIDE_AUTHORIZATION', false) === true,
];
