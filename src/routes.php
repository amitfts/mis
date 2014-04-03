<?php

/**
 * Loggued routes without permission
 */
Route::group(array('before' => 'basicAuth', 'prefix' => Config::get('mis::config.uri')), function()
{
    Route::get('', array(
        'as' => 'indexDashboard',
        'uses' => 'Efusionsoft\Mis\Controllers\DashboardController@getIndex')
    );

    Route::get('logout', array(
        'as' => 'logout',
        'uses' => 'Efusionsoft\Mis\Controllers\DashboardController@getLogout')
    );

    Route::get('access-denied', array(
        'as' => 'accessDenied',
        'uses' => 'Efusionsoft\Mis\Controllers\DashboardController@getAccessDenied')
    );
});

/**
 * Loggued routes with permissions
 */
Route::group(array('before' => 'basicAuth|hasPermissions', 'prefix' => Config::get('mis::config.uri')), function()
{
    /**
     * User routes
     */
    Route::get('users', array(
        'as' => 'listUsers',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@getIndex')
    );

    Route::delete('user/{userId}', array(
        'as' => 'deleteUsers',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@delete')
    );

    Route::post('user/new', array(
        'as' => 'newUserPost',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@postCreate')
    );

    Route::get('user/new', array(
        'as' => 'newUser',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@getCreate')
    );

    Route::get('user/{userId}', array(
        'as' => 'showUser',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@getShow')
    );

    Route::put('user/{userId}', array(
        'as' => 'putUser',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@putShow')
    );

    Route::put('user/{userId}/activate', array(
        'as' => 'putActivateUser',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@putActivate')
    );

    /**
     * Group routes
     */
    Route::get('groups', array(
        'as' => 'listGroups',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@getIndex')
    );

    Route::post('group/new', array(
        'as' => 'newGroupPost',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@postCreate')
    );

    Route::get('group/new', array(
        'as' => 'newGroup',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@getCreate')
    );

    Route::delete('group/{groupId}', array(
        'as' => 'deleteGroup',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@delete')
    );

    Route::get('group/{groupId}', array(
        'as' => 'showGroup',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@getShow')
    );

    Route::put('group/{groupId}', array(
        'as' => 'putGroup',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@putShow')
    );

    Route::delete('group/{groupId}/user/{userId}', array(
        'as' => 'deleteUserGroup',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@deleteUserFromGroup')
    );

    Route::post('group/{groupId}/user/{userId}', array(
        'as' => 'addUserGroup',
        'uses' => 'Efusionsoft\Mis\Controllers\GroupController@addUserInGroup')
    );

    /**
     * Permission routes
     */
    Route::get('permissions', array(
        'as' => 'listPermissions',
        'uses' => 'Efusionsoft\Mis\Controllers\PermissionController@getIndex')
    );

    Route::delete('permission/{permissionId}',array(
        'as' => 'deletePermission',
        'uses' => 'Efusionsoft\Mis\Controllers\PermissionController@delete')
    );

    Route::get('permission/new', array(
        'as' => 'newPermission',
        'uses' => 'Efusionsoft\Mis\Controllers\PermissionController@getCreate')
    );

    Route::post('permission/new', array(
        'as' => 'newPermissionPost',
        'uses' => 'Efusionsoft\Mis\Controllers\PermissionController@postCreate')
    );

    Route::get('permission/{permissionId}', array(
        'as' => 'showPermission',
        'uses' => 'Efusionsoft\Mis\Controllers\PermissionController@getShow')
    );

    Route::put('permission/{permissionId}', array(
        'as' => 'putPermission',
        'uses' => 'Efusionsoft\Mis\Controllers\PermissionController@putShow')
    );
});

/**
 * Unlogged routes
 */
Route::group(array('before' => 'notAuth', 'prefix' => Config::get('mis::config.uri')), function()
{
    Route::get('login', array(
        'as' => 'getLogin',
        'uses' => 'Efusionsoft\Mis\Controllers\DashboardController@getLogin')
    );

    Route::post('login', array(
        'as' => 'postLogin',
        'uses' => 'Efusionsoft\Mis\Controllers\DashboardController@postLogin')
    );
});

Route::group(array('prefix' => Config::get('mis::config.uri')), function()
{
    /**
     * Activate a user (with view)
     */
    Route::get('user/activation/{activationCode}', array(
        'as' => 'getActivate',
        'uses' => 'Efusionsoft\Mis\Controllers\UserController@getActivate')
    );
});
