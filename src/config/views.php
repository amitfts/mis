<?php 

return array(
    // layouts
    'master' => 'mis::layouts.dashboard.master',
    'header' => 'mis::layouts.dashboard.header',

    // dashboard
    'dashboard-index' => 'mis::dashboard.index',
    'login' => 'mis::dashboard.login',
    'error' => 'mis::dashboard.error',

    // users
    'users-index' => 'mis::user.index-user',
    'users-list' => 'mis::user.list-users',
    'user-create' => 'mis::user.new-user',
    'user-informations' => 'mis::user.user-informations',
    'user-profile' => 'mis::user.show-user',
    'user-activation' => 'mis::user.activation',

    // groups
    'groups-index' => 'mis::group.index-group',
    'groups-list' => 'mis::group.list-groups',
    'group-create' => 'mis::group.new-group',
    'users-in-group' => 'mis::group.list-users-group',
    'group-edit' => 'mis::group.show-group',

    // permissions
    'permissions-index' => 'mis::permission.index-permission',
    'permissions-list' => 'mis::permission.list-permissions',
    'permission-create' => 'mis::permission.new-permission',
    'permission-edit' => 'mis::permission.show-permission',
);