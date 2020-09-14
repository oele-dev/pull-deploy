<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /**
     * Repository name
     */
    'repository' => env('PULLDEPLOY_REPOSITORY'),
    /**
     * Username of remote repository
     **/
    'username' => env('PULLDEPLOY_USERNAME'),
    /**
     * personal token to login in remote repository
     **/
    'personal_token' => env('PULLDEPLOY_TOKEN'),
];
