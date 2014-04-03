<div class="row upper-menu">
    {{ $datas['users']->links(); }}
    
    <div style="float:right;">
        @if($currentUser->hasAccess('delete-user'))
        <a id="delete-item" class="btn btn-danger">{{ trans('mis::all.delete') }}</a>
        @endif

        @if($currentUser->hasAccess('create-user'))
        <a class="btn btn-info btn-new" href="{{ URL::route('newUser') }}">{{ trans('mis::users.new') }}</a>
        @endif
    </div>
</div>
<table class="table table-striped table-bordered table-condensed">
<thead>
    <tr>
        @if($currentUser->hasAccess('delete-user'))
        <th class="col-lg-1" style="text-align: center;"><input type="checkbox" class="check-all"></th>
        @endif
        <th class="col-lg-1 hidden-xs" style="text-align: center;">Id</th>
        <th class="col-lg-1">{{ trans('mis::users.username') }}</th>
        <th class="col-lg-2 visible-lg visible-xs">{{ trans('mis::all.email') }}</th>
        <th class="col-lg-2 hidden-xs">{{ trans('mis::users.groups') }}</th>
        <th class="col-lg-2 hidden-xs">{{ trans('mis::users.permissions') }}</th>
        <th class="col-lg-1 visible-lg">{{ trans('mis::users.last-name') }}</th>
        <th class="col-lg-1 visible-lg">{{ trans('mis::users.first-name') }}</th>
        <th class="col-lg-1 hidden-xs">{{ trans('mis::users.activated') }}</th>
        @if($currentUser->hasAccess('update-user-info'))
        <th class="col-lg-1 hidden-xs">{{ trans('mis::users.banned') }}</th>
       
        <th class="col-lg-1" style="text-align: center;">{{ trans('mis::all.show') }}</th>
        @endif
    </tr>
</thead>
<tbody>
    @foreach ($datas['users'] as $user)
    <?php
    $throttle = $throttle = Sentry::findThrottlerByUserId($user->getId());
    ?>
    <tr>
        @if($currentUser->hasAccess('delete-user'))
        <td style="text-align: center;">
            <input type="checkbox" data-user-id="{{ $user->getId(); }}">
        </td>
        @endif
        <td class="hidden-xs" style="text-align: center;">{{ $user->getId() }}</td>
        <td >&nbsp;{{ $user->username }}</td>
        <td class="visible-xs visible-lg">&nbsp;{{ $user->getLogin() }}</td>
        <td class="hidden-xs">
        @foreach($user->getGroups()->toArray() as $key => $group)
            {{ $group['name'] }},
        @endforeach
        </td>
        <td class="hidden-xs">{{ json_encode($user->getPermissions()) }}</td>
        <td class="visible-lg">&nbsp;{{ $user->last_name }}</td>
        <td class="visible-lg">&nbsp;{{ $user->first_name }}</td>
        <td class="hidden-xs">{{ $user->isActivated() ? trans('mis::all.yes') : '<a class="activate-user" href="#" data-toggle="tooltip" title="'.trans('mis::users.activate').'">'.trans('mis::all.no').'</a>'}}</td>
        @if($currentUser->hasAccess('update-user-info'))
        <td class="hidden-xs">{{ $throttle->isBanned() ? trans('mis::all.yes') : trans('mis::all.no')}}</td>        
        <td style="text-align: center;">&nbsp;<a href="{{ URL::route('showUser', $user->getId()) }}">{{ trans('mis::all.show') }}</a></td>
        @endif
    </tr>
    @endforeach
</tbody>
</table>