<?php 

namespace Efusionsoft\Mis\Controllers;

use Efusionsoft\Mis\Controllers\BaseController;
use Efusionsoft\Mis\Services\Validators\Group as GroupValidator;
use PermissionProvider;
use View;
use Input;
use Config;
use Response;
use Sentry;
use Request;
use DB;
use URL;

class GroupController extends BaseController 
{
    /**
    * List of groups
    */
    public function getIndex()
    {
        $emptyGroup =  Sentry::getGroupProvider()->createModel();

        // Ajax search
        $groupId = Input::get('groupIdSearch');
        if(!empty($groupId))
        {
            $emptyGroup = $emptyGroup->where('id', $groupId);
        }
        $groupname = Input::get('groupnameSearch');
        if(!empty($groupname))
        {
            $emptyGroup = $emptyGroup->where('name', 'LIKE', '%'.$groupname.'%');
        }

        $groups = $emptyGroup->paginate(Config::get('mis::config.item-perge-page'));

        // ajax: reload only the content container
        if(Request::ajax())
        {
            $html = View::make(Config::get('mis::views.groups-list'), array('groups' => $groups))->render();
            
            return Response::json(array('html' => $html));
        }
        
        $this->layout = View::make(Config::get('mis::views.groups-index'), array('groups' => $groups));
        $this->layout->title = trans('mis::groups.titles.list');
        $this->layout->breadcrumb = Config::get('mis::breadcrumbs.groups');
    }
    
    /**
    * Show create group view
    */
    public function getCreate()
    {
        $permissions = PermissionProvider::findAll();

        $this->layout = View::make(Config::get('mis::views.group-create'), array('permissions' => $permissions));
        $this->layout->title = trans('mis::groups.titles.new');
        $this->layout->breadcrumb = Config::get('mis::breadcrumbs.create_group');
    }

    /**
    * Create group
    */
    public function postCreate()
    {
        $permissionsValues = Input::get('permission');
        $groupname = Input::get('groupname');
        $permissions = array();
        
        $errors = $this->_validateGroup($permissionsValues, $groupname, $permissions);
        if(!empty($errors))
        {
            return Response::json(array('groupCreated' => false, 'errorMessages' => $errors));
        }
        else 
        {
            try
            {
                // create group
                Sentry::getGroupProvider()->create(array(
                    'name' => $groupname,
                    'permissions' => $permissions,
                ));
            }
            catch (\Cartalyst\Sentry\Groups\NameRequiredException $e) {}
            catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                return Response::json(array('groupCreated' => false, 'message' => trans('mis::groups.messages.exists'), 'messageType' => 'danger'));
            }
        }

        return Response::json(array('groupCreated' => true,  'redirectUrl' => URL::route('listGroups')));
    }
    
    /**
     * Show group
     * @param type $groupId
     */
    public function getShow($groupId)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($groupId);

            $permissions = PermissionProvider::findAll();

            $groupPermissions = array();
            foreach($group->getPermissions() as $permissionValue => $key)
            {
                try
                {
                    $p = PermissionProvider::findByValue($permissionValue);
                    foreach($permissions as $key => $permission)
                    {
                        if($p->getId() === $permission->getId())
                        {
                            $groupPermissions[] = $permission;
                            unset($permissions[$key]);
                        }
                    }
                }
                catch(\Efusionsoft\Mis\Models\Permissions\PermissionNotFoundException $e){}
            }

            $userids = array();
            foreach(Sentry::getUserProvider()->findAllInGroup($group) as $user) 
            {
                $userids[] = $user->id;
            }

            // get users in group
            $users = Sentry::getUserProvider()->createModel()->join('users_groups', 'users.id', '=', 'users_groups.user_id')->where('users_groups.group_id', '=', $group->getId())
                    ->paginate(20);

            // users not in group
            $candidateUsers = array();
            $allUsers = Sentry::getUserProvider()->findAll();
            foreach($allUsers as $user)
            {
                if(!$user->inGroup($group))
                {
                    $candidateUsers[] = $user;
                }
            }

            // ajax request : reload only content container
            if(Request::ajax())
            {
                $html = View::make(Config::get('mis::views.users-in-group'), array('group' => $group, 'users' => $users, 'candidateUsers' => $candidateUsers))->render();
                
                return Response::json(array('html' => $html));
            }
            
            $this->layout = View::make(Config::get('mis::views.group-edit'), array('group' => $group, 'users' => $users, 'candidateUsers' => $candidateUsers, 'permissions' => $permissions, 'ownPermissions' => $groupPermissions));
            $this->layout->title = 'Group '.$group->getName();
            $this->layout->breadcrumb = array(
                array(
                    'title' => trans('mis::breadcrumbs.groups'), 
                    'link' => URL::route('listGroups'), 
                    'icon' => 'glyphicon-list-alt'
                ), 
                array(
                    'title' => $group->name, 
                    'link' => URL::current(), 
                    'icon' => ''
                )
            );
        }
        catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            $this->layout = View::make(Config::get('mis::views.error'), array('message' => trans('mis::groups.messages.not-found')));
        }
    }

    /**
     * Edit group action
     * @param int $groupId
     */
    public function putShow($groupId)
    {
        $permissionsValues = Input::get('permission');
        $groupname = Input::get('groupname');
        $permissions = array();

        $errors = $this->_validateGroup($permissionsValues, $groupname, $permissions);
        if(!empty($errors))
        {
            return Response::json(array('groupUpdated' => false, 'errorMessages' => $errors));
        }
        else 
        {
            try
            {
                $group = Sentry::getGroupProvider()->findById($groupId);
                $group->name = $groupname;
                $group->permissions = $permissions;

                $permissions = (empty($permissions)) ? '' : json_encode($permissions);
                // delete permissions in db
                DB::table('groups')
                    ->where('id', $groupId)
                    ->update(array('permissions' => $permissions));

                if($group->save())
                {
                    return Response::json(array('groupUpdated' => true, 'message' => trans('mis::groups.messages.success'), 'messageType' => 'success'));
                }
                else 
                {
                    return Response::json(array('groupUpdated' => false, 'message' => trans('mis::groups.messages.try'), 'messageType' => 'danger'));
                }
            }
            catch (\Cartalyst\Sentry\Groups\NameRequiredException $e) {}
            catch (\Cartalyst\Sentry\Groups\GroupExistsException $e)
            {
                return Response::json(array('groupUpdated' => false, 'message' => trans('mis::groups.messages.exists'), 'messageType' => 'danger'));
            }
        }
    }
       
    /**
     * Delete group
     * @param  int $groupId
     * @return Response
     */
    public function delete($groupId)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($groupId);
            $group->delete();
        }
        catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            return Response::json(array('deletedGroup' => false, 'message' => trans('mis::groups.messages.not-found'), 'messageType' => 'danger'));
        }
        
        return Response::json(array('deletedGroup' => true, 'message' => trans('mis::groups.messages.delete-success'), 'messageType' => 'success'));
    }
    
    /**
     * Remove user from group
     * @param int $groupId
     * @param int $userId
     * @return Response
     */
    public function deleteUserFromGroup($groupId, $userId)
    {
        try
        {
            $user = Sentry::getUserProvider()->findById($userId);
            $group = Sentry::getGroupProvider()->findById($groupId);
            $user->removeGroup($group);
            
            return Response::json(array('userDeleted' => true, 'message' => trans('mis::groups.messages.user-removed-success'), 'messageType' => 'success'));
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Response::json(array('userDeleted' => false, 'message' => trans('mis::users.messages.not-found'), 'messageType' => 'danger'));
        }
        catch(\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            return Response::json(array('userDeleted' => false, 'message' => trans('mis::groups.messages.not-found'), 'messageType' => 'danger'));
        }
    }
    
    /**
     * Add a user in a group
     * @return Response
     */
    public function addUserInGroup()
    {
        try
        {
            $userId = Input::get('userId');
            $groupId = Input::get('groupId');

            $user = Sentry::getUserProvider()->findById($userId);
            $group = Sentry::getGroupProvider()->findById($groupId);
            $user->addGroup($group);

            return Response::json(array('userAdded' => true, 'message' => trans('mis::groups.messages.user-add-success'), 'messageType' => 'success'));
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Response::json(array('userAdded' => false, 'message' => trans('mis::users.messages.not-found'), 'messageType' => 'danger'));
        }
        catch(\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            return Response::json(array('userAdded' => false, 'message' => trans('mis::groups.messages.not-found'), 'messageType' => 'danger'));
        }
    }

    /**
     * Validate group informations
     * @param array $permissionsValues
     * @param string $groupname
     * @return array
     */
    protected function _validateGroup($permissionsValues, $groupname, &$permissions)
    {
        $errors = array();
        // validate permissions
        if(!empty($permissionsValues))
        {
            foreach($permissionsValues as $key => $permission)
            {
               $permissions[$key] = 1;
            }
        }
        // validate group name
        $validator = new GroupValidator(Input::all());

        $gnErrors = array();
        if(!$validator->passes())
        {
            $gnErrors = $validator->getErrors();
        }
        
        return $gnErrors;
    }
}
